<?php

namespace App\Http\Controllers\Game\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Game\Item\VanNangModel;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\CongPhapModel;

class BanItemController extends Controller
{
    public function van_nang(Request $request,$item_id){
        $data = request_bando($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $van_nang = VanNangModel::find($item_id);
        $data_tuido = data_tuido($uid);
        // check
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            check_data($van_nang);
        //end check

        if(isset($data_tuido[0]['tuido_vannang'][$item_id]) && $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] >= $data['so_luong']){

            $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $data['so_luong'];
            try{
                $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $data['so_luong'];
            }catch(Throwable $e){
                $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data['so_luong'];
            }
            save_tuido($data_tuido,$uid);

            $dong_te = sqrt($van_nang->dong_te + $van_nang->ngan_te + $van_nang->kim_te)*$data['so_luong'];
            $ngan_te = 0;
            $kim_te = 0;
            $me = 0;
            $user->dong_te = number_format($user->dong_te + $dong_te,2, '.', '');
            //thêm danh sách tiêu phí
                $dong_te = number_format($dong_te,2);
                $ngan_te = number_format($ngan_te,2);
                $kim_te = number_format($kim_te,2);
                tieu_phi_save_ban($uid,$van_nang,$dong_te,$ngan_te,$kim_te,$me,$data);
                $user->save();
            //end thêm danh sách tiêu phí
            return Redirect()->back()->with('status','Đã bán được '.$dong_te.' đồng tệ.');
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
    public function nguyen_lieu(Request $request,$item_id){
        $data = request_bando($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);

        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $nguyen_lieu = NguyenLieuModel::find($item_id);
        $data_tuido = data_tuido($uid);
        if(isset($data_tuido[0]['tuido_nguyenlieu'][$item_id]) && $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] >= $data['so_luong']){

            $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - $data['so_luong'];
            save_tuido($data_tuido,$uid);

            $dong_te = sqrt($nguyen_lieu->dong_te)*$data['so_luong'];
            $ngan_te = sqrt($nguyen_lieu->ngan_te)*$data['so_luong'];
            $kim_te = sqrt($nguyen_lieu->kim_te)*$data['so_luong'];
            $me = 0;
            $user->dong_te = number_format($user->dong_te + $dong_te,2, '.', '');
            $user->ngan_te =  number_format($user->ngan_te + $ngan_te,2, '.', '');
            $user->kim_te =  number_format($user->kim_te + $kim_te,2, '.', '');
            //thêm danh sách tiêu phí
                $dong_te = number_format($dong_te,2);
                $ngan_te = number_format($ngan_te,2);
                $kim_te = number_format($kim_te,2);
                tieu_phi_save_ban($uid,$nguyen_lieu,$dong_te,$ngan_te,$kim_te,$me,$data);
            //end thêm danh sách tiêu phí
            $user->save();
            return Redirect()->back()->with('status','Đã bán được '.$dong_te.' đồng tệ, '.$ngan_te.' ngân tệ, '.$kim_te.' kim tệ.');
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }

    }
    public function dot_pha(Request $request,$item_id){
        $data = request_bando($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $dot_pha = DotPhaModel::find($item_id);
        //check
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        check_data($dot_pha);
        if($item_id == 7){
            return redirect()->back()->with('error','Nhân quả không thể thay đổi.');
        }
        $data_tuido = data_tuido($uid);
        if(isset($data_tuido[0]['tuido_dotpha'][$item_id]) && $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] >= $data['so_luong']){

            $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] - $data['so_luong'];
            save_tuido($data_tuido,$uid);

            $dong_te = sqrt( $dot_pha->dong_te )*$data['so_luong'] ;
            $ngan_te = sqrt( $dot_pha->ngan_te + $dot_pha->kim_te )*$data['so_luong'];
            $kim_te = 0;
            $me = 0;
            $user->dong_te = number_format($user->dong_te + $dong_te,2, '.', '');
            //thêm danh sách tiêu phí
                $dong_te = number_format($dong_te,2);
                $ngan_te = number_format($ngan_te,2);
                tieu_phi_save_ban($uid,$dot_pha,$dong_te,$ngan_te,$kim_te,$me,$data);
            //end thêm danh sách tiêu phí
            $user->save();
            return Redirect()->back()->with('status','Đã bán được '.$dong_te.' đồng tệ, '.$ngan_te.' ngân tệ.');
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
    public function cong_phap(Request $request,$item_id){
        $data = request_bando($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $data_tuido = data_tuido($uid);
        $cong_phap = CongPhapModel::find($item_id);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        if(isset($data_tuido[0]['cong_phap'][$item_id]) && $data_tuido[0]['cong_phap'][$item_id]['so_luong'] >= $data['so_luong']){

            $data_tuido[0]['cong_phap'][$item_id]['so_luong'] = $data_tuido[0]['cong_phap'][$item_id]['so_luong'] - $data['so_luong'];
            save_tuido($data_tuido,$uid);

            $dong_te = sqrt( $cong_phap->dong_te + $cong_phap->ngan_te + $cong_phap->kim_te + $cong_phap->me )*$data['so_luong'] ;
            $ngan_te = 0;
            $kim_te = 0;
            $me = 0;
            $user->dong_te = number_format($user->dong_te + $dong_te,2, '.', '');
            //thêm danh sách tiêu phí
                $dong_te = number_format($dong_te,2);
                tieu_phi_save_ban($uid,$cong_phap,$dong_te,$ngan_te,$kim_te,$me,$data);
            //end thêm danh sách tiêu phí
            $user->save();
            return Redirect()->back()->with('status','Đã bán được '.$dong_te.' đồng tệ.');
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
}
