<?php
use App\Models\User;
use App\Models\PathAll;
use App\Models\Game\UserPath;
use Illuminate\Support\Facades\Auth;
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use Carbon\Carbon;
use Goutte\Client;
use hisorange\BrowserDetect\Parser as Browser;
use Stevebauman\Location\Facades\Location;
use App\Models\Truyen\Truyen;
use App\Models\Truyen\PathTruyen;
use App\Models\Truyen\TruyenSub;

function check_file(){
    $path =  PathAll::first();
    if(empty($path)){
        $path = new PathAll();
        $path->save();
    }
    if(empty($path->path_chungtoc) || !file_exists($path->path_chungtoc)){
        $dir = 'upload/admin/tu_luyen/';
        if( is_dir($dir) === false )
        {
            mkdir($dir,0777,true);
        }
        $ten_file = 'chung_toc.json';
        $chung_toc = $dir . $ten_file;
        $file = fopen($chung_toc,'w');
        fclose($file);
        $path->path_chungtoc = $chung_toc;
        $path->save();
    }
    $user1 = User::get();
    if(empty($path->khac_che_he) || !file_exists($path->khac_che_he)){
        $dir = 'upload/admin/tu_luyen/';
        if( is_dir($dir) === false )
        {
            mkdir($dir,0777,true);
        }
        $ten_file = 'khac_che.json';
        $khac_che = $dir . $ten_file;
        $file = fopen($khac_che,'w');
        fclose($file);
        $path->khac_che_he = $khac_che;
        $path->save();
    }
    if(empty($path->path_tanthu) || !file_exists($path->path_tanthu)){
        $dir = 'upload/';
        if( is_dir($dir) === false )
        {
            mkdir($dir,0777,true);
        }
        $ten_file = 'tan_thu.json';
        $tan_thu = $dir . $ten_file;
        $file = fopen($tan_thu,'w');
        fclose($file);
        $path->path_tanthu = $tan_thu;
        $path->save();
    }
    if(empty($path->path_name) || !file_exists($path->path_name)){
        $dir = 'upload/';
        if( is_dir($dir) === false )
        {
            mkdir($dir,0777,true);
        }
        $ten_file = 'name_tong.json';
        $name_tong = $dir . $ten_file;
        $file = fopen($name_tong,'w');
        fclose($file);
        $path->path_name = $name_tong;
        $path->save();
    }
    foreach($user1 as $key => $value){
        $id = $value->id;
        $user = User::find($id);
        if(isset($user)){
            $user_path = UserPath::find($id);
            if(empty($user_path)){
                $user_path = new UserPath();
                $user_path->id = $id;
            }
            if(empty($path->path_chungtoc) && !file_exists($path->path_chungtoc)){
                $dir = 'upload/admin/tu_luyen/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'chung_toc.json';
                $path_chungtoc = $dir . $ten_file;
                $path->path_chungtoc = $path_chungtoc;
                $file = fopen($path_chungtoc,'w');
                fclose($file);
                $path->save();
            }
            if(empty($user_path->path_nhanvat) || !file_exists($user_path->path_nhanvat)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'nhan_vat.json';
                $path_nhanvat = $dir . $ten_file;
                $file = fopen($path_nhanvat,'w');
                fclose($file);
                $user_path->path_nhanvat = $path_nhanvat;
            }
            if(empty($user_path->path_thongtin) || !file_exists($user_path->path_thongtin)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'thong_tin.json';
                $path_thongtin = $dir . $ten_file;
                $file = fopen($path_thongtin,'w');
                fclose($file);
                $user_path->path_thongtin = $path_thongtin;
            }
            if(empty($user_path->path_tuido) || !file_exists($user_path->path_tuido)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'tui_do.json';
                $path_tuido = $dir . $ten_file;
                $file = fopen($path_tuido,'w');
                fclose($file);
                $user_path->path_tuido = $path_tuido;
            }
            if(empty($user_path->path_danhhieu) || !file_exists($user_path->path_danhhieu)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'danh_hieu.json';
                $path_danhhieu = $dir . $ten_file;
                $file = fopen($path_danhhieu,'w');
                fclose($file);
                $user_path->path_danhhieu = $path_danhhieu;
            }
            if(empty($user_path->path_congphap) || !file_exists($user_path->path_congphap)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'cong_phap.json';
                $path_congphap = $dir . $ten_file;
                $file = fopen($path_congphap,'w');
                fclose($file);
                $user_path->path_congphap = $path_congphap;
            }
            if(empty($user_path->path_kynang) || !file_exists($user_path->path_kynang)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'ky_nang.json';
                $path_kynang = $dir . $ten_file;
                $file = fopen($path_kynang,'w');
                fclose($file);
                $user_path->path_kynang = $path_kynang;
            }
            if(empty($user_path->path_tieuphi) || !file_exists($user_path->path_tieuphi)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'tieu_phi.json';
                $path_tieuphi = $dir . $ten_file;
                $file = fopen($path_tieuphi,'w');
                fclose($file);
                $user_path->path_tieuphi = $path_tieuphi;
            }
            if(empty($user_path->path_cmt) || !file_exists($user_path->path_cmt)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'cmt.json';
                $path_cmt = $dir . $ten_file;
                $file = fopen($path_cmt,'w');
                fclose($file);
                $user_path->path_cmt = $path_cmt;
            }
            if(empty($user_path->path_rep) || !file_exists($user_path->path_rep)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'rep.json';
                $path_rep = $dir . $ten_file;
                $file = fopen($path_rep,'w');
                fclose($file);
                $user_path->path_rep = $path_rep;
            }
            if(empty($user_path->path_log) || !file_exists($user_path->path_log)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'log.json';
                $path_log = $dir . $ten_file;
                $file = fopen($path_log,'w');
                fclose($file);
                $user_path->path_log = $path_log;
            }
            $user_path->save();
            $data_thongtin= data_thongtin($id);
            if(isset($data_thongtin[0]) && $data_thongtin[0]['level'] > 0 ){
                $phan_tram = number_format($data_thongtin[0]['exp_hientai']/$data_thongtin[0]['exp_nextlevel']*100);
                $user->level_tuluyen = $data_thongtin[0]['level'];
                $user->phan_tram = $phan_tram;
                $user->save();
            }else{
                $user->level_tuluyen = 0;
                $user->phan_tram = 0;
                $user->save();
            }
        }
    }
}
function check_data($data){
    if(empty($data)){
        abort(404);
    }
}
function check_uid($uid){
    if($uid != Auth::user()->id){
        abort(404);
    }
}
function tu_vong($uid){
    $data_congphap = data_congphap($uid);
    $data_tuido = data_tuido($uid);
    $data_nhanvat = data_nhanvat($uid);
    $data_thongtin = data_thongtin($uid);
    if(isset($data_congphap[0])){
        unset($data_congphap[0]);
        save_congphap($data_congphap,$uid);
    }
    unset($data_thongtin[0]);
    unset($data_tuido[0]);
    unset($data_nhanvat[0]);
    save_tuido($data_tuido,$uid);
    save_nhanvat($data_nhanvat,$uid);
    save_thongtin($data_thongtin,$uid);
}
function check_level($id){
    $data_thongtin = data_thongtin($id);
    $data_nhanvat = data_nhanvat($id);
    if( isset($data_nhanvat[0]) &&  isset($data_nhanvat[0]['nangluong_id']) && isset($data_thongtin[0]) ){
        if($data_thongtin[0]['level'] <= 100){
            $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',$data_thongtin[0]['level'])->first();
        }else{
            $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',100)->first();
        }
        return $chi_tiet->css;
    }else{
        return 'level_0';
    }
}
function check_log(){
    $id = Auth::user()->id;
    $data_log = data_log($id);
    //get địa chỉ
        $ip = request()->ip();
        $position = Location::get($ip);
        $nuoc = $position->countryName;
        $thanh_pho = $position->cityName;
    //end get địa chỉ
    //get trình duyệt
        $trinh_duyet = Browser::browserName();
        $hdh = Browser::platformName();
        $thiet_bi = Browser::deviceFamily().' '.Browser::deviceModel();
    //end get trình duyệt
    $check = 0;
    if( isset($data_log) ){
        $nuoc_arr = [];
        $thanh_pho_arr = [];
        $trinh_duyet_arr = [];
        $thiet_bi_arr = [];
        $hdh_arr = [];
        foreach ($data_log as $key => $value) {
            $nuoc_arr[] = $value['nuoc'];
            $thanh_pho_arr[] = $value['thanh_pho'];
            $trinh_duyet_arr[] = $value['trinh_duyet'];
            $thiet_bi_arr[] = $value['thiet_bi'];
            $hdh_arr[] = $value['hdh'];
        }
        if( in_array($nuoc,$nuoc_arr) == false ){
            $check = 1;
        }elseif( in_array($thanh_pho,$thanh_pho_arr) == false ){
            $check = 1;
        }elseif( in_array($trinh_duyet,$trinh_duyet_arr) == false ){
            $check = 1;
        }elseif( in_array($thiet_bi,$thiet_bi_arr) == false ){
            $check = 1;
        }elseif( in_array($hdh,$hdh_arr) == false ){
            $check = 1;
        }
        dump($nuoc_arr);
    }else{
        $check = 1;
    }
    if($check ==1 ){
        $time = strtotime(Carbon::now());
        $data_log[$time]['ip'] = $ip;
        $data_log[$time]['nuoc'] = $nuoc;
        $data_log[$time]['thanh_pho'] = $thanh_pho;
        $data_log[$time]['trinh_duyet'] = $trinh_duyet;
        $data_log[$time]['hdh'] = $hdh;
        $data_log[$time]['thiet_bi'] = $thiet_bi;
        save_log($data_log,$id);
    }
}
function del_user(){
    $user = User::get();
    $now = Carbon::now('Asia/Ho_Chi_Minh');
    foreach($user as $key => $value){
        $user1 = User::find($value->id);
        if(isset($user1->created_at)){
            $cre_date = Carbon::parse($user1->created_at)->addDays(3);
            $up_date =Carbon::parse($user1->updated_at)->addDays(14);
            if( strtotime( $cre_date ) < strtotime($now) && empty($user1->email_verified_at) ){
                unlink($user1->u_image);
                $user1->delete();
            }elseif( strtotime( $up_date ) < strtotime($now) ){
                unlink($user1->u_image);
                $user1->delete();
            }
        }
    }
}
function check_img($id){
    $user = User::find($id);
    if(isset($user->u_image) && file_exists($user->u_image)){
        return url($user->u_image);
    }else{
        return 'https://i.imgur.com/nAE9VPf.png';
    }
}
function check_name($id){
    $user = User::find($id);
    if(isset($user->name)){
        return $user->name;
    }else{
        return 'Tài khoản đã xoá.';
    }
}
function get_host($url){
    $cut = explode('/', $url)[2];
    if($cut == "www.230book.net" || $cut == "m.230book.net"){
        return "230book";
    }elseif($cut == "www.uukanshu.com"){
        return "uukanshu";
    }elseif($cut == "trxs.cc"){
        return "trxs";
    }else{
        return 0;
    }
}
function get_link($url){
    $cut = explode('/', $url)[4];
    try{
        return $cut;
    }catch(\Exception $e){
        return 0;
    }
}
function get_header($host,$crawler){
    if($host == "230book"){
        $tieu_de = $crawler->filter('#info > h1')->text();
        try{
            $gioi_thieu = $crawler->filter('#intro > p')->text();
        }catch(\Exception $e){
            $gioi_thieu = "Đọc truyện ".$tieu_de;
        }
        $tac_gia = $crawler->filter('#info > p:nth-child(2)')->text();
        $img = "https://www.230book.net".$crawler->filter('#fmimg > img')->attr('src');
        $arr = array(
            'tieu_de' => $tieu_de,
            'gioi_thieu' => $gioi_thieu,
            'tac_gia' => $tac_gia,
            'img' => $img,
        );
        return $arr;
    }elseif($host == "uukanshu"){
        return 0;
    }elseif($host == "trxs"){
        return 0;
    }else{
        return 0;
    }
}
function check_nhung(){
    $truyen = Truyen::get();
    foreach($truyen as $key => $value){
        $truyen_for = PathTruyen::find($value->id);
        if(empty($truyen_for)){
            $truyen_for = new PathTruyen();
            $truyen_for->id = $value->id;
        }
        $dir = 'upload/truyen/surf/'.$value->id.'/';
        if(empty($truyen_for->path_chuong) || !file_exists($truyen_for->path_chuong)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'chuong.json';
            $path_chuong = $dir . $ten_file;
            $file = fopen($path_chuong,'w');
            fclose($file);
            $truyen_for->path_chuong = $path_chuong;
        }
        if(empty($truyen_for->path_theloai) || !file_exists($truyen_for->path_theloai)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'the_loai.json';
            $path_theloai = $dir . $ten_file;
            $file = fopen($path_theloai,'w');
            fclose($file);
            $truyen_for->path_theloai = $path_theloai;
        }
        if(empty($truyen_for->path_tag) || !file_exists($truyen_for->path_tag)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'tag.json';
            $path_tag = $dir . $ten_file;
            $file = fopen($path_tag,'w');
            fclose($file);
            $truyen_for->path_tag = $path_tag;
        }
        if(empty($truyen_for->path_like) || !file_exists($truyen_for->path_like)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'like.json';
            $path_like = $dir . $ten_file;
            $file = fopen($path_like,'w');
            fclose($file);
            $truyen_for->path_like = $path_like;
        }
        if(empty($truyen_for->path_dislike) || !file_exists($truyen_for->path_dislike)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'dislike.json';
            $path_dislike = $dir . $ten_file;
            $file = fopen($path_dislike,'w');
            fclose($file);
            $truyen_for->path_dislike = $path_dislike;
        }
        if(empty($truyen_for->path_gift) || !file_exists($truyen_for->path_gift)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'gift.json';
            $path_gift = $dir . $ten_file;
            $file = fopen($path_gift,'w');
            fclose($file);
            $truyen_for->path_gift = $path_gift;
        }
        if(empty($truyen_for->path_name) || !file_exists($truyen_for->path_name)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'name.json';
            $path_name = $dir . $ten_file;
            $file = fopen($path_name,'w');
            fclose($file);
            $truyen_for->path_name = $path_name;
        }
        if(empty($truyen_for->path_comment) || !file_exists($truyen_for->path_comment)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'comment.json';
            $path_comment = $dir . $ten_file;
            $file = fopen($path_comment,'w');
            fclose($file);
            $truyen_for->path_comment = $path_comment;
        }
        if(empty($truyen_for->path_reply) || !file_exists($truyen_for->path_reply)){
            if( is_dir($dir) === false )
            {
                mkdir($dir,0777,true);
            }
            $ten_file = 'reply.json';
            $path_reply = $dir . $ten_file;
            $file = fopen($path_reply,'w');
            fclose($file);
            $truyen_for->path_reply = $path_reply;
        }
        $truyen_for->save();
    }
}
function get_url($host,$link){
    if($host == "230book"){
        $url = "http://www.230book.net/book/".$link.'/';
        return $url;
    }elseif($host == "uukanshu"){
        return 0;
    }elseif($host == "trxs"){
        return 0;
    }else{
        return 0;
    }
}
function get_chapter($host,$crawler,$data_chapter,$id,$truyen){
    if($host == "230book"){
        $a = 0;
        try{
            foreach($crawler->filter('#list > ul > li > a') as $key => $node){
                if(empty($data_chapter[$key])){
                    $a = 1;
                    $text = $node->textContent;
                    $data_chapter[$key]['header'] = $text;
                    $data_chapter[$key]['link'] = $node->attributes->getNamedItem('href')->nodeValue;
                    $data_chapter[$key]['header_sub'] = $text;
                }
            }
        }catch(Throwable $e){
            return redirect()->back()->with('error','Không tìm thấy truyện.');
        }
        save_chapter($data_chapter,$id);
        if($a == 1){
            $truyen->so_chuong	= count($data_chapter);
            $truyen->time_up = Carbon::now('Asia/Ho_Chi_Minh');
            $truyen->save();
        }
        return 1;
    }else{
        return 0;
    }
}
function check_truyen_sub(){
    $truyen = Truyen::whereNotNull('nguon')->whereNotNull('link')->get();
    foreach($truyen as $key => $value){
        $truyen1 = TruyenSub::find($value->id);
        if(empty($truyen1)){
            $truyen_sub = new TruyenSub();
            $truyen_sub->id = $value->id;
            $truyen_sub->tieu_de = trans_tieu_de($value->tieu_de);
            $truyen_sub->tac_gia = trans_tieu_de($value->tac_gia);
            $truyen_sub->gioi_thieu = trans_tieu_de($value->gioi_thieu);
            $truyen_sub->save();
        }
    }
}
function check_link_img($url){
    if (@file_get_contents($url,0,NULL,0,1)) {
        return $url;
    } else {
        return "https://i.imgur.com/hQRlkUR.png";
    }
}
function get_data_chapter($host,$position,$data_chapter,$id,$crawler){
    if($host == "230book"){
        $data_chapter[$position]['noi_dung'] = $crawler->filter('#content')->html();
        try{
            $data_chapter[$position]['header_sub'] = explode(':', trans_tieu_de($data_chapter[$position]['header']) )[1];
        }catch(Throwable $e){
            $data_chapter[$position]['header_sub'] = trans_tieu_de($data_chapter[$position]['header']);
        }
        $data_chapter[$position]['noi_dung_sub'] = trans_html($crawler->filter('#content')->html());
        save_chapter($data_chapter,$id);
        return 1;
    }else{
        return 0;
    }
}
