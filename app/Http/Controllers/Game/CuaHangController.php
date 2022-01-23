<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\PathAll;
use Throwable;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\VanNangModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\CongPhapModel;
use App\Models\User;

class CuaHangController extends Controller
{
    public function nguyen_lieu($item_id,Request $request)
    {
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Không được bỏ trống số lượng',
            'so_luong.numeric' => 'Số lượng phải là số',
            'so_luong.min' => 'Số lượng phải lớn hơn bằng 1',
            'ma_c2.required' => 'Không được bỏ trống mã cấp 2',
            'ma_c2.max' => 'Mã cấp 2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $item = NguyenLieuModel::where('id',$item_id)->where('status',1)->first();
        check_data($item);
        $data_thongtin= data_thongtin($uid);
        check_data($data_thongtin);
        $dong_te = $item->dong_te*$data['so_luong'];
        $ngan_te = $item->ngan_te*$data['so_luong'];
        $kim_te = $item->kim_te*$data['so_luong'];

        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }

        if($data_thongtin[0]['level'] < $item->level){
            return Redirect()->back()->with('error','Bạn không đủ cảnh giới để mua nguyên liệu này');
        }
        if( ($user->dong_te - $dong_te >= 0) && ($user->ngan_te - $ngan_te >= 0) && ($user->kim_te - $kim_te >= 0) ){
            $user->dong_te = $user->dong_te - $dong_te ;
            $user->ngan_te = $user->ngan_te - $ngan_te ;
            $user->kim_te = $user->kim_te - $kim_te ;
            $user->save();
        }else{
            return Redirect()->back()->with('error','Không đủ tiền.');
        }
        $data_tuido = data_tuido($uid);
        if(isset($data_tuido[0]['tuido_nguyenlieu'][$item_id])){
            $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] + $data['so_luong'];
        }else{
            $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data['so_luong'];
        }
        save_tuido($data_tuido,$uid);
        $me=0;
        tieu_phi_save($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data);
        return redirect()->back()->with('status','Đã mua.');
    }
    public function van_nang(Request $request,$item_id){
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Không được bỏ trống số lượng',
            'so_luong.numeric' => 'Số lượng phải là số',
            'so_luong.min' => 'Số lượng phải lớn hơn bằng 1',
            'ma_c2.required' => 'Không được bỏ trống mã cấp 2',
            'ma_c2.max' => 'Mã cấp 2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $item = VanNangModel::where('id',$item_id)->where('status',1)->first();
        check_data($item);
        $data_thongtin= data_thongtin($uid);
        check_data($data_thongtin);
        $dong_te = $item->dong_te*$data['so_luong'];
        $ngan_te = $item->ngan_te*$data['so_luong'];
        $kim_te = $item->kim_te*$data['so_luong'];
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        if( ($user->dong_te - $dong_te >= 0) && ($user->ngan_te - $ngan_te >= 0) && ($user->kim_te - $kim_te >= 0) ){
            $user->dong_te = $user->dong_te - $dong_te ;
            $user->ngan_te = $user->ngan_te - $ngan_te ;
            $user->kim_te = $user->kim_te - $kim_te ;
            $user->save();
        }else{
            return Redirect()->back()->with('error','Không đủ tiền.');
        }
        $data_tuido = data_tuido($uid);
        //quà tân thủ
        if($item_id == 10){
            $data_tan_thu = data_tanthu();
            if(empty($data_tan_thu[$uid])){
                $data_tan_thu[$uid]['so_luong'] = 1;
                save_tanthu($data_tan_thu);
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = 1;
                }catch(Throwable $e){
                    return Redirect()->back()->with('error','Lỗi hệ thống.');
                }
            }else{
                return redirect()->back()->with('error','Bạn đã mua vật phẩm này rồi.');
            }
        }
        elseif($item_id == 14){
            if(isset($data_tuido[0]['tuido_vannang'][$item_id])){
                return redirect()->back()->with('error','Bạn đã mua vật phẩm này rồi.');
            }else{
                if($uid <= 2571){
                    try{
                        $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = 1;
                    }catch(Throwable $e){
                        return Redirect()->back()->with('error','Lỗi hệ thống.');
                    }
                }else{
                    return redirect()->back()->with('error','Bạn không trong diện đền bù.');
                }
            }
        }
        //item thường
        else{
            if(isset($data_tuido[0]['tuido_vannang'][$item_id])){
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] + $data['so_luong'];
            }else{
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data['so_luong'];
            }
        }
        save_tuido($data_tuido,$uid);
        $me=0;
        tieu_phi_save($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data);
        return redirect()->back()->with('status','Đã mua.');
    }
    public function dot_pha(Request $request,$item_id)
    {
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Không được bỏ trống số lượng',
            'so_luong.numeric' => 'Số lượng phải là số',
            'so_luong.min' => 'Số lượng phải lớn hơn bằng 1',
            'ma_c2.required' => 'Không được bỏ trống mã cấp 2',
            'ma_c2.max' => 'Mã cấp 2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $item = DotPhaModel::where('id',$item_id)->where('status',1)->first();
        check_data($item);
        $data_thongtin= data_thongtin($uid);
        check_data($data_thongtin);
        $dong_te = $item->dong_te*$data['so_luong'];
        $ngan_te = $item->ngan_te*$data['so_luong'];
        $kim_te = $item->kim_te*$data['so_luong'];

        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }

        if($data_thongtin[0]['level'] < $item->level){
            return Redirect()->back()->with('error','Bạn không đủ cảnh giới để mua nguyên liệu này');
        }
        if( ($user->dong_te - $dong_te >= 0) && ($user->ngan_te - $ngan_te >= 0) && ($user->kim_te - $kim_te >= 0) ){
            $user->dong_te = $user->dong_te - $dong_te ;
            $user->ngan_te = $user->ngan_te - $ngan_te ;
            $user->kim_te = $user->kim_te - $kim_te ;
            $user->save();
        }else{
            return Redirect()->back()->with('error','Không đủ tiền.');
        }
        $data_tuido = data_tuido($uid);
        if(isset($data_tuido[0]['tuido_dotpha'][$item_id])){
            $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] + $data['so_luong'];
        }else{
            $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] = $data['so_luong'];
        }
        save_tuido($data_tuido,$uid);
        $me=0;
        tieu_phi_save($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data);
        return redirect()->back()->with('status','Đã mua.');
    }
    public function cong_phap($item_id,Request $request)
    {
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Không được bỏ trống số lượng',
            'so_luong.numeric' => 'Số lượng phải là số',
            'so_luong.min' => 'Số lượng phải lớn hơn bằng 1',
            'ma_c2.required' => 'Không được bỏ trống mã cấp 2',
            'ma_c2.max' => 'Mã cấp 2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $item = CongPhapModel::where('id',$item_id)->where('status',1)->first();
        check_data($item);
        $data_thongtin= data_thongtin($uid);
        check_data($data_thongtin);
        $data_nhanvat = data_nhanvat($uid);
        check_data($data_nhanvat);
        $dong_te = $item->dong_te*$data['so_luong'];
        $ngan_te = $item->ngan_te*$data['so_luong'];
        $kim_te = $item->kim_te*$data['so_luong'];
        $me = $item->me*$data['so_luong'];

        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }

        if($data_thongtin[0]['level'] < $item->level){
            return Redirect()->back()->with('error','Bạn không đủ cảnh giới để mua nguyên liệu này');
        }
        if($data_nhanvat[0]['nangluong_id'] != $item->nangluong_id){
            return Redirect()->back()->with('error','Bạn tu nhầm đường.');
        }
        if( ($user->dong_te - $dong_te >= 0) && ($user->ngan_te - $ngan_te >= 0) && ($user->kim_te - $kim_te >= 0) && ($user->me - $me >= 0) ){
            $user->dong_te = $user->dong_te - $dong_te ;
            $user->ngan_te = $user->ngan_te - $ngan_te ;
            $user->kim_te = $user->kim_te - $kim_te ;
            $user->me = $user->me - $me ;
            $user->save();
        }else{
            return Redirect()->back()->with('error','Không đủ tiền.');
        }
        $data_tuido = data_tuido($uid);
        if(isset($data_tuido[0]['cong_phap'][$item_id])){
            $data_tuido[0]['cong_phap'][$item_id]['so_luong'] = $data_tuido[0]['cong_phap'][$item_id]['so_luong'] + $data['so_luong'];
        }else{
            $data_tuido[0]['cong_phap'][$item_id]['so_luong'] = $data['so_luong'];
        }
        save_tuido($data_tuido,$uid);
        tieu_phi_save($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data);
        return redirect()->back()->with('status','Đã mua.');
    }
}
