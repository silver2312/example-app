<?php

namespace App\Http\Controllers\Game\Item;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Carbon\Carbon;
use App\Models\Game\Item\VanNangModel;
use App\Models\User;
use App\Models\Game\ChungTocModel;
use App\Models\Game\ChiTiet\ChiTietNgheNghiepModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\Item\CongPhapModel;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\TheChatModel;
use App\Models\Game\HeModel;

class SuDungItemController extends Controller
{
    public function van_nang(Request $request,$item_id){
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Bạn chưa nhập số lượng',
            'so_luong.numeric' => 'Số lượng phải là số',
            'so_luong.min' => 'Số lượng phải lớn hơn 0',
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $data_nhanvat = data_nhanvat($uid);
        $data_thongtin = data_thongtin($uid);
        $data_tuido = data_tuido($uid);
        $van_nang = VanNangModel::find($item_id);
        check_data($van_nang);
        $chung_toc = ChungTocModel::find($data_nhanvat[0]['chung_toc_id']);
        //check
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(empty($data_thongtin[0]) || empty($data_nhanvat[0])){
                return redirect()->back()->with('error','Chưa có nhân vật.');
            }
            $level = 0;
            if($data_thongtin[0]['level'] == 100){
                $level = 1;
            }
        //end check
        //end khai báo
        if(empty($data_tuido[0]['tuido_vannang'][$item_id]) || $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] <= 0 ){
            return redirect()->back()->with('error','Không có đồ dùng cái gì.');
        }else{
            //xoá nv
            if($item_id == 1 ){
                if(isset($data_nhanvat[0]) && isset($data_thongtin[0])){
                    unset($data_nhanvat[0]);
                    unset($data_thongtin[0]);
                    save_nhanvat($data_nhanvat,$uid);
                    save_thongtin($data_thongtin,$uid);
                    remove_cp($uid);
                    //trừ túi đồ
                        $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                        try{
                            $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                        }catch(Throwable $e){
                            $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                        }
                        save_tuido($data_tuido,$uid);
                    //end trừ túi đồ
                    return redirect()->back()->with('status','Đã xoá nhân vật.');
                }else{
                    return redirect()->back()->with('error','Vui lòng tạo cả nhân vật + thông tin.');
                }
            }
            //thẻ vip
            elseif($item_id == 2 ){
                if($user->level >= 4 && $user->level <= 10){
                    $user->level = 4;
                    $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
                    $add_time = (60*60*24)*$data['so_luong'];
                    if($user->vip_time < $now){
                        $user->vip_time = $now + $add_time;
                    }else{
                        $user->vip_time = $user->vip_time + $add_time ;
                    }
                    $user->save();
                    //trừ túi đồ
                        try{
                            $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $data['so_luong'];
                        }catch(Throwable $e){
                            $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data['so_luong'];
                        }
                        $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $data['so_luong'];
                        save_tuido( $data_tuido,$uid);
                    //end trừ túi đồ
                    return redirect()->back()->with('status','Sử dụng thẻ vip thành công.');
                }else{
                    return redirect()->back()->with('error','Cấp cao rồi muốn giáng cấp à.');
                }
            }
            //bí cao
            elseif($item_id == 3 && $level ==0 ){
                if($chung_toc->max_exp >100){
                    $data_thongtin[0]['hut_exp'] = mt_rand(100,$chung_toc->max_exp);
                }else{
                    $data_thongtin[0]['hut_exp'] = 100;
                }
                save_thongtin($data_thongtin,$uid);
                //trừ túi đồ
                    try{
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                    }
                    $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                    save_tuido($data_tuido,$uid);
                //end trừ túi đồ
                return redirect()->back()->with('status','Đã dùng một bí cao thành công.');
            }
            //luyện đan sư
            elseif($item_id == 4 ){
                if($data_nhanvat[0]['nangluong_id'] != 2){
                    return redirect()->back()->with('error','Bạn phải tu linh khí.');
                }
                if($data_thongtin[0]['tri'] < 300){
                    return redirect()->back()->with('error','Bạn phải có ít nhất 300 trí lực mới thi được.');
                }
                if($data_nhanvat[0]['nghenghiep_id'] != null){
                    return redirect()->back()->with('error','Bạn đã có nghề nghiệp.');
                }
                //trừ túi đô
                    $i = 0;
                    while($i < $data['so_luong']){
                        $result = random(0.005);
                        if($result == 0){
                            break;
                        }else{
                            $i++;
                        }
                    }
                    try{
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $i;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $i;
                    }
                    $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $i;
                    save_tuido( $data_tuido,$uid);
                //end trừ túi đồ
                if($result == 1){
                    return redirect()->back()->with('error','Chúc bạn may mắn lần sau.');
                }else{
                    $data_nhanvat[0]['nghenghiep_id'] = 2;
                    $data_nhanvat[0]['level_nghenghiep'] = 1;
                    $data_nhanvat[0]['exp_nghenghiep_hientai'] = 0;
                    $nghe_nghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',2)->where('level',2)->first();
                    $data_nhanvat[0]['exp_nghenghiep_max'] = $nghe_nghiep->exp;
                    save_nhanvat($data_nhanvat,$uid);
                    return Redirect()->back()->with('status','Sau '.$i.' lần bạn đã trở thành luyện đan sư.');
                }
            }
            //bí sơ
            elseif($item_id == 5 && $level ==0 ){
                $data_thongtin[0]['hut_exp'] = mt_rand(1,10);
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                save_thongtin($data_thongtin,$uid);
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('status','Đã dùng một bí quyển sơ cấp.');
            }
            //bí trung
            elseif($item_id == 6 && $level ==0 ){
                $data_thongtin[0]['hut_exp'] = mt_rand(1,50);
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                save_thongtin($data_thongtin,$uid);
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('status','Đã dùng một bí quyển cao cấp.');
            }
            //hoán thân
            elseif($item_id == 7){
                $gioi_tinh = $data_nhanvat[0]['gioi_tinh'];
                $link_anh = $data_nhanvat[0]["link_img"];
                $vu_khi = $data_nhanvat[0]['vu_khi_chinh'];
                //xoá nhân vật + thông tin
                    unset($data_thongtin[0]);
                    unset($data_nhanvat[0]);
                    save_nhanvat($data_nhanvat,$uid);
                    save_thongtin($data_thongtin,$uid);
                //end xoá
                    $chung_toc_id = random_chungtoc($gioi_tinh);
                    $the_chat_id = random_thechat($chung_toc_id);
                    $data_nhanvat[0]['chung_toc_id'] = $chung_toc_id;
                    $data_nhanvat[0]['the_chat_id'] = $the_chat_id;
                    $data_nhanvat[0]['gioi_tinh'] = $gioi_tinh;
                    $data_nhanvat[0]['vu_khi_chinh'] = $vu_khi;
                    $data_nhanvat[0]["link_img"] = $link_anh;
                    $data_nhanvat[0]['nghenghiep_id'] = null;
                //thêm năng lượng mới
                    $data_nangluong = data_nangluong();
                    $id_nangluong = [];
                    foreach($data_nangluong[$data_nhanvat[0]['chung_toc_id']]['nang_luong'] as $key_nl_c => $value_nl_c){
                        $id_nangluong[] = $value_nl_c;
                    }
                    $nang_luong = NangLuongModel::whereIn('id',$id_nangluong)->inRandomOrder()->first();
                    $data_nhanvat[0]['nangluong_id'] = $nang_luong->id;
                //end thêm năng lượng
                save_nhanvat($data_nhanvat,$uid);
                save_thongtin($data_thongtin,$uid);
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                save_tuido( $data_tuido,$uid);
                remove_cp($uid);

                return Redirect('/tu-luyen/nhan-vat/them-tu-luyen/');
            }
            //tịnh tâm đan
            elseif($item_id == 8){
                $tam_canh = mt_rand(1,50)* $data['so_luong'];
                $data_thongtin[0]['tam_canh'] = $data_thongtin[0]['tam_canh'] + $tam_canh;
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $data['so_luong'];
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data['so_luong'];
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $data['so_luong'];
                save_thongtin($data_thongtin,$uid);
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('status','Dùng '.$data['so_luong'].' Tịnh Tâm đan. Tâm cảnh gia tăng '.$tam_canh.' điểm');
            }
            //con đường
            elseif($item_id == 9){
                unset($data_thongtin[0]);
                save_thongtin($data_thongtin,$uid);
                $data_nhanvat[0]['nangluong_id'] = null;
                $data_nhanvat[0]['nghenghiep_id'] = null;
                save_nhanvat($data_nhanvat,$uid);
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                save_tuido( $data_tuido,$uid);
                remove_cp($uid);
                return Redirect()->back()->with('status','Đã dùng con đường ta chọn thành công.');
            }
            //quà tân thủ
            elseif($item_id == 10){
                //thẻ vip
                try{
                    $data_tuido[0]['tuido_vannang'][2]['so_luong'] = $data_tuido[0]['tuido_vannang'][2]['so_luong'] + 3;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][2]['so_luong'] = 3;
                }
                //bí quyển trung
                try{
                    $data_tuido[0]['tuido_vannang'][6]['so_luong'] = $data_tuido[0]['tuido_vannang'][6]['so_luong'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][6]['so_luong'] = 1;
                }
                //hoán thân thuật
                try{
                    $data_tuido[0]['tuido_vannang'][7]['so_luong'] = $data_tuido[0]['tuido_vannang'][7]['so_luong'] + 3;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][7]['so_luong'] = 3;
                }
                //tịnh tâm đan
                try{
                    $data_tuido[0]['tuido_vannang'][8]['so_luong'] = $data_tuido[0]['tuido_vannang'][8]['so_luong'] + 10;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][8]['so_luong'] = 10;
                }
                //con đường
                try{
                    $data_tuido[0]['tuido_vannang'][9]['so_luong'] = $data_tuido[0]['tuido_vannang'][9]['so_luong'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][9]['so_luong'] = 1;
                }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('status','Đã dùng quà tân thủ thành công.');
            }
            // Tinh chất trường sinh
            elseif($item_id == 11){
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $data['so_luong'];
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $data['so_luong'];
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data['so_luong'];
                }
                $tho_nguyen = mt_rand(1,5);
                $data_thongtin[0]['tho_nguyen'] = $data_thongtin[0]['tho_nguyen'] + $tho_nguyen*$data['so_luong'];
                save_tuido($data_tuido,$uid);
                save_thongtin($data_thongtin,$uid);
                return Redirect()->back()->with('status','Dùng '.$data['so_luong'].' Tinh chất trường sinh. Thọ nguyên gia tăng '.number_format($tho_nguyen*$data['so_luong']).' điểm');
            }
            // đổi thể chất
            elseif($item_id == 16){
                $chung_toc_id = $data_nhanvat[0]['chung_toc_id'];
                $the_chat_id = random_thechat($chung_toc_id);
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                save_tuido($data_tuido,$uid);
                $data_nhanvat[0]['the_chat_id'] = $the_chat_id;
                save_nhanvat($data_nhanvat,$uid);
                return Redirect()->back()->with('status',"Thể chất hiện tại của bạn là: ".TheChatModel::find($the_chat_id)->ten_the_chat);
            }
            // đổi quà tết
            elseif($item_id == 17){
                //thêm kim
                    $kim = mt_rand(10000,50000);
                //thêm me
                    $me = random(0.01);
                //thể chất
                    try{
                        $data_tuido[0]['tuido_vannang'][16]['so_luong'] = $data_tuido[0]['tuido_vannang'][16]['so_luong'] + 10;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][16]['so_luong'] = 10;
                    }
                //trường sinh
                    try{
                        $data_tuido[0]['tuido_vannang'][11]['so_luong'] = $data_tuido[0]['tuido_vannang'][11]['so_luong'] + 10;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][11]['so_luong'] = 10;
                    }
                //vip
                    try{
                        $data_tuido[0]['tuido_vannang'][2]['so_luong'] = $data_tuido[0]['tuido_vannang'][2]['so_luong'] + 2;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][2]['so_luong'] = 2;
                    }
                //tịnh tâm
                    try{
                        $data_tuido[0]['tuido_vannang'][8]['so_luong'] = $data_tuido[0]['tuido_vannang'][8]['so_luong'] + 8;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][8]['so_luong'] = 8;
                    }
                $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - 1;
                try{
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = 1;
                }
                save_tuido($data_tuido,$uid);
                $user->kim_te = $user->kim_te + $kim;
                if($me == 0){
                    $them_me = 1;
                }else{
                    $them_me = 0;
                }
                $user->me = $user->me + $them_me;
                $user->save();
                $text = "Bạn nhân được: ".number_format($kim)." Kim, ".number_format($them_me)." Me".", ".number_format(10)." Thể chất thay đổi tạp, ".number_format(10)." Tinh chất trường sinh, ".number_format(2)." thẻ Vip, ".number_format(8)." Tịnh tâm đan";
                return Redirect()->back()->with('status',$text);
            }
            //trận sư
            elseif($item_id == 12){
                if($data_nhanvat[0]['nangluong_id'] != 2){
                    return redirect()->back()->with('error','Bạn phải tu linh khí.');
                }
                if($data_thongtin[0]['tri'] < 300){
                    return redirect()->back()->with('error','Bạn phải có ít nhất 300 trí lực mới thi được.');
                }
                if($data_nhanvat[0]['nghenghiep_id'] != null){
                    return redirect()->back()->with('error','Bạn đã có nghề nghiệp.');
                }
                //trừ túi đô
                    $i = 0;
                    while($i < $data['so_luong']){
                        $result = random(0.005);
                        if($result == 0){
                            break;
                        }else{
                            $i++;
                        }
                    }
                    try{
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] + $i;
                    }catch(Throwable $e){
                        $data_tuido[0]['tuido_vannang'][$item_id]['su_dung'] = $i;
                    }
                    $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] = $data_tuido[0]['tuido_vannang'][$item_id]['so_luong'] - $i;
                    save_tuido( $data_tuido,$uid);
                //end trừ túi đồ
                if($result == 1){
                    return redirect()->back()->with('error','Chúc bạn may mắn lần sau.');
                }else{
                    $data_nhanvat[0]['nghenghiep_id'] = 3;
                    $data_nhanvat[0]['level_nghenghiep'] = 1;
                    $data_nhanvat[0]['exp_nghenghiep_hientai'] = 0;
                    $nghe_nghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',3)->where('level',2)->first();
                    $data_nhanvat[0]['exp_nghenghiep_max'] = $nghe_nghiep->exp;
                    save_nhanvat($data_nhanvat,$uid);
                    return Redirect()->back()->with('status','Sau '.$i.' lần bạn đã trở thành trận pháp sư.');
                }
            }
            else{
                return redirect()->back()->with('error','Đồ này chưa được sử dụng.');
            }
        }
    }
    public function nguyen_lieu(Request $request,$item_id){
        $data = $request->validate([
            'so_luong' => 'required|numeric|min:1',
            'ma_c2' => 'required|max:10'
        ],[
            'so_luong.required' => 'Bạn chưa nhập số lượng',
            'so_luong.numeric' => 'Số lượng phải là số nguyên',
            'so_luong.min' => 'Số lượng phải lớn hơn 0',
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $data_tuido = data_tuido($uid);
        $data_nhanvat = data_nhanvat($uid);
        $nguyen_lieu = NguyenLieuModel::find($item_id);
        $data_thongtin = data_thongtin($uid);

        //check
            check_data($data_thongtin);
            check_data($nguyen_lieu);
            check_data($data_tuido);
            if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
                return redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
            if(empty($data_tuido[0]['tuido_nguyenlieu']) || $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] <= 0){
                return Redirect()->back()->with('error','Bạn chưa có đồ để luyện.');
            }
            $ben = 0;
            if($data_thongtin[0]['tho_nguyen'] != -1){
                $data_thongtin[0]['tho_nguyen'] = $data_thongtin[0]['tho_nguyen'] - 0.02;
                $ben = $data_thongtin[0]['ben'] * 0.1;
            }else{
                $ben = $data_thongtin[0]['ben'] * 0.5;
            }
            if($data_thongtin[0]['ben_hentai'] < $ben){
                return Redirect()->back()->with('error','Bạn không đủ tinh lực để luyện.');
            }else{
                $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben_hentai'] - $ben;
            }
            save_thongtin($data_thongtin,$uid);
            if($data_thongtin[0]['tho_nguyen'] <= 0 && $data_thongtin[0]['tho_nguyen'] != -1){
                tu_vong($uid);
                return Redirect()->back()->with('error','Bạn đã tử vong.');
            }
        //end check
        if($item_id == 14){
            if($data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] < 111 ){
                return Redirect()->back()->with('error','Bạn chưa đủ tàn quyển công pháp để lĩnh ngộ.');
            }
            $cong_phap = CongPhapModel::where('level','<=',$data_thongtin[0]['level'])->get();
            $arr = [0=>0.2];
            foreach($cong_phap as $key => $val){
                $new = array($val->id => $val->ty_le);
                $arr += $new;
            }
            $result = random_arr($arr);
            $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - 111;
            if($result == 0){
                save_tuido($data_tuido,$uid);
                return redirect()->back()->with('error','Thiên đạo không thừa nhận công pháp bạn lĩnh ngộ.');
            }else{
                try{
                    $data_tuido[0]['cong_phap'][$result]['so_luong'] = $data_tuido[0]['cong_phap'][$result]['so_luong'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['cong_phap'][$result]['so_luong'] = 1;
                }
                save_tuido($data_tuido,$uid);
                return redirect()->back()->with('status','Bạn đã lĩnh ngộ được '.CongPhapModel::find($result)->ten.'.');
            }
        }elseif($item_id == 15){
            if($data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] < 111 ){
                return Redirect()->back()->with('error','Bạn chưa đủ Trường sinh thảo để lĩnh ngộ.');
            }
            $result = random(0.1);
            $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - 111;
            if($result == 0){
                try{
                    $data_tuido[0]['tuido_vannang'][11]['so_luong'] = $data_tuido[0]['tuido_vannang'][11]['so_luong'] + 1;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][11]['so_luong'] = 1;
                }
                save_tuido($data_tuido,$uid);
                return redirect()->back()->with('status','Bạn nhận được 1 Tinh chất trường sinh.');
            }else{
                save_tuido($data_tuido,$uid);
                return redirect()->back()->with('error','Thất bại là mẹ thành công.');
            }
        }else{
            //check xem cần nghề nghiệp Không
                $item_dotpha = DotPhaModel::where('nguyenlieu_id',$item_id)->first();
                if(empty($item_dotpha)){
                    return redirect()->back()->with('error','Nguyên liệu này không ghép được.');
                }
                if($data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] < $item_dotpha->so_luong*$data['so_luong']){
                    return Redirect()->back()->with('error','Bạn chưa đủ đồ để luyện.');
                }
                $c = 0;
                if($item_dotpha->nghenghiep_id != 5){
                    if($data_nhanvat[0]['nghenghiep_id'] == $item_dotpha->nghenghiep_id ){
                        if($item_dotpha->level_nghenghiep <= $data_nhanvat[0]['level_nghenghiep']){
                            $c = 1;
                        }else{
                            return Redirect()->back()->with('error','Cảnh giới nghề nghiệp của bạn quá thấp.');
                        }
                    }else{
                        return Redirect()->back()->with('error','Bạn chưa có hoặc sai nghề nghiệp.');
                    }
                }
                $result = random(0.5);
            //end check nghề nghiệp
            if($result == 0){
                $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - $item_dotpha->so_luong*$data['so_luong'];
                try{
                    $data_tuido[0]['tuido_dotpha'][$item_dotpha->id]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$item_dotpha->id]['so_luong'] + $data['so_luong'];
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_dotpha'][$item_dotpha->id]['so_luong'] = $data['so_luong'];
                }
                if($c == 1){
                    $data_nhanvat[0]['exp_nghenghiep_hientai'] = $data_nhanvat[0]['exp_nghenghiep_hientai'] + 1;
                    if($data_nhanvat[0]['exp_nghenghiep_hientai'] >= $data_nhanvat[0]['exp_nghenghiep_max']){
                        $data_nhanvat[0]['level_nghenghiep'] = $data_nhanvat[0]['level_nghenghiep'] + 1;
                        $data_nhanvat[0]['exp_nghenghiep_max'] = $data_nhanvat[0]['exp_nghenghiep_max']*$data_nhanvat[0]['exp_nghenghiep_max'];
                        $data_nhanvat[0]['exp_nghenghiep_hientai'] = 0;
                    }
                    save_nhanvat($data_nhanvat,$uid);
                }
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('status','Đã luyện thành công.');
            }else{
                $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$item_id]['so_luong'] - $item_dotpha->so_luong*$data['so_luong'];
                save_tuido($data_tuido,$uid);
                return Redirect()->back()->with('error','Bạn đã rất cố gắng rồi.');
            }
        }
    }
    public function cong_phap(Request $request,$item_id){
        $data = $request->validate([
            'ma_c2' => 'required|max:10'
        ],[
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự'
        ]);
        $cong_phap = CongPhapModel::find($item_id);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $data_tuido = data_tuido($uid);
        $data_congphap = data_congphap($uid);
        $data_thongtin = data_thongtin($uid);
        $data_nhanvat =data_nhanvat($uid);
        if( empty($data_nhanvat[0]) || empty($data_thongtin[0]) ){
            return redirect()->back()->with('error','Chưa có nhân vật hoặc thông tin.');
        }
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $the_chat = TheChatModel::find($data_nhanvat[0]['the_chat_id']);
        $he = HeModel::find($the_chat->he_id);
        if($cong_phap->he_id != 1){
            if($cong_phap->he_id != $he->id){
                return redirect()->back()->with('error','Thể chất của bạn không thể tu luyện công pháp này.');
            }
        }
        if(empty($data_tuido[0]['cong_phap'][$item_id]) || $data_tuido[0]['cong_phap'][$item_id]['so_luong'] <= 0){
            return redirect()->back()->with('error', 'Bạn không có công pháp này.');
        }
        if(isset($data_congphap[0])){
            return redirect()->back()->with('error', 'Bạn chỉ tu được một công pháp.');
        }
        if($cong_phap->nangluong_id != $data_nhanvat[0]['nangluong_id']){
            return redirect()->back()->with('error', 'Bạn không thể tu luyện công pháp này.');
        }

        $data_congphap[0]['cp_id'] = $item_id;
        $data_congphap[0]['exp_hentai'] = 0;

        if($cong_phap->buff == 0){
            $data_congphap[0]['exp_next'] = 100;
        }else{
            $data_congphap[0]['exp_next'] = 10000;
        }

        $data_congphap[0]['buff'] = $cong_phap->buff;
        $data_congphap[0]['buff_exp'] = $cong_phap->buff_exp;
        $data_congphap[0]['level_max'] = $cong_phap->level_max;
        $data_congphap[0]['level'] = 1;
        $data_congphap[0]['ten'] = $cong_phap->ten;
        $data_congphap[0]['gioi_thieu'] = $cong_phap->gioi_thieu;

        save_congphap($data_congphap,$uid);
        $data_tuido[0]['cong_phap'][$item_id]['so_luong'] -= 1;
        save_tuido($data_tuido,$uid);
        return redirect()->back()->with('status', 'Bạn đã học '.$cong_phap->ten.' thành công.');
    }
}
