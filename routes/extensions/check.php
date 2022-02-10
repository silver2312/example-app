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
use App\Models\Game\Item\ChuyenItem;
use App\Models\Truyen\Truyen;
use App\Models\Truyen\PathTruyen;
use App\Models\Truyen\TruyenSub;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\VanNangModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\CongPhapModel;
use Illuminate\Support\Facades\DB;

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
            if(empty($user_path->path_tutruyen) || !file_exists($user_path->path_tutruyen)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'tu_truyen.json';
                $path_tutruyen = $dir . $ten_file;
                $file = fopen($path_tutruyen,'w');
                fclose($file);
                $user_path->path_tutruyen = $path_tutruyen;
            }
            if(empty($user_path->path_dangdoc) || !file_exists($user_path->path_dangdoc)){
                $dir = 'upload/tu_luyen/'.$id.'/';
                if( is_dir($dir) === false )
                {
                    mkdir($dir,0777,true);
                }
                $ten_file = 'dang_doc.json';
                $path_dangdoc = $dir . $ten_file;
                $file = fopen($path_dangdoc,'w');
                fclose($file);
                $user_path->path_dangdoc = $path_dangdoc;
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
    $user = User::find($uid);
    $user->kim_te = $user->kim_te - 1000;
    $user->save();
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
function get_link($url,$host){
    $cut = explode('/', $url)[4];
    try{
        if($host == "230book"){
            return $cut;
        }elseif($host == "trxs"){
            return explode('.', $cut)[0];
        }
    }catch(Throwable $e){
        return 0;
    }
}
function get_header($host,$crawler){
    if($host == "230book"){
        $tieu_de = $crawler->filter('#info > h1')->text();
        try{
            $gioi_thieu = $crawler->filter('#intro > p')->text();
        }catch(Throwable $e){
            $gioi_thieu = "Đọc truyện ".$tieu_de;
        }
        $tac_gia = $crawler->filter('#info > p:nth-child(2)')->text();
        $img = "https://www.230book.net".$crawler->filter('#fmimg > img')->attr('src');
        if (@getimagesize($img)) {
            $img = $img;
        } else {
            $img = "https://i.imgur.com/hQRlkUR.png";
        }
        $arr = array(
            'tieu_de' => $tieu_de,
            'gioi_thieu' => $gioi_thieu,
            'tac_gia' => explode('：',$tac_gia)[1],
            'img' => $img,
        );
        return $arr;
    }elseif($host == "uukanshu"){
        return 0;
    }elseif($host == "trxs"){
        $tieu_de = $crawler->filter('body > div.readContent > div.book_info.clearfix > div.infos > h1')->text();
        try{
            $gioi_thieu = $crawler->filter('body > div.readContent > div.book_info.clearfix > div.infos > p')->html();
        }catch(Throwable $e){
            $gioi_thieu = "Đọc truyện ".$tieu_de;
        }
        $tac_gia = $crawler->filter('body > div.readContent > div.book_info.clearfix > div.infos > div.date > span > a')->text();
        $img = "https://trxs.cc".$crawler->filter('body > div.readContent > div.book_info.clearfix > div.pic > img')->attr('src');
        if (@getimagesize($img)) {
            $img = $img;
        } else {
            $img = "https://i.imgur.com/hQRlkUR.png";
        }
        $arr = array(
            'tieu_de' => $tieu_de,
            'gioi_thieu' => $gioi_thieu,
            'tac_gia' => $tac_gia,
            'img' => $img,
        );
        return $arr;
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
        $url = "https://trxs.cc/tongren/".$link.'.html';
        return $url;
    }else{
        return 0;
    }
}
function get_chapter($host,$url,$data_chapter,$id,$truyen){
    $a = 0;
    $i = 1;
    $client = new Client();
    if($host == "230book"){
        $new_url = "http://vietphrase.info/VietPhrase/Browser?url=".$url."&script=false&t=VP";
        $crawler = $client->request('GET', $new_url);
        $crawler_old = $client->request('GET', $url);
        try{
            foreach($crawler_old->filter('#list > ul > li > a') as $key => $node){
                if(empty($data_chapter[$key]) || empty($data_chapter[$key]['link'])){
                    $a = 1;
                    $data_chapter[$key]['header'] = $node->textContent;
                    $data_chapter[$key]['link'] = $node->attributes->getNamedItem('href')->nodeValue;
                    save_chapter($data_chapter,$id);
                }
            }
        }catch(Throwable $e){
            $i = 0;
        }
        try{
            foreach($crawler->filter('#list > ul > li > a') as $keysub => $nodesub){
                $data_chapter[$keysub]['header_sub'] = $nodesub->textContent;
            }
            save_chapter($data_chapter,$id);
        }catch(Throwable $e){
            $i = 0;
        }
        if($a == 1){
            $truyen->so_chuong	= count($data_chapter);
            $truyen->time_up = Carbon::now('Asia/Ho_Chi_Minh');
            $truyen->save();
        }
        return $i;
    }elseif($host == "trxs"){
        $new_url = "http://vietphrase.info/VietPhrase/Browser?url=".$url."&script=false&t=VP";
        $crawler = $client->request('GET', $new_url);
        $crawler_old = $client->request('GET', $url);
        try{
            foreach($crawler_old->filter('body > div.readContent > div.book_list.clearfix > ul > li > a') as $key => $node){
                if(empty($data_chapter[$key]) || empty($data_chapter[$key]['link'])){
                    $a = 1;
                    $data_chapter[$key]['header'] = $node->textContent;
                    $data_chapter[$key]['link'] = explode('/', $node->attributes->getNamedItem('href')->nodeValue)[3];
                    save_chapter($data_chapter,$id);
                }
            }
        }catch(Throwable $e){
            $i = 0;
        }
        try{
            foreach($crawler->filter('#html > div.readContent > div.book_list.clearfix > ul > li > a') as $keysub => $nodesub){
                $data_chapter[$keysub]['header_sub'] = $nodesub->textContent;
            }
            save_chapter($data_chapter,$id);
        }catch(Throwable $e){
            $i = 0;
        }
        if($a == 1){
            $truyen->so_chuong	= count($data_chapter);
            $truyen->time_up = Carbon::now('Asia/Ho_Chi_Minh');
            $truyen->save();
        }
        return $i;
    }
    else{
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
            if(isset($value->link)){
                if($value->nguon == "230book"){
                    $url = get_url($value->nguon,$value->link);
                    $client = new Client();
                    $new_url = "http://vietphrase.info/VietPhrase/Browser?url=".$url."&script=false&t=VP";
                    $crawler = $client->request('GET', $new_url);
                    $tieu_de = $crawler->filter('#info > h1')->text();
                    $tac_gia = explode(':', $crawler->filter('#info > p:nth-child(2)')->text())[1];
                    $gioi_thieu = $crawler->filter('#intro')->text();
                    if(empty($gioi_thieu)){
                        $gioi_thieu = "Đọc truyện ".$tieu_de." của ".$tac_gia." tại http://www.230book.net";
                    }
                    $truyen_sub->tieu_de = $tieu_de;
                    $truyen_sub->tac_gia = $tac_gia;
                    $truyen_sub->gioi_thieu = $gioi_thieu;
                }elseif($value->nguon == "trxs"){
                    $url = get_url($value->nguon,$value->link);
                    $client = new Client();
                    $new_url = "http://vietphrase.info/VietPhrase/Browser?url=".$url."&script=false&t=VP";
                    $crawler = $client->request('GET', $new_url);
                    $tieu_de = explode('(', $crawler->filter('#html > div.readContent > div.book_info.clearfix > div.infos > h1')->text())[0];
                    $tac_gia = $crawler->filter('#html > div.readContent > div.book_info.clearfix > div.infos > div.date > span > a')->text();
                    $gioi_thieu = $crawler->filter('#html > div.readContent > div.book_info.clearfix > div.infos > p')->html();
                    if(empty($gioi_thieu)){
                        $gioi_thieu = "Đọc truyện ".$tieu_de." của ".$tac_gia." tại http://www.trxs.cc";
                    }
                    $truyen_sub->tieu_de = $tieu_de;
                    $truyen_sub->tac_gia = $tac_gia;
                    $truyen_sub->gioi_thieu = $gioi_thieu;
                }
                else{
                    $truyen_sub->tieu_de = $value->tieu_de;
                    $truyen_sub->tac_gia = $value->tac_gia;
                    $truyen_sub->gioi_thieu = $value->gioi_thieu;
                }
            }else{
                $truyen_sub->tieu_de = $value->tieu_de;
                $truyen_sub->tac_gia = $value->tac_gia;
                $truyen_sub->gioi_thieu = $value->gioi_thieu;
            }
            $truyen_sub->save();
        }
    }
}
function get_data_chapter($position,$data_chapter,$truyen){
    $client = new Client();
    if($truyen->nguon == "230book"){
        $get_url = "http://www.230book.net/book/".$truyen->link.'/'.$data_chapter[$position]['link'];
        $crawler = $client->request('GET', $get_url);
        try{
            $str = $crawler->filter('#content')->html();
        }catch(Throwable $e){
            return 0;
        }
        $get_url1 = "http://vietphrase.info/VietPhrase/Browser?url=".$get_url."&script=false&t=VP";
        $crawler1 = $client->request('GET', $get_url1);
        try{
            $str1 = $crawler1->filter('#content')->html();
        }catch(Throwable $e){
            return 0;
        }
        $data_chapter[$position]['noi_dung'] = $str;
        $data_chapter[$position]['noi_dung_sub'] = $str1;
        save_chapter($data_chapter,$truyen->id);
        return 1;
    }elseif($truyen->nguon == "trxs"){
        $get_url = "https://trxs.cc/tongren/".$truyen->link.'/'.$data_chapter[$position]['link'];
        $crawler = $client->request('GET', $get_url);
        try{
            $str = $crawler->filter('#readContent_set > div.readDetail > div.read_chapterDetail')->html();
        }catch(Throwable $e){
            return 0;
        }
        $get_url1 = "http://vietphrase.info/VietPhrase/Browser?url=".$get_url."&script=false&t=VP";
        $crawler1 = $client->request('GET', $get_url1);
        try{
            $str1 = $crawler1->filter('#readContent_set > div.readDetail > div.read_chapterDetail')->html();
        }catch(Throwable $e){
            return 0;
        }
        $data_chapter[$position]['noi_dung'] = $str;
        $data_chapter[$position]['noi_dung_sub'] = $str1;
        save_chapter($data_chapter,$truyen->id);
        return 1;
    }else{
        return 0;
    }
}
function get_the_loai($host,$crawler,$id_truyen){
    if($host == "230book"){
        try{
            $the_loai = $crawler->filter('#wrapper > div.box_con > div.con_top')->text();
            if(strpos($the_loai, '玄幻小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[1]['ten'] = "Huyền huyễn";
                save_theloai($data_theloai,$id_truyen);
            }elseif(strpos($the_loai, '修真小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[3]['ten'] = "Tu tiên";
                save_theloai($data_theloai,$id_truyen);
            }elseif(strpos($the_loai, '都市小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[4]['ten'] = "Đô thị";
                save_theloai($data_theloai,$id_truyen);
            }elseif(strpos($the_loai, '穿越小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[5]['ten'] = "Xuyên việt";
                save_theloai($data_theloai,$id_truyen);
            }elseif(strpos($the_loai, '网游小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[6]['ten'] = "Võng du";
                save_theloai($data_theloai,$id_truyen);
            }elseif(strpos($the_loai, '科幻小说') !== false){
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[7]['ten'] = "Khoa huyễn";
                save_theloai($data_theloai,$id_truyen);
            }else{
                $data_theloai = data_theloai($id_truyen);
                $data_theloai[2]['ten'] = "khác";
                save_theloai($data_theloai,$id_truyen);
            }
            return 1;
        }catch(Throwable $e){
            return 0;
        }
    }elseif($host == "uukanshu"){
        return 0;
    }elseif($host == "trxs"){
        try{
            $data_theloai = data_theloai($id_truyen);
            $data_theloai[34]['ten'] = "Đồng nhân";
            save_theloai($data_theloai,$id_truyen);
            return 1;
        }catch(Throwable $e){
            return 0;
        }
    }else{
        return 0;
    }
}
function check_chuyendo(){
    $chuyen_do = ChuyenItem::get();
    foreach($chuyen_do as $key => $value){
        $chuyen_do_num = ChuyenItem::find($value->id);
        if(empty(User::find($chuyen_do_num->id_gui)) ){
            $chuyen_do_num->delete();
        }elseif(empty(User::find($chuyen_do_num->id_nhan)) ){
            $uid = $chuyen_do_num->id_gui;
            $data_tuido = data_tuido($uid);
            $path = UserPath::find($uid);
            //nguyên liệu
            if(isset($chuyen_do_num->nguyenlieu_id)){
                $item = NguyenLieuModel::find($chuyen_do_num->nguyenlieu_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] + $chuyen_do_num->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_nguyenlieu'][$item->id]['so_luong'] =  $chuyen_do_num->so_luong;
                }
            }
            //vạn năng
            elseif(isset($chuyen_do_num->vannang_id)){
                $item = VanNangModel::find($chuyen_do_num->vannang_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] + $chuyen_do_num->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_vannang'][$item->id]['so_luong'] =  $chuyen_do_num->so_luong;
                }
            }
            //đột phá
            elseif(isset($chuyen_do_num->dotpha_id)){
                $item = DotPhaModel::find($chuyen_do_num->dotpha_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] + $chuyen_do_num->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['tuido_dotpha'][$item->id]['so_luong'] =  $chuyen_do_num->so_luong;
                }
            }
            //công pháp
            elseif(isset($chuyen_do_num->congphap_id)){
                $item = CongPhapModel::find($chuyen_do_num->congphap_id);
                if(empty($item)){
                    return Redirect()->back()->with('error','Không tìm thấy đồ bạn chuyển');
                }
                try{
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $data_tuido[0]['cong_phap'][$item->id]['so_luong'] + $chuyen_do_num->so_luong;
                }catch(Throwable $e){
                    $data_tuido[0]['cong_phap'][$item->id]['so_luong'] =  $chuyen_do_num->so_luong;
                }
            }else{
                $chuyen_do_num->delete();
                DB::statement('ALTER TABLE chuyen_do AUTO_INCREMENT=1');
                return Redirect()->back()->with('error','Có lỗi xảy ra');
            }
        //end lấy thông tin item
        save_tuido($data_tuido,$uid);
        $chuyen_do_num->delete();
        DB::statement('ALTER TABLE chuyen_do AUTO_INCREMENT=1');
        }
    }
}
