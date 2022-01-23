<?php

namespace App\Http\Controllers\Game\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Game\UserPath;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\VanNangModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\CongPhapModel;
use App\Models\Game\Item\ChuyenItem;

class ChuyenItemController extends Controller
{
    public function nguyen_lieu(Request $request,$item_id){
        $data = request_chuyendo($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $chuyen_do_num = ChuyenItem::where('id_gui',$uid)->get();
        $nguyen_lieu = NguyenLieuModel::find($item_id);
        $dong_te =$nguyen_lieu->dong_te;
        $ngan_te = $nguyen_lieu->ngan_te;
        $kim_te =$nguyen_lieu->kim_te;
        $data_tuido = data_tuido($uid);
        //check
            check_data($nguyen_lieu);
            if(empty(User::find($data['id_nhan'])) || empty(UserPath::find($data['id_nhan']))){
                return Redirect()->back()->with('error','Không tìm thấy người nhận.');
            }
            if($data['id_nhan'] == $uid){
                return Redirect()->back()->with('error','Không thể chuyển đến chính mình.');
            }
            if($nguyen_lieu->status==0){
                return Redirect()->back()->with('error','Nguyên liệu này đã bị khóa.');
            }
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(count($chuyen_do_num) > 5){
                return redirect()->back()->with('error','Tối đa chuyển được 5 item.');
            }
        //end check
        if(isset($data_tuido[0]['tuido_nguyenlieu'][$item_id]) && $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] >= $data['so_luong']){
            //check xem tiền phí nhỏ hơn mặc định ko + trừ phí
                $pay_dong = 0;
                if($data['dong_te'] < $dong_te){
                    $pay_dong = $dong_te*0.05;
                }else{
                    $pay_dong = $data['dong_te']*0.05;
                }
                $pay_ngan = 0;
                if($data['ngan_te'] < $ngan_te){
                    $pay_ngan = $ngan_te*0.05;
                }else{
                    $pay_ngan = $data['ngan_te']*0.05;
                }
                $pay_kim = 0;
                if($data['kim_te'] < $kim_te){
                    $pay_kim = $kim_te*0.05;
                }else{
                    $pay_kim = $data['kim_te']*0.05;
                }
                $pay_dong = $pay_dong * $data['so_luong'];
                $pay_ngan = $pay_ngan * $data['so_luong'];
                $pay_kim = $pay_kim * $data['so_luong'];
                if($user->dong_te >= $pay_dong && $user->ngan_te >= $pay_ngan && $user->kim_te >= $pay_kim){
                    $user->dong_te = $user->dong_te - $pay_dong;
                    $user->ngan_te = $user->ngan_te - $pay_ngan;
                    $user->kim_te = $user->kim_te - $pay_kim;
                    $user->save();
                }else{
                    return Redirect()->back()->with('error','Bạn không đủ tiền để trả phí chuyển.');
                }
                $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - $data['so_luong'];
                save_tuido($data_tuido,$uid);
            //end check tiền phí + trừ phí
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            //thêm sql chuyển đồ
                $chuyen_do = new ChuyenItem();
                $chuyen_do->id_gui = $uid;
                $chuyen_do->id_nhan = $data['id_nhan'];
                $chuyen_do->nguyenlieu_id = $item_id;
                $chuyen_do->so_luong = $data['so_luong'];
                $chuyen_do->dong_te = $data['dong_te'];
                $chuyen_do->ngan_te = $data['ngan_te'];
                $chuyen_do->kim_te = $data['kim_te'];
                $chuyen_do->timeout = $now->addDays(1);
                $chuyen_do->save();
            //end sql chuyển đồ
            $me = 0;
            tieu_phi_save_chuyen($uid,$nguyen_lieu,$pay_dong,$pay_ngan,$pay_kim,$me,$data);
            return Redirect()->back()->with('status','Đã chuyển '.number_format($data['so_luong']).' / '.$nguyen_lieu->ten.' đến id : '.number_format($data['id_nhan'],'0','',''));
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
    public function van_nang(Request $request,$item_id){
        $data = request_chuyendo($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $chuyen_do_num = ChuyenItem::where('id_gui',$uid)->get();
        $item = VanNangModel::find($item_id);
        $dong_te =$item->dong_te;
        $ngan_te = $item->ngan_te;
        $kim_te =$item->kim_te;
        $data_tuido = data_tuido($uid);
        //check
            check_data($item);
            if(empty(User::find($data['id_nhan'])) || empty(UserPath::find($data['id_nhan']))){
                return Redirect()->back()->with('error','Không tìm thấy người nhận.');
            }
            if($data['id_nhan'] == $uid){
                return Redirect()->back()->with('error','Không thể chuyển đến chính mình.');
            }
            if($item->status==0){
                return Redirect()->back()->with('error','Nguyên liệu này đã bị khóa.');
            }
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(count($chuyen_do_num) > 5){
                return redirect()->back()->with('error','Tối đa chuyển được 5 item.');
            }
        //end check
        if(isset($data_tuido[0]['tuido_vannang'][$item_id]) && $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] >= $data['so_luong']){
            //check xem tiền phí nhỏ hơn mặc định ko + trừ phí
                $pay_dong = 0;
                if($data['dong_te'] < $dong_te){
                    $pay_dong = $dong_te*0.05;
                }else{
                    $pay_dong = $data['dong_te']*0.05;
                }
                $pay_ngan = 0;
                if($data['ngan_te'] < $ngan_te){
                    $pay_ngan = $ngan_te*0.05;
                }else{
                    $pay_ngan = $data['ngan_te']*0.05;
                }
                $pay_kim = 0;
                if($data['kim_te'] < $kim_te){
                    $pay_kim = $kim_te*0.05;
                }else{
                    $pay_kim = $data['kim_te']*0.05;
                }
                $pay_dong = $pay_dong * $data['so_luong'];
                $pay_ngan = $pay_ngan * $data['so_luong'];
                $pay_kim = $pay_kim * $data['so_luong'];
                if(isset($item->me)){
                    $me = $item->me*0.05;
                }else{
                    $me = 0;
                }
                if($user->dong_te >= $pay_dong && $user->ngan_te >= $pay_ngan && $user->kim_te >= $pay_kim){
                    $user->dong_te = $user->dong_te - $pay_dong;
                    $user->ngan_te = $user->ngan_te - $pay_ngan;
                    $user->kim_te = $user->kim_te - $pay_kim;
                    $user->me = $user->me - $me;
                    $user->save();
                }else{
                    return Redirect()->back()->with('error','Bạn không đủ tiền để trả phí chuyển.');
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $data['so_luong'];
                save_tuido($data_tuido,$uid);
            //end check tiền phí + trừ phí
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            //thêm sql chuyển đồ
                $chuyen_do = new ChuyenItem();
                $chuyen_do->id_gui = $uid;
                $chuyen_do->id_nhan = $data['id_nhan'];
                $chuyen_do->vannang_id = $item_id;
                $chuyen_do->so_luong = $data['so_luong'];
                $chuyen_do->dong_te = $data['dong_te'];
                $chuyen_do->ngan_te = $data['ngan_te'];
                $chuyen_do->kim_te = $data['kim_te'];
                $chuyen_do->timeout = $now->addDays(1);
                $chuyen_do->save();
            //end sql chuyển đồ
            tieu_phi_save_chuyen($uid,$item,$pay_dong,$pay_ngan,$pay_kim,$me,$data);
            return Redirect()->back()->with('status','Đã chuyển '.number_format($data['so_luong']).' / '.$item->ten.' đến id : '.number_format($data['id_nhan'],'0','',''));
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
    public function dot_pha(Request $request,$item_id){
        $data = request_chuyendo($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $chuyen_do_num = ChuyenItem::where('id_gui',$uid)->get();
        $item = DotPhaModel::find($item_id);
        $dong_te =$item->dong_te;
        $ngan_te = $item->ngan_te;
        $kim_te =$item->kim_te;
        $data_tuido = data_tuido($uid);
        //check
            check_data($item);
            if(empty(User::find($data['id_nhan'])) || empty(UserPath::find($data['id_nhan']))){
                return Redirect()->back()->with('error','Không tìm thấy người nhận.');
            }
            if($data['id_nhan'] == $uid){
                return Redirect()->back()->with('error','Không thể chuyển đến chính mình.');
            }
            if($item->status==0){
                return Redirect()->back()->with('error','Nguyên liệu này đã bị khóa.');
            }
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(count($chuyen_do_num) > 5){
                return redirect()->back()->with('error','Tối đa chuyển được 5 item.');
            }
        //end check
        if(isset($data_tuido[0]['tuido_dotpha'][$item_id]) && $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] >= $data['so_luong']){
            //check xem tiền phí nhỏ hơn mặc định ko + trừ phí
                $pay_dong = 0;
                if($data['dong_te'] < $dong_te){
                    $pay_dong = $dong_te*0.05;
                }else{
                    $pay_dong = $data['dong_te']*0.05;
                }
                $pay_ngan = 0;
                if($data['ngan_te'] < $ngan_te){
                    $pay_ngan = $ngan_te*0.05;
                }else{
                    $pay_ngan = $data['ngan_te']*0.05;
                }
                $pay_kim = 0;
                if($data['kim_te'] < $kim_te){
                    $pay_kim = $kim_te*0.05;
                }else{
                    $pay_kim = $data['kim_te']*0.05;
                }
                $pay_dong = $pay_dong * $data['so_luong'];
                $pay_ngan = $pay_ngan * $data['so_luong'];
                $pay_kim = $pay_kim * $data['so_luong'];
                if(isset($item->me)){
                    $me = $item->me*0.05;
                }else{
                    $me = 0;
                }
                if($user->dong_te >= $pay_dong && $user->ngan_te >= $pay_ngan && $user->kim_te >= $pay_kim){
                    $user->dong_te = $user->dong_te - $pay_dong;
                    $user->ngan_te = $user->ngan_te - $pay_ngan;
                    $user->kim_te = $user->kim_te - $pay_kim;
                    $user->me = $user->me - $me;
                    $user->save();
                }else{
                    return Redirect()->back()->with('error','Bạn không đủ tiền để trả phí chuyển.');
                }
                $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$item_id]['so_luong'] - $data['so_luong'];
                save_tuido($data_tuido,$uid);
            //end check tiền phí + trừ phí
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            //thêm sql chuyển đồ
                $chuyen_do = new ChuyenItem();
                $chuyen_do->id_gui = $uid;
                $chuyen_do->id_nhan = $data['id_nhan'];
                $chuyen_do->dotpha_id = $item_id;
                $chuyen_do->so_luong = $data['so_luong'];
                $chuyen_do->dong_te = $data['dong_te'];
                $chuyen_do->ngan_te = $data['ngan_te'];
                $chuyen_do->kim_te = $data['kim_te'];
                $chuyen_do->timeout = $now->addDays(1);
                $chuyen_do->save();
            //end sql chuyển đồ
            tieu_phi_save_chuyen($uid,$item,$pay_dong,$pay_ngan,$pay_kim,$me,$data);
            return Redirect()->back()->with('status','Đã chuyển '.number_format($data['so_luong']).' / '.$item->ten.' đến id : '.number_format($data['id_nhan'],'0','',''));
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
    public function cong_phap(Request $request,$item_id){
        $data = request_chuyendo($request);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $chuyen_do_num = ChuyenItem::where('id_gui',$uid)->get();
        $item = CongPhapModel::find($item_id);
        $dong_te =$item->dong_te;
        $ngan_te = $item->ngan_te;
        $kim_te =$item->kim_te;
        $data_tuido = data_tuido($uid);
        //check
            check_data($item);
            if(empty(User::find($data['id_nhan'])) || empty(UserPath::find($data['id_nhan']))){
                return Redirect()->back()->with('error','Không tìm thấy người nhận.');
            }
            if($data['id_nhan'] == $uid){
                return Redirect()->back()->with('error','Không thể chuyển đến chính mình.');
            }
            if($item->status==0){
                return Redirect()->back()->with('error','Nguyên liệu này đã bị khóa.');
            }
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(count($chuyen_do_num) > 5){
                return redirect()->back()->with('error','Tối đa chuyển được 5 item.');
            }
        //end check
        if(isset($data_tuido[0]['cong_phap'][$item_id]) && $data_tuido[0]['cong_phap'][$item_id]['so_luong'] >= $data['so_luong']){
            //check xem tiền phí nhỏ hơn mặc định ko + trừ phí
                $pay_kim = 0;
                if($data['kim_te'] < $kim_te){
                    $pay_kim = ($kim_te + $ngan_te + $dong_te )*0.05;
                }else{
                    $pay_kim = ($data['kim_te'] + $data['ngan_te'] + $data['dong_te'] )*0.05;
                }
                $pay_dong = 0;
                $pay_ngan = 0;
                $pay_kim = $pay_kim * $data['so_luong'];
                if(isset($item->me)){
                    $me = $item->me*0.05;
                }else{
                    $me = 0;
                }
                if($user->dong_te >= $pay_dong && $user->ngan_te >= $pay_ngan && $user->kim_te >= $pay_kim){
                    $user->dong_te = $user->dong_te - $pay_dong;
                    $user->ngan_te = $user->ngan_te - $pay_ngan;
                    $user->kim_te = $user->kim_te - $pay_kim;
                    $user->me = $user->me - $me;
                    $user->save();
                }else{
                    return Redirect()->back()->with('error','Bạn không đủ tiền để trả phí chuyển.');
                }
                $data_tuido[0]['cong_phap'][$item_id]['so_luong'] = $data_tuido[0]['cong_phap'][$item_id]['so_luong'] - $data['so_luong'];
                save_tuido($data_tuido,$uid);
            //end check tiền phí + trừ phí
            $now = Carbon::now('Asia/Ho_Chi_Minh');
            //thêm sql chuyển đồ
                $chuyen_do = new ChuyenItem();
                $chuyen_do->id_gui = $uid;
                $chuyen_do->id_nhan = $data['id_nhan'];
                $chuyen_do->congphap_id = $item_id;
                $chuyen_do->so_luong = $data['so_luong'];
                $chuyen_do->dong_te = $data['dong_te'];
                $chuyen_do->ngan_te = $data['ngan_te'];
                $chuyen_do->kim_te = $data['kim_te'];
                $chuyen_do->timeout = $now->addDays(1);
                $chuyen_do->save();
            //end sql chuyển đồ
            tieu_phi_save_chuyen($uid,$item,$pay_dong,$pay_ngan,$pay_kim,$me,$data);
            return Redirect()->back()->with('status','Đã chuyển '.number_format($data['so_luong']).' / '.$item->ten.' đến id : '.number_format($data['id_nhan'],'0','',''));
        }else{
            return Redirect()->back()->with('error','Lỗi. ');
        }
    }
}
