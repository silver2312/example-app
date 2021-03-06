<?php
use App\Models\Game\UserPath;
use App\Models\PathAll;
use App\Models\Truyen\PathTruyen;

function data_nhanvat($id){
    $path = UserPath::find($id);
    $json_nhanvat = file_get_contents($path->path_nhanvat);
    $data_nhanvat = json_decode($json_nhanvat,true);
    return $data_nhanvat;
}
function save_nhanvat($data_nhanvat,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_nhanvat, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_nhanvat, $newJsonString);
}
function data_thongtin($id){
    $user_path = UserPath::find($id);
    $json_thongtin = file_get_contents($user_path->path_thongtin);
    $data_thongtin = json_decode($json_thongtin,true);
    return $data_thongtin;
}
function save_thongtin($data_thongtin,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_thongtin, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_thongtin, $newJsonString);
}
function data_nangluong(){
    $path = PathAll::first();
    $json_nangluong = file_get_contents($path->path_chungtoc);
    $data_nangluong = json_decode($json_nangluong,true);
    return $data_nangluong;
}
function data_tuido($id){
    $user_path = UserPath::find($id);
    $json_tuido = file_get_contents($user_path->path_tuido);
    $data_tuido = json_decode($json_tuido,true);
    return $data_tuido;
}
function save_tuido($data_tuido,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_tuido, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_tuido, $newJsonString);
}
function data_congphap($id){
    $user_path = UserPath::find($id);
    $json_congphap = file_get_contents($user_path->path_congphap);
    $data_congphap = json_decode($json_congphap,true);
    return $data_congphap;
}
function save_congphap($data_congphap,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_congphap, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_congphap, $newJsonString);
}
function data_log($id){
    $user_path = UserPath::find($id);
    $json_log = file_get_contents($user_path->path_log);
    $data_log = json_decode($json_log,true);
    return $data_log;
}
function save_log($data_log,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_log, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_log, $newJsonString);
}
function request_item($request){
    $data = $request->validate([
        'so_luong' => 'required|numeric|min:1',
        'ma_c2' => 'required|max:10',
        'item_id' => 'required|numeric|min:1',
    ],[
        'so_luong.required' => 'Kh??ng ???????c b??? tr???ng s??? l?????ng',
        'so_luong.numeric' => 'S??? l?????ng ph???i l?? s???',
        'so_luong.min' => 'S??? l?????ng ph???i l???n h??n b???ng 1',
        'ma_c2.required' => 'Kh??ng ???????c b??? tr???ng m?? c???p 2',
        'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c v?????t qu?? 10 k?? t???',
        'item_id.required' => 'Kh??ng ???????c b??? tr???ng m?? item',
        'item_id.numeric' => 'M?? item ph???i l?? s???',
        'item_id.min' => 'M?? item ph???i l???n h??n b???ng 1',
    ]);
    return $data;
}
function data_cmt($uid){
    $user_path = UserPath::find($uid);
    $json_cmt = file_get_contents($user_path->path_cmt);
    $data_cmt = json_decode($json_cmt,true);
    return $data_cmt;
}
function save_cmt($data_cmt,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_cmt, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_cmt, $newJsonString);
}
function data_rep($uid){
    $user_path = UserPath::find($uid);
    $json_rep = file_get_contents($user_path->path_rep);
    $data_rep = json_decode($json_rep,true);
    return $data_rep;
}
function save_rep($data_rep,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_rep, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_rep, $newJsonString);
}
function data_tanthu(){
    $path = PathAll::first();
    $json_tanthu = file_get_contents($path->path_tanthu);
    $data_tanthu = json_decode($json_tanthu,true);
    return $data_tanthu;
}
function save_tanthu($data_tanthu){
    $path = PathAll::first();
    $newJsonString = json_encode($data_tanthu, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($path->path_tanthu, $newJsonString);
}
function data_tieuphi($uid){
    $user_path = UserPath::find($uid);
    $json_tieuphi = file_get_contents($user_path->path_tieuphi);
    $data_tieuphi = json_decode($json_tieuphi,true);
    return $data_tieuphi;
}
function save_tieuphi($data_tieuphi,$uid){
    $user_path = UserPath::find($uid);
    $newJsonString = json_encode($data_tieuphi, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_tieuphi, $newJsonString);
}
function remove_cp($uid){
    $data_cp = data_congphap($uid);
    if(empty($data_cp[0])){
        return redirect()->back()->with('error','Ch??a c?? c??ng ph??p.');
    }
    $cp_id = $data_cp[0]['cp_id'];
    $data_tuido = data_tuido($uid);
    try{
        $data_tuido[0]['cong_phap'][$cp_id]['so_luong'] = $data_tuido[0]['cong_phap'][$cp_id]['so_luong'] + 1;
    }catch (\Exception $e){
        $data_tuido[0]['cong_phap'][$cp_id]['so_luong'] =  1;
    }
    save_tuido($data_tuido,$uid);
    unset($data_cp[0]);
    save_congphap($data_cp,$uid);
}
function request_bando($request){
    $data = $request->validate([
        'so_luong' => 'required|numeric|min:1',
        'ma_c2' => 'required|max:10'
    ],[
        'so_luong.required' => 'B???n ch??a nh???p s??? l?????ng',
        'so_luong.numeric' => 'S??? l?????ng ph???i l?? s???',
        'so_luong.min' => 'S??? l?????ng ph???i l???n h??n 0',
        'ma_c2.required' => 'B???n ch??a nh???p m?? c2',
        'ma_c2.max' => 'M?? c2 kh??ng ???????c v?????t qu?? 10 k?? t???'
    ]);
    return $data;
}
function request_chuyendo($request){
    $data = $request->validate([
        'so_luong' => 'required|numeric|min:1',
        'ma_c2' => 'required|max:10',
        'dong_te' => 'required|numeric|min:0',
        'ngan_te' => 'required|numeric|min:0',
        'kim_te' => 'required|numeric|min:0',
        'id_nhan'=> 'required|numeric|min:0'
    ],[
        'so_luong.required' => 'B???n ch??a nh???p s??? l?????ng',
        'so_luong.numeric' => 'S??? l?????ng ph???i l?? s???',
        'so_luong.min' => 'S??? l?????ng ph???i l???n h??n 0',
        'ma_c2.required' => 'B???n ch??a nh???p m?? c2',
        'ma_c2.max' => 'M?? c2 kh??ng ???????c v?????t qu?? 10 k?? t???',
        'dong_te.required' => 'B???n ch??a nh???p ?????ng t???',
        'dong_te.numeric' => '?????ng t??? ph???i l?? s???',
        'dong_te.min' => '?????ng t??? ph???i l???n h??n b???ng 0',
        'ngan_te.required' => 'B???n ch??a nh???p ng??n t???',
        'ngan_te.numeric' => 'Ng??n t??? ph???i l?? s???',
        'ngan_te.min' => 'Ng??n t??? ph???i l???n h??n b???ng 0',
        'kim_te.required' => 'B???n ch??a nh???p kim t???',
        'kim_te.numeric' => 'Kim t??? ph???i l?? s???',
        'kim_te.min' => 'Kim t??? ph???i l???n h??n b???ng 0',
        'id_nhan.required' => 'B???n ch??a nh???p id ng?????i nh???n',
        'id_nhan.numeric' => 'Id ng?????i nh???n ph???i l?? s???',
        'id_nhan.min' => 'Id ng?????i nh???n ph???i l???n h??n b???ng 0'
    ]);
    return $data;
}
function data_chungtoc(){
    $path = PathAll::first();
    $json_chungtoc = file_get_contents($path->path_chungtoc);
    $data_chungtoc = json_decode($json_chungtoc,true);
    return $data_chungtoc;
}
function save_chungtoc($data_chungtoc){
    $path = PathAll::first();
    $newJsonString = json_encode($data_chungtoc, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($path->path_chungtoc, $newJsonString);
}
function data_he(){
    $path = PathAll::first();
    $json_he = file_get_contents($path->khac_che_he);
    $data_he = json_decode($json_he,true);
    return $data_he;
}
function save_he($data_he){
    $path = PathAll::first();
    $newJsonString = json_encode($data_he, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($path->khac_che_he, $newJsonString);
}
function data_chapter($id){
    $truyen = PathTruyen::find($id);
    $json_chapter = file_get_contents($truyen->path_chuong);
    $data_chapter = json_decode($json_chapter,true);
    return $data_chapter;
}
function save_chapter($data_chapter,$id){
    $truyen = PathTruyen::find($id);
    $newJsonString = json_encode($data_chapter, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($truyen->path_chuong, $newJsonString);
}
function data_theloai($id){
    $truyen = PathTruyen::find($id);
    $json_theloai = file_get_contents($truyen->path_theloai);
    $data_theloai = json_decode($json_theloai,true);
    return $data_theloai;
}
function save_theloai($data_theloai,$id){
    $truyen = PathTruyen::find($id);
    $newJsonString = json_encode($data_theloai, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($truyen->path_theloai, $newJsonString);
}
function data_tag($id){
    $truyen = PathTruyen::find($id);
    $json_tag = file_get_contents($truyen->path_tag);
    $data_tag = json_decode($json_tag,true);
    return $data_tag;
}
function save_tag($data_tag,$id){
    $truyen = PathTruyen::find($id);
    $newJsonString = json_encode($data_tag, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($truyen->path_tag, $newJsonString);
}
function data_dangdoc($id){
    $user_path = UserPath::find($id);
    $json_dangdoc = file_get_contents($user_path->path_dangdoc);
    $data_dangdoc = json_decode($json_dangdoc,true);
    return $data_dangdoc;
}
function save_dangdoc($data_dangdoc,$id){
    $user_path = UserPath::find($id);
    $newJsonString = json_encode($data_dangdoc, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_dangdoc, $newJsonString);
}
function data_tutruyen($id){
    $user_path = UserPath::find($id);
    $json_tutruyen = file_get_contents($user_path->path_tutruyen);
    $data_tutruyen = json_decode($json_tutruyen,true);
    return $data_tutruyen;
}
function save_tutruyen($data_tutruyen,$id){
    $user_path = UserPath::find($id);
    $newJsonString = json_encode($data_tutruyen, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($user_path->path_tutruyen, $newJsonString);
}
function data_like($id){
    $truyen = PathTruyen::find($id);
    $json_like = file_get_contents($truyen->path_like);
    $data_like = json_decode($json_like,true);
    return $data_like;
}
function save_like($data_like,$id){
    $truyen = PathTruyen::find($id);
    $newJsonString = json_encode($data_like, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($truyen->path_like, $newJsonString);
}
function data_dislike($id){
    $truyen = PathTruyen::find($id);
    $json_dislike = file_get_contents($truyen->path_dislike);
    $data_dislike = json_decode($json_dislike,true);
    return $data_dislike;
}
function save_dislike($data_dislike,$id){
    $truyen = PathTruyen::find($id);
    $newJsonString = json_encode($data_dislike, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
    file_put_contents($truyen->path_dislike, $newJsonString);
}
