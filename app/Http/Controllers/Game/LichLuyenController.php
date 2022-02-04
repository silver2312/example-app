<?php

namespace App\Http\Controllers\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Models\User;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use App\Models\Game\ChungTocModel;
use App\Models\Game\TheChatModel;
use App\Models\Game\ThienKiepModel;


class LichLuyenController extends Controller
{
    public function index(){
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $data_nhanvat = data_nhanvat($uid);
        $data_thongtin = data_thongtin($uid);
        check_data($data_thongtin);
        check_data($data_nhanvat);
        $data_tuido = data_tuido($uid);
        $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        //check
            if($data_thongtin[0]['tu_luyen'] == 3 || $data_thongtin[0]['tam_canh'] <= 0){
                $data_thongtin[0]['tu_luyen'] = 3;
                save_thongtin($data_thongtin,$uid);
                return "tam_ma";
            }
            if($data_thongtin[0]['tho_nguyen'] <= 0 && $data_thongtin[0]['tho_nguyen'] != -1){
                tu_vong($uid);
                return "die";
            }
            if($data_thongtin[0]['exp_hientai'] >= $data_thongtin[0]['exp_nextlevel'] ){
                if($data_thongtin[0]['do_kiep'] == 1){
                    if($data_thongtin[0]['phu_tro'] == 1){
                        $data_thongtin[0]['tu_luyen'] = 4;
                        save_thongtin($data_thongtin,$uid);
                        return "len_cap";
                    }elseif( $data_thongtin[0]['phu_tro'] == 7){
                        if(isset($data_tuido[0]['tuido_dotpha'][7]) && $data_tuido[0]['tuido_dotpha'][7]['so_luong'] <= 0){
                            $data_thongtin[0]['tu_luyen'] = 4;
                            save_thongtin($data_thongtin,$uid);
                            return "len_cap";
                        }else{
                            $data_thongtin[0]['tu_luyen'] = 2;
                            save_thongtin($data_thongtin,$uid);
                        }
                    }else{
                        if( isset($data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]) && $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] >= $data_thongtin[0]['so_luong'] ){
                            $data_thongtin[0]['tu_luyen'] = 4;
                            save_thongtin($data_thongtin,$uid);
                            $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] - $data_thongtin[0]['so_luong'];
                            save_tuido($data_tuido,$uid);
                            return "len_cap";
                        }else{
                            $data_thongtin[0]['tu_luyen'] = 2;
                            save_thongtin($data_thongtin,$uid);
                        }
                    }
                }else{
                    $data_thongtin[0]['tu_luyen'] = 2;
                    save_thongtin($data_thongtin,$uid);
                }
            }
            if(empty($data_thongtin[0]) || empty($data_nhanvat[0])){
                return "err";
            }
            if($uid != Auth::user()->id){
                return "err";
            }
            if($data_thongtin[0]['ben_hentai'] <= $data_thongtin[0]['ben'] * 0.1){
                $data_thongtin[0]['status'] = 1;
                save_thongtin($data_thongtin,$uid);
            }
        //end check
        echo Carbon::now('Asia/Ho_Chi_Minh');
        if($now - $data_thongtin[0]['time'] >= 60){
            if($data_thongtin[0]['tho_nguyen'] > 0){
                $data_thongtin[0]['tho_nguyen'] = $data_thongtin[0]['tho_nguyen'] - 0.02;
            }
            if($data_thongtin[0]['trang_thai'] == "Trọng thương"){
                $ben = pow($data_thongtin[0]['ben'],10);
                $data_thongtin[0]['ben_hentai'] -= $ben;
                echo "<p>Dùng ".format_num($ben)." tinh lực để hồi phục trọng thương.</p>";
            }elseif($data_thongtin[0]['trang_thai'] == "Tiểu thương"){
                $ben = pow($data_thongtin[0]['ben'],2);
                $data_thongtin[0]['ben_hentai'] -= $ben;
                echo "<p>Dùng ".format_num($ben)." tinh lực để hồi phục tiểu thương.</p>";
            }else{
                $data_thongtin[0]['trang_thai'] = "Hoàn mỹ";
                if($data_thongtin[0]['status'] == 0){
                    echo "<h3 style='color:green'>Đang lịch luyện.</h3>";
                    //trừ tinh lực
                        if($data_thongtin[0]['tho_nguyen'] > 0){
                            $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben_hentai'] - $data_thongtin[0]['ben'] * 0.05;
                        }else{
                            $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben_hentai'] - $data_thongtin[0]['ben'] * 0.1;
                        }
                    //end trừ tinh lực
                    // hút exp
                        $curr_exp = $data_thongtin[0]['hut_exp'];
                        $max = mt_getrandmax();
                        $ran = mt_rand()/mt_getrandmax();
                        if($curr_exp > $max){
                            $hut_exp = $curr_exp*$ran;
                        }else{
                            $hut_exp = mt_rand(sqrt($curr_exp),$curr_exp);
                        }
                        $data_congphap = data_congphap($uid);
                        if($data_thongtin[0]['tu_luyen'] == 0){
                            if(isset($data_congphap[0])){
                                if($data_congphap[0]['buff'] == 0){
                                    $hut_exp += $data_thongtin[0]['hut_exp']*$data_congphap[0]['buff_exp']/100;
                                }else{
                                    $hut_exp += $data_thongtin[0]['hut_exp']*$data_congphap[0]['buff_exp'];
                                }
                            }
                            $hut_exp = vip($uid,$hut_exp,$curr_exp);
                            $data_thongtin[0]['exp_hientai'] = $data_thongtin[0]['exp_hientai'] + $hut_exp;
                            $hut_exp = format_num($hut_exp);
                            echo "<p>Một tháng qua bạn nhận được ".$hut_exp." exp.</p>";
                        }else{
                            if($data_thongtin[0]['exp_dubi_hientai'] < $data_thongtin[0]['exp_dubi_nextlevel']){
                                $hut_exp_dubi =(int)sqrt($hut_exp)*$ran;
                                $data_thongtin[0]['exp_dubi_hientai'] = $data_thongtin[0]['exp_dubi_hientai'] + $hut_exp_dubi;
                                $hut_exp_dubi = format_num($hut_exp_dubi);
                                echo "<p>Một tháng qua bạn lắng đọng ".$hut_exp_dubi." exp đa dụng.</p>";
                            }
                        }
                    //end hút exp
                    //thêm tiền
                        $tien = mt_rand(-20,35);
                        $user->dong_te = $user->dong_te + $tien;
                        $user->save();
                        if($tien > 0){
                            echo "<p style='color:green'>Một tháng tích góp được ".$tien." đồng.</p>";
                        }elseif($tien < 0){
                            echo "<p style='color:red'>Một tháng tích góp bị trộm ".($tien*-1)." đồng.</p>";
                            $data_thongtin[0]['tam_canh'] = $data_thongtin[0]['tam_canh'] - 1;
                            echo "<p style='color:red'>Bị trộm tiền. Bạn hận tên trộm tâm cảnh hạ một điểm.</p>";
                        }else{
                            echo "<p>Một tháng không tích góp được gì.</p>";
                        }
                    //end thêm tiền
                    //thêm nguyên liệu
                        $nguyen_lieu = NguyenLieuModel::where('level','<=',$data_thongtin[0]['level'])->where('id','!=',1)->where('ngan_te',0)->where('kim_te',0)->inRandomOrder()->first();
                        $ty_le = tyle_luck($data_thongtin[0]['may_man']);
                        $result = random($ty_le);
                        if($result == 0){
                            try{
                                $data_tuido[0]['tuido_nguyenlieu'][$nguyen_lieu->id]['so_luong'] = $data_tuido[0]['tuido_nguyenlieu'][$nguyen_lieu->id]['so_luong'] + 1;
                            }catch(Throwable $e){
                                $data_tuido[0]['tuido_nguyenlieu'][$nguyen_lieu->id]['so_luong'] = 1;
                            }
                            echo "<p style='color:green'>Một tháng may mắn nhận được ".$nguyen_lieu->ten.".</p>";
                        }else{
                            echo "<p style='color:red'>Một tháng bạn chưa nhận được gì.</p>";
                        }
                    //end thêm nguyên liệu
                }else{
                    echo "<h3>Đang bế quan</h3><br>";
                    $ben = $data_thongtin[0]['ben'];
                    if($user->level > 4 && $user->level <=10){
                        $tinh_luc = $ben * 0.05;
                    }elseif($user->level >= 3){
                        $tinh_luc = $ben * 0.15;
                    }elseif($user->level >= 1){
                        $tinh_luc = $ben * 0.25;
                    }else{
                        $tinh_luc = $ben;
                    }
                    $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben_hentai'] + $tinh_luc;
                    $tinh_luc = format_num($tinh_luc);
                    if($data_thongtin[0]['ben_hentai'] >= $ben){
                        $data_thongtin[0]['ben_hentai'] = $ben;
                        $data_thongtin[0]['status'] = 0;
                    }
                    echo "<p style='color:green'>Bế quan một tháng hồi phục ".$tinh_luc." tinh lực</p>";
                }
            }
            $data_thongtin[0]['time'] = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
            save_thongtin($data_thongtin,$uid);
        }else{
            echo "<h3 style='color:red'>Bạn đang bị làm phiền.</h3>";
            $data_thongtin[0]['tam_canh'] = $data_thongtin[0]['tam_canh'] - 0.5;
            $data_thongtin[0]['time'] = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
            save_thongtin($data_thongtin,$uid);
        }
        try{
            $data_tuido[0]['tuido_dotpha'][7]['so_luong'] = $data_tuido[0]['tuido_dotpha'][7]['so_luong'] + 1;
        }catch(Throwable $e){
            $data_tuido[0]['tuido_dotpha'][7]['so_luong'] = 1;
        }
        save_tuido($data_tuido,$uid);
    }
    public function len_cap(){
        $uid = Auth::user()->id;
        $data_thongtin = data_thongtin($uid);
        $data_nhanvat = data_nhanvat($uid);
        //check
            if(empty($data_nhanvat[0] || empty($data_thongtin[0]))){
                return redirect('/tu-luyen/nhan-vat/'.$uid)->with('error','Bạn chưa có nhân vật.');
            }
            if($data_thongtin[0]['tu_luyen'] != 4){
                return redirect()->back()->with('error','Bạn chưa thể lên cấp.');
            }
            if($data_thongtin[0]['level'] >= 100){
                $next = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',100)->first();
            }else{
                $next = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',$data_thongtin[0]['level'] + 1)->first();
            }
            if($data_thongtin[0]['level'] >= 98){
                $last = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',100)->first();
            }else{
                $last = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',$data_thongtin[0]['level'] + 2)->first();
            }
        //end check
        //random
            $chung_toc = ChungTocModel::find($data_nhanvat[0]['chung_toc_id']);
            $the_chat = TheChatModel::find($data_nhanvat[0]['the_chat_id']);
            $luc = mt_rand(1,sqrt($chung_toc->max_luc)) * mt_rand(1,(sqrt($the_chat->buff_luc)));
            $tri = mt_rand(1,sqrt($chung_toc->max_tri)) * mt_rand(1,(sqrt($the_chat->buff_tri)));
            $ben = mt_rand(1,(sqrt($chung_toc->max_ben))) * mt_rand(1,(sqrt($the_chat->buff_ben)));
            $man = mt_rand(1,(sqrt($chung_toc->max_man))) * mt_rand(1,(sqrt($the_chat->buff_man)));
            if($chung_toc->max_thonguyen > 0){
                $tho_nguyen = mt_rand(1,sqrt($chung_toc->max_thonguyen));
            }
            $hut_exp = mt_rand(1,(sqrt($chung_toc->max_exp))) * mt_rand(1,(sqrt($the_chat->buff_exp)));
        //end random
        //khai báo
            $curr_luc = $data_thongtin[0]['luc'];
            $curr_tri = $data_thongtin[0]['tri'];
            $curr_ben = $data_thongtin[0]['ben'];
            $curr_man = $data_thongtin[0]['man'];
            $curr_exp = $data_thongtin[0]['hut_exp'];
            $max = mt_getrandmax();
            $ran = mt_rand()/mt_getrandmax();
        //end khai báo
        $data_thongtin[0]['tu_luyen'] = 0;
        $data_thongtin[0]['level'] = $data_thongtin[0]['level'] + 1;
        $data_thongtin[0]['exp_hientai'] = 0;
        $data_thongtin[0]['tam_canh'] = $data_thongtin[0]['tam_canh'] + mt_rand(10,100);
        //exp cấp tiếp theo
            if($last->exp == 1){
                $data_thongtin[0]['exp_nextlevel'] = $data_thongtin[0]['exp_nextlevel'] * $data_thongtin[0]['exp_nextlevel'];
                $data_thongtin[0]['exp_dubi_nextlevel'] = $data_thongtin[0]['exp_dubi_nextlevel']*10;
            }else{
                $data_thongtin[0]['exp_nextlevel'] = $data_thongtin[0]['exp_nextlevel'] * $last->exp;
                $data_thongtin[0]['exp_dubi_nextlevel'] = $data_thongtin[0]['exp_dubi_nextlevel']*2;
            }
        //end exp cấp tiếp theo
        //lực
            if($next->buff_luc == 1){
                if($curr_luc > $max){
                    $data_thongtin[0]['luc'] = $curr_luc * ($curr_luc*$ran) * $luc;
                }else{
                    $data_thongtin[0]['luc'] = $curr_luc * mt_rand(sqrt($data_thongtin[0]['luc']),$data_thongtin[0]['luc']) * $luc;
                }
            }else{
                $data_thongtin[0]['luc'] = $data_thongtin[0]['luc'] * $next->buff_luc;
            }
        //end lực
        //trí
            if($next->buff_tri == 1){
                if($curr_tri > $max){
                    $data_thongtin[0]['tri'] = $curr_tri * ($curr_tri * $ran) * $tri;
                }else{
                    $data_thongtin[0]['tri'] = $curr_tri * mt_rand(sqrt($curr_tri),$curr_tri) * $tri;
                }
            }else{
                $data_thongtin[0]['tri'] = $curr_tri * $next->buff_tri;
            }
        //end trí
        //bền
            if($next->buff_ben == 1){
                if($curr_ben > $max){
                    $data_thongtin[0]['ben'] = $curr_ben * ($curr_ben * $ran) * $ben;
                }else{
                    $data_thongtin[0]['ben'] = $curr_ben * mt_rand(sqrt($curr_ben),$curr_ben) * $ben;
                }
            }else{
                $data_thongtin[0]['ben'] = $curr_ben * $next->buff_ben;
            }
            $data_thongtin[0]['ben_hentai'] = $data_thongtin[0]['ben_hentai'] + $data_thongtin[0]['ben'];
        //end bền
        // mẫn
            if($next->buff_man == 1){
                if($curr_man > $max){
                    $data_thongtin[0]['man'] = $curr_man * ($curr_man * $ran) * $man;
                }else{
                    $data_thongtin[0]['man'] = $curr_man * mt_rand(sqrt($curr_man), $curr_man) * $man;
                }
            }else{
                $data_thongtin[0]['man'] = (int)$curr_man* $next->buff_man;
            }
        // end mẫn
        // thọ nguyên
            if($next->tho_nguyen == -1 || $chung_toc->max_thonguyen == -1){
                $data_thongtin[0]['tho_nguyen'] = -1;
            }else{
                $data_thongtin[0]['tho_nguyen'] = $data_thongtin[0]['tho_nguyen'] + $tho_nguyen + $next->tho_nguyen;
            }
        // end thọ nguyên
        //hút exp
            if($next->hut_exp == 1){
                if($curr_exp > $max){
                    $data_thongtin[0]['hut_exp'] = $curr_exp * ($curr_exp * $ran) * $hut_exp;
                }else{
                    $data_thongtin[0]['hut_exp'] = $curr_exp * mt_rand(sqrt($curr_exp),$curr_exp) * $hut_exp;
                }
            }else{
                $data_thongtin[0]['hut_exp'] = $curr_exp * $next->hut_exp;
            }
        //end hút exp
        $data_thongtin[0]['phu_tro'] = $last->phu_tro;
        $data_thongtin[0]['so_luong'] = $last->so_luong;
        $data_thongtin[0]['do_kiep'] = $last->do_kiep;
        // dump($last);
        save_thongtin($data_thongtin,$uid);
        return redirect()->back()->with('status','Bạn đã lên cảnh giới mới.');
    }
    public function tam_ma_kiep(){
        //khai báo
            $uid = Auth::user()->id;
            $data_thongtin = data_thongtin($uid);
            check_data($data_thongtin);
            if($data_thongtin[0]['tu_luyen'] != 3 ){
                return redirect()->back()->with('error','Bạn chưa đạt đủ điều kiện độ tâm ma kiếp.');
            }
            $thien_kiep = ThienKiepModel::find(12);
            //end khai báo
        $ty_le = array("thanh_cong" => $thien_kiep->thanh_cong,"tieu_thuong" => $thien_kiep->tieu_thuong, "trong_thuong" => $thien_kiep->trong_thuong, "tu_vong" => $thien_kiep->chet);
        $value = random_arr($ty_le);
        if($value == 'thanh_cong'){
            $data_thongtin[0]['tu_luyen'] = 0;
            $data_thongtin[0]['tam_canh'] = 100;
            $data_thongtin[0]['trang_thai'] = "Hoàn mỹ";
            save_thongtin($data_thongtin,$uid);
            return redirect()->back()->with('status','Độ kiếp thành công lông tóc không thương.');
        }elseif($value == 'tieu_thuong'){
            $data_thongtin[0]['tu_luyen'] = 0;
            $data_thongtin[0]['tam_canh'] = 80;
            $data_thongtin[0]['trang_thai'] = "Tiểu thương";
            save_thongtin($data_thongtin,$uid);
            return redirect()->back()->with('status','Độ kiếp thành công bị thương nhẹ.');
        }elseif($value == 'trong_thuong'){
            $data_thongtin[0]['tu_luyen'] = 0;
            $data_thongtin[0]['tam_canh'] = 20;
            $data_thongtin[0]['trang_thai'] = "Trọng thương";
            save_thongtin($data_thongtin,$uid);
            return redirect()->back()->with('status','Độ kiếp thành công bị trọng thương.');
        }else{
            tu_vong($uid);
            return redirect()->back()->with('error','TỬ VONG.');
        }
    }
    public function do_kiep(){
        $uid = Auth::user()->id;
        $data_thongtin = data_thongtin($uid);
        check_data($data_thongtin);
        $data_tuido = data_tuido($uid);
        $thien_kiep = ThienKiepModel::find($data_thongtin[0]['do_kiep']);
        $ty_le = array("thanh_cong" => $thien_kiep->thanh_cong,"tieu_thuong" => $thien_kiep->tieu_thuong, "trong_thuong" => $thien_kiep->trong_thuong, "tu_vong" => $thien_kiep->chet);
        $value = random_arr($ty_le);
        $check = "full";
        if($data_thongtin[0]['phu_tro'] == 1){
            $check = "len_cap";
        }elseif( $data_thongtin[0]['phu_tro'] == 7){
            if(isset($data_tuido[0]['tuido_dotpha'][7]) && $data_tuido[0]['tuido_dotpha'][7]['so_luong'] <= 0){
                $check = "len_cap";
            }else{
                $data_thongtin[0]['tu_luyen'] = 2;
                save_thongtin($data_thongtin,$uid);
            }
        }else{
            if(isset($data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]) && $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] >= $data_thongtin[0]['so_luong']){
                $check = "len_cap";
                $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] = $data_tuido[0]['tuido_dotpha'][$data_thongtin[0]['phu_tro']]['so_luong'] - $data_thongtin[0]['so_luong'];
                save_tuido($data_tuido,$uid);
            }else{
                $data_thongtin[0]['tu_luyen'] = 2;
                save_thongtin($data_thongtin,$uid);
            }
        }
        if($check == "len_cap"){
            if($value == 'thanh_cong'){
                $data_thongtin[0]['tu_luyen'] = 4;
                $data_thongtin[0]['trang_thai'] = "Hoàn mỹ";
                save_thongtin($data_thongtin,$uid);
                return redirect('tu-luyen/nhan-vat/len-cap')->with('status','Độ kiếp thành công lông tóc không thương.');
            }elseif($value == 'tieu_thuong'){
                $data_thongtin[0]['tu_luyen'] = 4;
                $data_thongtin[0]['trang_thai'] = "Tiểu thương";
                save_thongtin($data_thongtin,$uid);
                return redirect('tu-luyen/nhan-vat/len-cap')->with('status','Độ kiếp thành công bị thiên lôi chào hỏi nhẹ.');
            }elseif($value == 'trong_thuong'){
                $data_thongtin[0]['tu_luyen'] = 4;
                $data_thongtin[0]['trang_thai'] = "Trọng thương";
                save_thongtin($data_thongtin,$uid);
                return redirect('tu-luyen/nhan-vat/len-cap')->with('status','Độ kiếp thành công bị thiên lôi trọng thương.');
            }else{
                tu_vong($uid);
                return redirect()->back()->with('error','TỬ VONG.');
            }
        }else{
            return redirect()->back()->with('error','Bạn không đủ đồ để lên cấp.');
        }
    }
}
