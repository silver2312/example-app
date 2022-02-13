<?php
use App\Models\Game\ChungTocModel;
use App\Models\Game\TheChatModel;
use App\Models\PathAll;
use App\Models\User;
use Carbon\Carbon;
use Goutte\Client;
include( 'check.php');
include( 'data_json.php');

function get_level($level,$id){
    $user = User::find($id);
    if($level == 0){
        $text =  '<span class="kieu_chu anh_nhieu_mau" rel="tooltip" data-html="true" title="200% exp">Creator</span>';
    }elseif($level == 1){
        $text =  '<span class="kieu_chu anh_do1" rel="tooltip" data-html="true" title="100% exp">Admin</span>';
    }elseif($level == 2){
        $text =  '<span class="kieu_chu anh_tim2" rel="tooltip" data-html="true" title="75% exp">Mod</span>';
    }elseif($level == 3){
        $text =  '<span class="kieu_chu mau_do" rel="tooltip" data-html="true" title="25% exp">Vip</span>';
    }elseif($level == 4){
        $text =  '<span class="kieu_chu mau_do" rel="tooltip" data-html="true" title="'.date("Y-m-d H:i:s", $user->vip_time).'<br>25% exp">Vip</span>';
    }elseif($level <= 10){
        $text =  '<span class="kieu_chu">Dân thường</span>';
    }else{
        $text =  '<span class="kieu_chu">Banned</span>';
    }
    echo $text;
}
function format_num($num){
    $findme = 'E';
    $pos = strpos((string)$num, $findme);
    $crr = $num;
    if($pos > 0){
        $f1 = explode('E', (string)$num)[0];
        $f2 = explode('E', (string)$num)[1];
        $num = number_format((float)$f1,1).'E'.$f2;
    }else{
        $num = number_format($num,1);
        $f2 = explode('.', (string)$num)[1];
        if($f2 == '0'){
            $num = number_format($crr);
        }else{
            $num = $num;
        }
    }
    return $num;
}
function luc_luong($luc){
    if($luc / 596730000000000000000000000000000000000000000000000  >= 1){
        $text = format_num($luc / 596730000000000000000000000000000000000000000000000) . ' <span class="anh_nhieu_mau kieu_chu">giới chi lực</span>';
    }elseif($luc / 19891000000000000000000000000000000     >= 1){
        $text = format_num($luc / 19891000000000000000000000000000000     ) . ' <span class="anh_do kieu_chu">tinh chi lực</span>';
    }elseif($luc / 597200000000000000    >= 1){
        $text = format_num($luc / 597200000000000000    ) . ' <span class="anh_vang kieu_chu">long chi lực</span>';
    }elseif($luc / 7345560000000000   >= 1){
        $text = format_num($luc / 7345560000000000   ) . ' <span class="mau_vang_nhap_nhay kieu_chu">quy chi lực</span>';
    }elseif($luc / 772787164   >= 1){
        $text = format_num($luc / 772787164   ) . ' <span class="mau_vang_nhap_nhay kieu_chu">thiên chi lực</span>';
    }elseif($luc / 85706243   >= 1){
        $text = format_num($luc / 85706243   ) . ' <span class="mau_vang_nhap_nhay kieu_chu">địa chi lực</span>';
    }elseif($luc / 60000  >= 1){
        $text = format_num($luc / 60000  ) . ' <span class="mau_cam kieu_chu">thạch chi lực</span>';
    }elseif($luc / 9000 >= 1){
        $text = format_num($luc / 9000 ) . ' <span class="mau_xanh_nuoc_bien kieu_chu">tượng chi lực</span>';
    }elseif($luc / 900  >= 1){
        $text = format_num($luc / 900 ) . ' <span class="chu_do kieu_chu">tịnh chi lực</span>';
    }elseif($luc / 440  >= 1){
        $text = format_num($luc / 440) . ' <span class="chu_nau kieu_chu">hùng chi lực</span>';
    }elseif($luc / 250 >= 1){
        $text = format_num($luc / 250) . ' <span class="chu_luc kieu_chu">xà chi lực</span>';
    }else{
        $text = format_num($luc). ' kg';
    }
    echo $text;
}
function random_arr($arr){
    $rand = (float)mt_rand()/(float)mt_getrandmax();
    foreach ($arr as $key => $value) {
        if ($rand < $value) {
            break;
        }
        $rand -= $value;
    }
    return $key;
}
function random_chungtoc($gioi_tinh){
    //thêm chủng tộc với tỷ lệif($data['gioi_tinh'] == 0){
    if($gioi_tinh == 0){
        $arr = array(25,29,7);
        $chung_toc = ChungTocModel::orderBy('ty_le','asc')->whereNotIn('id',$arr)->get();
    }else{
        $chung_toc = ChungTocModel::orderBy('ty_le','asc')->get();
    }
    $toc_id_arr = [];
    foreach($chung_toc as $key => $val){
        $new = array($val->id => $val->ty_le);
        $toc_id_arr += $new;
    }
    $chung_toc_id = random_arr($toc_id_arr);
    return $chung_toc_id;
}
function random_thechat($chung_toc_id){
    $path = PathAll::first();
    $json_thechat = file_get_contents($path->path_chungtoc);
    $data_thechat = json_decode($json_thechat,true);
    $thechat_id = [];
    foreach($data_thechat[$chung_toc_id]['the_chat'] as $key_tc_c => $value_tc_c){
        $thechat_id[] = $value_tc_c;
    }
    $the_chat = TheChatModel::orderBy('ty_le','asc')->whereIn('id',$thechat_id)->get();
    $thechat_id_arr = [];
    foreach($the_chat as $key_tc => $val_tc){
        $new_tc = array($val_tc->id => $val_tc->ty_le);
        $thechat_id_arr +=  $new_tc;
    }
    $the_chat_id = random_arr($thechat_id_arr);
    return $the_chat_id;
}
function tinh_phantram($num1,$num2){
    $phan_tram = ($num1 / $num2) * 100;
    if($phan_tram > 100){
        $phan_tram = 100;
    }
    return format_num($phan_tram);
}
function random($ty_le){
    $rand = (float)mt_rand()/(float)mt_getrandmax();
    if ($rand < $ty_le){
        $result = 0;
    }else{
        $result = 1;
    }
    return $result;
}
function tyle_luck($luck){
    if($luck == "E"){
        $ty_le = 0.013/100;
    }
    if($luck == "E+"){
        $ty_le = 1/100;
    }
    if($luck == "E++"){
        $ty_le = 5/100;
    }
    if($luck == "D"){
        $ty_le = 6/100;
    }
    if($luck == "D+"){
        $ty_le = 7/100;
    }
    if($luck == "D++"){
        $ty_le = 8/100;
    }
    if($luck == "C"){
        $ty_le = 10/100;
    }
    if($luck == "C+"){
        $ty_le = 11/100;
    }
    if($luck == "C++"){
        $ty_le = 12/100;
    }
    if($luck == "B"){
        $ty_le = 14/100;
    }
    if($luck == "B+"){
        $ty_le = 15/100;
    }
    if($luck == "B++"){
        $ty_le = 17/100;
    }
    if($luck == "A"){
        $ty_le = 20/100;
    }
    if($luck == "A+"){
        $ty_le = 30/100;
    }
    if($luck == "A++"){
        $ty_le = 40/100;
    }
    if($luck == "EX"){
        $ty_le = 70/100;
    }
    return $ty_le;
}
function vip($uid,$exp,$max_exp){
    $user = User::find($uid);
    if($user->level > 4){
        $exp = $exp;
    }elseif($user->level >= 3){
        $exp = $exp + $max_exp*0.25;
    }elseif($user->level >= 2){
        $exp = $exp + $max_exp*0.5;
    }elseif($user->level >= 1){
        $exp = $exp + $max_exp;
    }else{
        $exp = $exp + $max_exp*2;
    }
    return $exp;
}
function random_ma_xn(){
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function tieu_phi_save($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data){
    $user = User::find($uid);
    $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
    $data_tieuphi = data_tieuphi($uid);
    $data_tieuphi[$now]['text'] = "Dùng ".number_format($dong_te,2)." đồng, ".number_format($ngan_te,2)." ngân, ".number_format($kim_te,2)." kim tệ ".number_format($me,2)."để mua <span style='color:red'>".number_format($data['so_luong'])." / ".$item->ten."</span> ";
    $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,2)." kim tệ, ".number_format($user->me,2)." ME.";
    save_tieuphi($data_tieuphi,$uid);
}
function tieu_phi_save_ban($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data){
    $user = User::find($uid);
    $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
    $data_tieuphi = data_tieuphi($uid);
    $data_tieuphi[$now]['text'] = "Bán ".$data['so_luong']." <span style='color:red'>".$item->ten."</span> được : ".$dong_te." đồng, ".$ngan_te." ngân, ".$kim_te." kim tệ, ".$me." ME.";
    $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,2)." kim tệ, ".number_format($user->me,2)." ME.";
    save_tieuphi($data_tieuphi,$uid);
}
function tieu_phi_save_chuyen($uid,$item,$dong_te,$ngan_te,$kim_te,$me,$data){
    $user = User::find($uid);
    $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
    $data_tieuphi = data_tieuphi($uid);
    $data_tieuphi[$now]['text'] = "Thu phí chuyển <span style='color:red'>".number_format($data['so_luong'])." / ".$item->ten."</span> đến <span style='color:red'>id ".number_format($data['id_nhan'])."</span>: ".number_format($dong_te)." đồng, ".number_format($ngan_te)." ngân, ".number_format($kim_te)." kim tệ, ".number_format($me)." ME.";
    $data_tieuphi[$now]['so_du'] = number_format($user->dong_te,2)." đồng tệ, ".number_format($user->ngan_te,2)." ngân tệ, ".number_format($user->kim_te,2)." kim tệ, ".number_format($user->me,2)." ME.";
    save_tieuphi($data_tieuphi,$uid);
}
function trans_tieu_de($str){
    $client = new Client();
    $crawler = $client->request('POST', 'https://vietphrase.info/Vietphrase/TranslateVietPhraseS', ['chineseContent' => $str]);
    return $crawler->text();
}
function format_text($num){
    if(is_numeric($num) == false){
        return 0;
    }
    if($num >= 1000000000){
        $num = number_format($num/1000000000,1)."b";
    }elseif($num >= 1000000){
        $num = number_format($num/1000000,1)."m";
    }elseif($num >= 1000){
        $num = number_format($num/1000,1)."k";
    }else{
        $num = number_format($num);
    }
    return $num;
}
function trans_html($str){
    $client = new Client();
    $crawler = $client->request('POST', 'https://vietphrase.info/Vietphrase/TranslateVietPhraseS', ['chineseContent' => $str]);
    return $crawler->html();
}
