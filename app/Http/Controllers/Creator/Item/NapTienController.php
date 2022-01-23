<?php

namespace App\Http\Controllers\Creator\Item;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\NapTienModel;
use Carbon\Carbon;
use App\Models\User;


class NapTienController extends Controller
{
    public function index(){
        $nap_tien = NapTienModel::orderBy('status','asc')->orderBy('time','desc')->get();
        return view('nap_tien')->with(compact('nap_tien'));
    }
    public function tu_choi($id){
        $nap_tien = NapTienModel::find($id);
        $nap_tien->status = 2;
        $nap_tien->save();
        return redirect()->back()->with('status','Từ chối thành công.');
    }
    public function them_tien(Request $request ,$id){
        $data = $request->all();
        $nap_tien = NapTienModel::find($id);
        $nap_tien->so_tien = $data['so_tien'];
        $nap_tien->save();
        return redirect()->back()->with('status','Thêm thành công.');
    }
    public function khuyen_mai(Request $request ,$id){
        $data = $request->all();
        $nap_tien = NapTienModel::find($id);
        $nap_tien->khuyen_mai = $data['khuyen_mai'];
        $nap_tien->save();
        return redirect()->back()->with('status','Thêm thành công.');
    }
    public function chap_nhan($id){
        $nap_tien = NapTienModel::find($id);
        if(empty($nap_tien->so_tien)){
            return redirect()->back()->with('error','Không tìm thấy.');
        }
        if(empty($nap_tien->khuyen_mai)){
            return redirect()->back()->with('error','Không tìm thấy.');
        }
        $user = User::find($nap_tien->id_nhan);
        check_data($user);
        $nap_tien->status = 1;
        $tien = $nap_tien->so_tien*$nap_tien->khuyen_mai;
        $user->kim_te = $user->kim_te + $tien;
        $user->save();
        $nap_tien->save();
        //tiêu phí
        $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
           $data_tieuphi = data_tieuphi($user->id);
           $data_tieuphi[$now]['text'] = "Nạp thành công ".number_format($tien)." kim tệ.";
           $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,2)." kim tệ.";
           save_tieuphi($data_tieuphi,$user->id);
       //end tiêu phí
        return redirect()->back()->with('status','Chấp nhận thành công.');
    }
    public function rep(Request $request ,$id){
        $data = $request->all();
        $nap_tien = NapTienModel::find($id);
        $nap_tien->noi_dung = $data['rep'];
        $nap_tien->save();
        return redirect()->back()->with('status','Thêm thành công.');
    }
}
