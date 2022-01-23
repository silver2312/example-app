<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\NapTienModel;
use App\Models\User;
use App\Models\Truyen\Truyen;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $truyen_nhung = Truyen::whereNotNull('nguon')->whereNotNull('link')->inRandomOrder()->take(6)->get();
        $truyen_update = Truyen::whereNotNull('nguon')->orderBy('time_up', 'desc')->take(6)->get();

        return view('home')->with(compact('truyen_nhung','truyen_update'));
    }
    public function nap_tien(Request $request){
        $data = $request->validate([
            'phuong_thuc' => 'required|numeric|min:1',
            'ma_giao_dich' => 'required|unique:nap_tien',
            'id_nhan' => 'required|numeric|min:0',
        ],
        [
            'phuong_thuc.required' => 'Phương thức không được bỏ trống.',
            'phuong_thuc.numeric' => 'Phương thức không đúng.',
            'phuong_thuc.min' => 'Phương thức không đúng.',
            'ma_giao_dich.required' => 'Mã giao dịch không được bỏ trống.',
            'ma_giao_dich.unique' => 'Mã giao dịch đã tồn tại.',
            'id_nhan.required' => 'ID nhận không được bỏ trống.',
            'id_nhan.numeric' => 'ID nhận không đúng.',
            'id_nhan.min' => 'ID nhận không được nhỏ hơn 0.',
        ]);
        $user = User::find($data['id_nhan']);
        if(empty($user)){
            return redirect()->back()->with('error', 'ID người nhận không tồn tại.');
        }
        $nap_tien = new NapTienModel;
        $nap_tien->uid = Auth::user()->id;
        $nap_tien->id_nhan = $data['id_nhan'];
        $nap_tien->phuong_thuc = $data['phuong_thuc'];
        $nap_tien->ma_giao_dich = $data['ma_giao_dich'];
        $nap_tien->time = Carbon::now('Asia/Ho_Chi_Minh');
        $nap_tien->status = 0;
        $nap_tien->save();
        return redirect()->back()->with('status','Gửi thành công.');
    }
    public function doi_tien(Request $request){
        $data = $request->validate(
        [
            'so_tien' => 'required|numeric|min:100',
            'phuong_thuc' => 'required',
            'ma_c2' => 'required|max:10|string',
        ],
        [
            'so_tien.required' => 'Bạn chưa nhập số tiền',
            'so_tien.numeric' => 'Số tiền phải là số',
            'so_tien.min' => 'Số tiền phải lớn hơn 100',
            'phuong_thuc.required' => 'Bạn chưa chọn phương thức',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $data_tieuphi = data_tieuphi($uid);
        if($data['phuong_thuc'] == 1){

            if($data['so_tien'] > $user->kim_te){
                return redirect('/')->with('error','Bạn không đủ kim tệ để chuyển');
            }
            $user->kim_te = $user->kim_te - $data['so_tien'];
            $user->ngan_te = $user->ngan_te + $data['so_tien']*99;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." kim tệ thành ".number_format($data['so_tien']*99,2)." ngân tệ";

        }elseif($data['phuong_thuc'] == 2){

            if($data['so_tien'] > $user->kim_te){
                return redirect('/')->with('error','Bạn không đủ kim tệ để chuyển');
            }
            $user->kim_te = $user->kim_te - $data['so_tien'];
            $user->dong_te = $user->dong_te + $data['so_tien'] * 9900;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." kim tệ thành ".number_format($data['so_tien'] * 9900,2)." đồng tệ";

        }elseif($data['phuong_thuc'] == 3){

            if($data['so_tien'] > $user->ngan_te){
                return redirect('/')->with('error','Bạn không đủ ngân tệ để chuyển');
            }
            $user->ngan_te = $user->ngan_te - $data['so_tien'];
            $user->kim_te = $user->kim_te + $data['so_tien'] / 101;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." ngân tệ thành ".number_format($data['so_tien'] / 101,2)." kim tệ";

        }elseif($data['phuong_thuc'] == 4){

            if($data['so_tien'] > $user->ngan_te){
                return redirect('/')->with('error','Bạn không đủ ngân tệ để chuyển');
            }
            $user->ngan_te = $user->ngan_te - $data['so_tien'];
            $user->dong_te = $user->dong_te + $data['so_tien'] * 99;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." ngân tệ thành ".number_format($data['so_tien']*99,2)." đồng tệ";

        }elseif($data['phuong_thuc'] == 5){

            if($data['so_tien'] > $user->dong_te){
                return redirect('/')->with('error','Bạn không đủ đồng tệ để chuyển');
            }
            $user->dong_te = $user->dong_te - $data['so_tien'];
            $user->kim_te = $user->kim_te + $data['so_tien'] / 10100;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." đồng tệ thành ".number_format($data['so_tien'] / 10100,3)." kim tệ";

        }else{

            if($data['so_tien'] > $user->dong_te){
                return redirect('/')->with('error','Bạn không đủ đồng tệ để chuyển');
            }
            $user->dong_te = $user->dong_te - $data['so_tien'];
            $user->ngan_te = $user->ngan_te + $data['so_tien'] / 101;
            $data_tieuphi[$now]['text'] = "Bạn vừa đổi ".number_format($data['so_tien'])." đồng tệ thành ".number_format($data['so_tien'] / 101,2)." ngân tệ";

        }
        $user->save();
            //thêm danh sách tiêu phí
                $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,3)." kim tệ.";
                save_tieuphi($data_tieuphi,$uid);
            //end thêm danh sách tiêu phí
        return redirect()->back()->with('status','Đổi tiền thành công.');
    }
}
