<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Throwable;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Game\ChungTocModel;
use App\Models\Game\TheChatModel;
use App\Models\Game\HinhAnhModel;
use App\Models\Game\ThienKiepModel;
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use App\Models\Game\Item\ChuyenItem;
use App\Models\Game\UserPath;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\VanNangModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\CongPhapModel;

class TuLuyenController extends Controller
{
    public function them(Request $request)
    {
        $data = $request->validate([
            'gioi_tinh' => 'required',
            'vu_khi_chinh' => 'required'
        ]);
        $uid = Auth::user()->id;
        $data_nhanvat = data_nhanvat($uid);
        if(isset($data_nhanvat[0])){
            return redirect()->back()->with('error','Nhân vật đã tồn tại.');
        }else{
            $chung_toc_id = random_chungtoc($data['gioi_tinh']);
            $the_chat_id = random_thechat($chung_toc_id);
            //khai báo để thêm vào file
            $data_nhanvat[0]['gioi_tinh'] = $data['gioi_tinh'];
            $data_nhanvat[0]['vu_khi_chinh'] = $data['vu_khi_chinh'];
            $data_nhanvat[0]['chung_toc_id'] = $chung_toc_id;
            $data_nhanvat[0]['the_chat_id'] = $the_chat_id;
            if($data['gioi_tinh'] == 0){
                $id_hinhanh = 1;
            }else{
                $id_hinhanh = 2;
            }
            $link_img = HinhAnhModel::find($id_hinhanh)->link_img;
            $data_nhanvat[0]['link_img'] = $link_img;
            $data_nhanvat[0]['nghenghiep_id'] = null;
            $data_nhanvat[0]['nangluong_id'] = null;
            //end khai báo
            save_nhanvat($data_nhanvat,$uid);
            return Redirect()->back()->with('status','Đã tạo nhân vật thành công.');
        }
    }
    public function them_nang_luong(Request $request){
        $uid = Auth::user()->id;
        $data_nhanvat = data_nhanvat($uid);
        check_data($data_nhanvat);
        $data = $request->validate([
            'nangluong_id' => 'required'
        ],
        [
            'nangluong_id.required' => 'Bạn chưa chọn năng lượng.'
        ]);
        $data_nhanvat[0]['nangluong_id'] = $data['nangluong_id'];
        save_nhanvat($data_nhanvat,$uid);
        return Redirect('tu-luyen/nhan-vat/them-tu-luyen');
        //return Redirect()->back()->with('status','Đã thêm năng lượng thành công.');
    }
    public function them_tu_luyen()
    {
        $uid = Auth::user()->id;
        check_uid($uid);
        $data_thongtin= data_thongtin($uid);
        $data_nhanvat = data_nhanvat($uid);

        $nangluong_id = $data_nhanvat[0]['nangluong_id'];
        if(isset($data_thongtin[0])){
            return redirect()->back()->with('error','Thông tin Nhân vật đã tồn tại.');
        }
        if(empty($data_nhanvat[0]['nangluong_id']) || $data_nhanvat[0]['nangluong_id'] != $nangluong_id){
            return redirect()->back()->with('error','Nhân vật chưa có năng lượng hoặc có lỗi xảy ra.');
        }
        //random may mắn
            if($data_nhanvat[0]['vu_khi_chinh'] == "5" || $data_nhanvat[0]['vu_khi_chinh'] == "6" || $data_nhanvat[0]['vu_khi_chinh'] == "7" || $data_nhanvat[0]['vu_khi_chinh'] == "8" || $data_nhanvat[0]['chung_toc_id'] == 2){
                $may_man = "E";
            }elseif($data_nhanvat[0]['vu_khi_chinh'] == 5 && $data_nhanvat[0]['chung_toc_id'] == 2){
                $may_man = "E";
            }elseif($data_nhanvat[0]['vu_khi_chinh'] == 6 && $data_nhanvat[0]['chung_toc_id'] == 2){
                $may_man = "E";
            }elseif($data_nhanvat[0]['vu_khi_chinh'] == 7 && $data_nhanvat[0]['chung_toc_id'] == 2){
                $may_man = "E";
            }elseif($data_nhanvat[0]['vu_khi_chinh'] == 8 && $data_nhanvat[0]['chung_toc_id'] == 2){
                $may_man = "E";
            }else{
                $may_man_arr = array("E" =>0.006,"E+" =>0.008, "E++" => 0.007, "D"=>0.1219,"D+"=>0.25,"D++"=>0.2,"C" => 0.1,"C+"=>0.08,"C++" => 0.08,"B"=>0.06,"B+"=>0.04,"B++"=>0.04,"A"=>0.004, "A+" => 0.002, "A++"=> 0.001, "EX" => 0.0000001);
                $may_man = random_arr($may_man_arr);
            }
        //end random may mắn
        $time = Carbon::now('Asia/Ho_Chi_Minh');
        //random chủng tộc
            $chung_toc = ChungTocModel::find($data_nhanvat[0]['chung_toc_id']);
            $the_chat = TheChatModel::find($data_nhanvat[0]['the_chat_id']);
            $rand_luc = rand(1,$chung_toc->max_luc);
            $rand_tri = rand(1,$chung_toc->max_tri);
            $rand_ben = rand(1,$chung_toc->max_ben);
            $rand_man = rand(1,$chung_toc->max_man);
        //end random chủng tộc
        $data_thongtin[0]['luc'] = $rand_luc*$the_chat->buff_luc;
        $data_thongtin[0]['tri'] = $rand_tri*$the_chat->buff_tri;
        $data_thongtin[0]['ben'] = $rand_ben*$the_chat->buff_ben;
        $data_thongtin[0]['man'] = $rand_man*$the_chat->buff_man;
        $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben'];
        $data_thongtin[0]['hut_exp'] = 0;
        $data_thongtin[0]['exp_hientai'] = 0;
        $data_thongtin[0]['exp_nextlevel'] = 100;
        $data_thongtin[0]['exp_dubi_hientai'] = 0;
        $data_thongtin[0]['exp_dubi_nextlevel'] = $data_thongtin[0]['exp_nextlevel'] / 2;
        $data_thongtin[0]['tam_canh'] = 100;
        if($chung_toc->max_thonguyen > 0){
            $data_thongtin[0]['tho_nguyen'] = mt_rand($chung_toc->max_thonguyen/2,$chung_toc->max_thonguyen);
        }else{
            $data_thongtin[0]['tho_nguyen'] = -1;
        }
        $data_thongtin[0]['tu_luyen'] = 0;
        $data_thongtin[0]['level'] = 0;
        $data_thongtin[0]['time'] = strtotime($time);
        $data_thongtin[0]['status'] = 0;
        $data_thongtin[0]['trang_thai'] = "Hoàn mỹ";
        $data_thongtin[0]['cong_duc'] = 0;
        $data_thongtin[0]['nghiep_luc'] = 0;
        $data_thongtin[0]['may_man'] = $may_man;
        $next = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',1)->first();
        $thien_kiep = ThienKiepModel::find($next->do_kiep);
        $data_thongtin[0]['phu_tro'] = $next->phu_tro;
        $data_thongtin[0]['so_luong'] = $next->so_luong;
        $data_thongtin[0]['do_kiep'] = $thien_kiep->id;
        save_thongtin($data_thongtin,$uid);
        return Redirect()->back()->with('status','Đã tạo thành công');
    }
    public function sua_anh(Request $request){
        $uid = Auth::user()->id;
        $data = $request->validate([
            'link_img' => 'required',
            'ma_c2' => 'required|string|max:10',
        ],[
            'link_img.required' => 'Bạn chưa nhập link ảnh',
            'ma_c2.required' => 'Bạn chưa nhập mã cấp 2',
            'ma_c2.max' => 'Mã c2 không được quá 10 ký tự',
            'ma_c2.string' => 'Mã c2 phải là chuỗi',
        ]);
        $user = User::find($uid);
        $data_nhanvat = data_nhanvat($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        if($user->ngan_te >= 1000){
            $user->ngan_te = $user->ngan_te - 1000;
            $user->save();
            $data_nhanvat[0]['link_img'] = $data['link_img'];
            save_nhanvat($data_nhanvat,$uid);
            return Redirect()->back()->with('status','Đã sửa thành công');
        }else{
            return Redirect()->back()->with('error','Bạn không đủ ngân tệ.');
        }
    }
    public function rut_do($id){
        $chuyen_do = ChuyenItem::find($id);
        $uid = $chuyen_do->id_gui;
        $data_tuido = data_tuido($uid);
        $path = UserPath::find($uid);
        //check
            if($uid != Auth::user()->id){
                return Redirect('/')->with('error','Bạn không có quyền thực hiện chức năng này');
            }
            if(empty($path) || !file_exists($path->path_tuido)){
                return Redirect()->back()->with('error','Vui lòng tải lại trang để hệ thống tạo file cần thiết nhân vật của bạn');
            }
            if(empty($chuyen_do)){
                return Redirect()->back()->with('error','Có lỗi xảy ra');
            }
            if($uid != $chuyen_do->id_gui){
                return Redirect()->back()->with('error','Bạn không có quyền thực hiện chức năng này');
            }
        //end check
        //lấy thông tin item
            //nguyên liệu
            if(isset($chuyen_do->nguyenlieu_id)){
                $item = NguyenLieuModel::find($chuyen_do->nguyenlieu_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //vạn năng
            elseif(isset($chuyen_do->vannang_id)){
                $item = VanNangModel::find($chuyen_do->vannang_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //đột phá
            elseif(isset($chuyen_do->dotpha_id)){
                $item = DotPhaModel::find($chuyen_do->dotpha_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //công pháp
            elseif(isset($chuyen_do->congphap_id)){
                $item = CongPhapModel::find($chuyen_do->congphap_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $data_tuido[0]['cong_phap'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }else{
                $chuyen_do->delete();
                DB::statement('ALTER TABLE chuyen_do AUTO_INCREMENT=1');
                return Redirect()->back()->with('error','Có lỗi xảy ra');
            }
        //end lấy thông tin item
        save_tuido($data_tuido,$uid);
        $chuyen_do->delete();
        DB::statement('ALTER TABLE chuyen_do AUTO_INCREMENT=1');
        return Redirect()->back()->with('status','Đã rút '.number_format($chuyen_do->so_luong).' / '.$item->ten.' về túi thành công');
    }
    public function nhan_do($id){
        $chuyen_do = ChuyenItem::find($id);
        if(empty($chuyen_do)){
            return Redirect('/')->with('error','Bạn không có quyền thực hiện chức năng này');
        }
        $uid = $chuyen_do->id_nhan;
        $data_tuido = data_tuido($uid);
        $user = User::find($uid);
        $path = UserPath::find($uid);
        $user_nhan = User::find($chuyen_do->id_gui);
        $dong_te = $chuyen_do->dong_te * $chuyen_do->so_luong;
        $ngan_te = $chuyen_do->ngan_te * $chuyen_do->so_luong;
        $kim_te = $chuyen_do->kim_te * $chuyen_do->so_luong;
        //check
            if($uid != Auth::user()->id){
                return Redirect('/')->with('error','Bạn không có quyền thực hiện chức năng này');
            }
            if(empty($user)){
                return Redirect()->back()->with('error','Bạn không thể nhận đồ.');
            }
            if(empty(User::find($chuyen_do->id_gui))){
                $chuyen_do->delete();
                return Redirect()->back()->with('error','Người gửi không tồn tại.');
            }
            if(empty($path) || !file_exists($path->path_tuido)){
                return Redirect()->back()->with('error','Vui lòng tải lại trang để hệ thống tạo file cần thiết nhân vật của bạn');
            }
            if($uid != $chuyen_do->id_nhan){
                return Redirect()->back()->with('error','Bạn không có quyền thực hiện chức năng này');
            }
            if($user->dong_te >= $dong_te && $user->ngan_te >= $ngan_te && $user->kim_te >= $kim_te){
                $user->dong_te = $user->dong_te - $dong_te;
                $user->ngan_te = $user->ngan_te - $ngan_te;
                $user->kim_te = $user->kim_te - $kim_te;
                $user->save();
                $user_nhan->dong_te = $user_nhan->dong_te + $dong_te;
                $user_nhan->ngan_te = $user_nhan->ngan_te + $ngan_te;
                $user_nhan->kim_te = $user_nhan->kim_te + $kim_te;
                $user_nhan->save();
            }else{
                return Redirect()->back()->with('error','Bạn không đủ tiền để nhận đồ');
            }
        //end check
        //lấy thông tin item
            //nguyên liệu
            if(isset($chuyen_do->nguyenlieu_id)){
                $item = NguyenLieuModel::find($chuyen_do->nguyenlieu_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //vạn năng
            elseif(isset($chuyen_do->vannang_id)){
                $item = VanNangModel::find($chuyen_do->vannang_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //đột phá
            elseif(isset($chuyen_do->dotpha_id)){
                $item = DotPhaModel::find($chuyen_do->dotpha_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }
            //công pháp
            elseif(isset($chuyen_do->congphap_id)){
                $item = CongPhapModel::find($chuyen_do->congphap_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $data_tuido[0]['cong_phap'][$item->id]['so_luong'] + $chuyen_do->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $chuyen_do->so_luong;
                }
            }else{
                return Redirect()->back()->with('error','Có lỗi xảy ra');
            }
        //end lấy thông tin item
        //lưu thông tin item
            save_tuido($data_tuido,$uid);
            //tiêu phí
                $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
                $data_tieuphi = data_tieuphi($uid);
                $data_tieuphi[$now]['text'] = "Dùng ".number_format($dong_te,2)." đồng, ".number_format($ngan_te,2)." ngân, ".number_format($kim_te,2)." kim tệ để nhận <span style='color:red'>".number_format($chuyen_do->so_luong)." / ".$item->ten."</span> từ ".User::find($chuyen_do->id_gui)->name." [".$chuyen_do->id_gui."]";
                $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,2)." kim tệ.";
                save_tieuphi($data_tieuphi,$uid);
            //end tiêu phí
            //tiêu phí nhận
                $data_tieuphi_nhan = data_tieuphi($chuyen_do->id_gui);
                $data_tieuphi_nhan[$now]['text'] = "Nhận ".number_format($dong_te,2)." đồng, ".number_format($ngan_te,2)." ngân, ".number_format($kim_te,2)." kim tệ từ ".User::find($uid)->name." [".$uid."], chuyển đồ <span style='color:red'>".number_format($chuyen_do->so_luong)." / ".$item->ten."</span>";

                $data_tieuphi_nhan[$now]['so_du'] = number_format($user_nhan->dong_te,2)." đồng tệ, ".number_format($user_nhan->ngan_te,2)." ngân tệ, ".number_format($user_nhan->kim_te,2)." kim tệ.";
                save_tieuphi($data_tieuphi_nhan,$chuyen_do->id_gui);
            //end tiêu phí nhận
            $chuyen_do->delete();
            DB::statement('ALTER TABLE chuyen_do AUTO_INCREMENT=1');
            return Redirect()->back()->with('status','Đã nhận '.number_format($chuyen_do->so_luong).' / '.$item->ten.' về túi thành công');
        //end lưu thông tin item
    }
    public function del_tp(){
        $uid = Auth::user()->id;
        $data_tieuphi = data_tieuphi($uid);
        if(empty($data_tieuphi)){
            return redirect()->back()->with('error','Bạn chưa có lịch sử tiêu phí nào.');
        }
        foreach($data_tieuphi as $key => $value){
            unset($data_tieuphi[$key]);
            save_tieuphi($data_tieuphi,$uid);
        }
        return redirect()->back()->with('status','Xóa lịch sử tiêu phí thành công.');

    }
}
