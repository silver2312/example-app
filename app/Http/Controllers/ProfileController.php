<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Profile;
use App\Models\User;
use App\Models\MaXacNhan;
use App\Models\Game\VuKhiModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\Item\ChuyenItem;
use Throwable;

class ProfileController extends Controller
{
    public function index($id)
    {
        $profile = Profile::find($id);
        $user = User::find($id);
        check_data($user);
        $data_nhanvat = data_nhanvat($id);
        $data_thongtin = data_thongtin($id);
        $vu_khi = VuKhiModel::get();
        $nang_luong = NangLuongModel::get();
        $data_comment = data_cmt($id);
        $data_reply = data_rep($id);
        $data_congphap = data_congphap($id);
        $chuyen_do = ChuyenItem::get();
        if(Auth::check()){
            $uid = Auth::user()->id;
            if($uid == $id || Auth::user()->level == 0){
                return view('pages.profile')->with(compact('profile', 'user', 'data_nhanvat', 'vu_khi', 'nang_luong', 'data_thongtin', 'data_comment', 'data_reply', 'uid', 'data_congphap', 'chuyen_do'));
            }else{
                return view('pages.profile')->with(compact('profile', 'user', 'data_nhanvat', 'vu_khi', 'nang_luong', 'data_thongtin', 'data_comment', 'data_reply', 'data_congphap', 'chuyen_do'));
            }
        }else{
            return view('pages.profile')->with(compact('profile', 'user', 'data_nhanvat', 'vu_khi', 'nang_luong', 'data_thongtin', 'data_comment', 'data_reply', 'data_congphap', 'chuyen_do'));
        }
    }
    public function setting(){
        $id = Auth::user()->id;
        $user = User::find($id);
        $log = data_log($id);
        return view('pages.setting')->with(compact('user', 'log'));
    }
    public function tao_ma_cap_2(Request $request){
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if( isset($user->ma_c2) ){
            return redirect()->back()->with('error', 'B???n ???? c?? m?? c???p 2 r???i');
        }
        $data = $request->validate([
            'ma_c2' => 'required|string|max:10',
            'pwd' => 'required|string|min:8',
        ],
        [
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'pwd.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'pwd.min' => 'M???t kh???u ph???i c?? ??t nh???t 8 k?? t???.',
            'pwd.string' => 'M???t kh???u ph???i l?? chu???i k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
        ]);
        if (Hash::check($data['pwd'], $user->password)) {
            $user->ma_c2 = Hash::make($data['ma_c2']);
            $user->save();
            return redirect()->back()->with('status', 'T???o m?? c???p 2 th??nh c??ng');
        }else{
            return redirect()->back()->with('error', 'M???t kh???u kh??ng ????ng');
        }
    }
    public function doi_mac2(Request $request){
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        $data = $request->validate([
            'old' => 'required|string|max:10',
            'pwd' => 'required|string|min:8',
            'new' => 'required|string|max:10',
        ],
        [
            'pwd.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng.',
            'pwd.min' => 'M???t kh???u ph???i c?? ??t nh???t 8 k?? t???.',
            'pwd.string' => 'M???t kh???u ph???i l?? chu???i k?? t???.',
            'old.required' => 'M?? c???p 2 c?? kh??ng ???????c b??? tr???ng.',
            'old.max' => 'M?? c???p 2 c?? kh??ng ???????c qu?? 10 k?? t???.',
            'old.string' => 'M?? c???p 2 c?? ph???i l?? chu???i k?? t???.',
            'new.required' => 'M?? c???p 2 m???i kh??ng ???????c b??? tr???ng.',
            'new.max' => 'M?? c???p 2 m???i kh??ng ???????c qu?? 10 k?? t???.',
            'new.string' => 'M?? c???p 2 m???i ph???i l?? chu???i k?? t???.',
        ]);
        if( Hash::check($data['new'], $user->ma_c2) ){
            return redirect()->back()->with('error', 'M?? c???p 2 m???i kh??ng ???????c tr??ng v???i m?? c???p 2 c??');
        }
        if ( Hash::check($data['pwd'], $user->password) ) {
            if ( Hash::check($data['old'], $user->ma_c2) ) {
                $user->ma_c2 = Hash::make($data['new']);
                $user->save();
                return redirect()->back()->with('status', '?????i m?? c???p 2 th??nh c??ng');
            }else{
                return redirect()->back()->with('error', 'M?? c???p 2 c?? kh??ng ????ng');
            }
        }else{
            return redirect()->back()->with('error', 'M???t kh???u kh??ng ????ng');
        }
    }
    public function doi_mk(Request $request){
        $data = $request->validate([
            'old' => 'required|string|min:8',
            'new' => 'required|string|min:8',
        ],[
            'old.required' => 'M???t kh???u c?? kh??ng ???????c b??? tr???ng.',
            'old.min' => 'M???t kh???u c?? ph???i c?? ??t nh???t 8 k?? t???.',
            'old.string' => 'M???t kh???u c?? ph???i l?? chu???i k?? t???.',
            'new.required' => 'M???t kh???u m???i kh??ng ???????c b??? tr???ng.',
            'new.min' => 'M???t kh???u m???i ph???i c?? ??t nh???t 8 k?? t???.',
            'new.string' => 'M???t kh???u m???i ph???i l?? chu???i k?? t???.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if( Hash::check($data['new'], $user->password) ){
            return redirect()->back()->with('error', 'M???t kh???u m???i kh??ng ???????c tr??ng v???i m???t kh???u c??');
        }

        if (Hash::check($data['old'], $user->password)) {
            $user->password = Hash::make($data['new']);
            $user->save();
            Auth::logout();
            return redirect('/')->with('status', '?????i m???t kh???u th??nh c??ng. Vui l??ng ????ng nh???p l???i.');
        }else{
            return redirect()->back()->with('error', 'M???t kh???u kh??ng ????ng');
        }
    }
    public function doi_email(Request $request){
        $data = $request->validate([
            'pwd' => 'required|min:8|string',
            'ma_c2' => 'required|max:10|string',
            'email' => 'required|max:255|string|email|unique:users',
            'email_old' => 'required|max:255|string|email'
        ],
        [
            'pwd.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng.',
            'pwd.min' => 'M???t kh???u ph???i c?? ??t nh???t 8 k?? t???.',
            'pwd.string' => 'M???t kh???u ph???i l?? chu???i k?? t???.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
            'email.required' => 'Email kh??ng ???????c b??? tr???ng.',
            'email.max' => 'Email kh??ng ???????c qu?? 255 k?? t???.',
            'email.string' => 'Email ph???i l?? chu???i k?? t???.',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng.',
            'email.unique' => 'Email ???? t???n t???i.',
            'email_old.required' => 'Email c?? kh??ng ???????c b??? tr???ng.',
            'email_old.max' => 'Email c?? kh??ng ???????c qu?? 255 k?? t???.',
            'email_old.string' => 'Email c?? ph???i l?? chu???i k?? t???.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if (Hash::check($data['pwd'], $user->password)) {
            if (Hash::check($data['ma_c2'], $user->ma_c2)) {
                if($data['email_old'] != $user->email){
                    return Redirect()->back()->with('error','Email c?? kh??ng ????ng.');
                }
                $user->email = $data['email'];
                $user->email_verified_at = null;
                $user->created_at = Carbon::now();
                $user->save();
                Auth::logout();
                return Redirect('/')->with('status','???? ?????i email th??nh c??ng. Vui l??ng x??c nh???n l???i email m???i.');
            }else{
                return Redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
            }
        }else{
            return Redirect()->back()->with('error','M???t kh???u kh??ng ????ng.');
        }
    }
    public function del_acc(Request $request){
        $data = $request->validate([
            'pwd' => 'required|min:8|string',
            'ma_c2' => 'required|max:10|string',
            'email' => 'required|max:255|string|email'
        ],
        [
            'pwd.required' => 'M???t kh???u kh??ng ???????c b??? tr???ng.',
            'pwd.min' => 'M???t kh???u ph???i c?? ??t nh???t 8 k?? t???.',
            'pwd.string' => 'M???t kh???u ph???i l?? chu???i k?? t???.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
            'email.required' => 'Email kh??ng ???????c b??? tr???ng.',
            'email.max' => 'Email kh??ng ???????c qu?? 255 k?? t???.',
            'email.string' => 'Email ph???i l?? chu???i k?? t???.',
            'email.email' => 'Email kh??ng ????ng ?????nh d???ng.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if( Hash::check($data['pwd'],$user->password) ){
            if( Hash::check($data['ma_c2'],$user->ma_c2) ){
                if($data['email'] == $user->email){
                    if(file_exists($user->u_image)){
                        unlink($user->u_image);
                    }
                    $user->delete();
                    Auth::logout();
                    return Redirect('/')->with('status','???? x??a t??i kho???n th??nh c??ng.');
                }else{
                    return Redirect()->back()->with('error','Email kh??ng ????ng.');
                }
            }else{
                return Redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
            }
        }else{
            return Redirect()->back()->with('error','M???t kh???u kh??ng ????ng.');
        }
    }
    public function doi_avt(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','B???n kh??ng ????? 1000 ng??n t??? ????? ?????i nh???c.');
        }
        $request->validate([
            "u_image" => 'required','file','max:1024',
            'ma_c2' => 'required|max:10|string',
        ],[
            'u_image.required' => '???nh ?????i di???n kh??ng ???????c b??? tr???ng.',
            'u_image.file' => '???nh ?????i di???n kh??ng ????ng ?????nh d???ng.',
            'u_image.max' => '???nh ?????i di???n t???i ??a 1024 kb.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
        ]);
        if(Hash::check($request['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
        }
        if(file_exists($user->u_image)){
            unlink($user->u_image);
        }
        $get_image = $request->file('u_image');
        $path = 'upload/user/';
        $cut = preg_split ("/\@/", $user->email);
        $get_name_image = $get_image->getClientOriginalName();
        $cutname = preg_split ("/\./", $get_name_image);
        $name_image = $cut[0].'.'.$cutname[1];
        $get_image->move($path,$name_image);
        $img = $path.$name_image;
        $user->u_image = $img;
        $user->ngan_te = $user->ngan_te - 1000;
        $user->save();
        return Redirect()->back()->with('status','?????i ???nh ?????i di???n th??nh c??ng.');
    }
    public function doi_ten(Request $request)
    {
        $data = $request->validate([
            "name" => 'required|max:30|unique:users',
            'ma_c2' => 'required|max:10|string',
        ],[
            'name.required' => 'T??n kh??ng ???????c b??? tr???ng.',
            'name.max' => 'T??n t???i ??a 30 k?? t???.',
            'name.unique' => 'T??n ???? t???n t???i.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
        }
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','B???n kh??ng ????? 1000 ng??n t??? ????? ?????i t??n.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000,
            'name' => $data['name']
        ])->save();
        return Redirect()->back()->with('status','?????i t??n th??nh c??ng.');
    }
    public function doi_anh_bia(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','B???n kh??ng ????? 1000 ng??n t??? ????? ?????i ???nh b??a.');
        }
        $data = $request->validate([
            'ma_c2' => 'required|max:10|string',
            'link_anh' => 'url',
        ],[
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
            'link_anh.url' => 'Link ???nh b??a kh??ng ????ng ?????nh d???ng.',
        ]);
        $profile = Profile::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000
        ])->save();
        $profile->bg_img = $data['link_anh'];
        $profile->save();
        return Redirect()->back()->with('status','?????i ???nh b??a th??nh c??ng.');
    }
    public function doi_nhac(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','B???n kh??ng ????? 1000 ng??n t??? ????? ?????i nh???c.');
        }
        $data = $request->validate([
            'link_nhac' => 'url',
            'ten_nhac' => 'min:3|max:80',
            'ma_c2' => 'required|max:10|string',
        ],[
            'link_nhac.url' => 'Link nh???c kh??ng ????ng ?????nh d???ng.',
            'ten_nhac.min' => 'T??n nh???c l???n h??n 3 ch??? s???.',
            'ten_nhac.max' => 'T??n nh???c nh??? h??n 80 ch??? s???.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
        ]);
        $profile = Profile::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000
        ])->save();
        $profile->link_nhac = $data['link_nhac'];
        $profile->ten_nhac = $data['ten_nhac'];
        $profile->save();
        return Redirect()->back()->with('status','?????i nh???c th??nh c??ng.');
    }
    public function doi_thong_tin(Request $request)
    {
        $data = $request->validate([
            'ma_c2' => 'required|max:10|string',
            'gioi_thieu' => 'max:255',
        ],[
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c b??? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.string' => 'M?? c???p 2 ph???i l?? chu???i k?? t???.',
            'gioi_thieu.max' => 'Gi???i thi???u kh??ng ???????c qu?? 255 k?? t???.',
        ]);
        $uid = Auth::user()->id;
        $profile = Profile::find($uid);
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','M?? c???p 2 kh??ng ????ng.');
        }
        $profile->gioi_thieu = $data['gioi_thieu'];
        $profile->save();
        return Redirect()->back()->with('status','?????i th??ng tin th??nh c??ng.');
    }
    public function cmt(Request $request,$uid){
        $data = $request->validate([
            'noi_dung' => 'required|max:255|string'
        ],
        [
            'noi_dung.required' => 'N???i dung kh??ng ???????c b??? tr???ng.',
            'noi_dung.max' => 'N???i dung t???i ??a 255 k?? t???.',
            'noi_dung.string' => 'N???i dung ph???i l?? chu???i k?? t???.',
        ]);
        $data_cmt = data_cmt($uid);
        $time = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $data_cmt[$time]['noi_dung'] = $data['noi_dung'];
        $data_cmt[$time]['uid'] = Auth::user()->id;
        save_cmt($data_cmt,$uid);
        return Redirect()->back()->with('status','G???i th??nh c??ng.');
    }
    public function rep(Request $request, $uid,$cmt_id){
        $data = $request->validate([
            'noi_dung' => 'required|max:255|string'
        ],
        [
            'noi_dung.required' => 'N???i dung kh??ng ???????c b??? tr???ng.',
            'noi_dung.max' => 'N???i dung t???i ??a 255 k?? t???.',
            'noi_dung.string' => 'N???i dung ph???i l?? chu???i k?? t???.',
        ]);
        $data_rep = data_rep($uid);
        $time = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $data_rep[$cmt_id][$time]['noi_dung'] = $data['noi_dung'];
        $data_rep[$cmt_id][$time]['uid'] = Auth::user()->id;
        save_rep($data_rep,$uid);
        return Redirect()->back()->with('status','G???i th??nh c??ng.');
    }
    public function xoa_cmt($cmt_id){
        $uid = Auth::user()->id;
        $data_cmt = data_cmt($uid);
        check_data($data_cmt);
        try{
            $data_reply = data_rep($uid);
            check_data($data_reply);
            foreach($data_reply[$cmt_id] as $key_reply => $value_reply){
                if($value_reply['uid'] == $uid){
                    unset($data_reply[$cmt_id]);
                    save_rep($data_reply,$uid);
                }
            }
        }catch(Throwable $e){
            echo "Ch??a c?? tr??? l???i n??o.";
        }
        unset($data_cmt[$cmt_id]);
        save_cmt($data_cmt,$uid);
        return Redirect()->back()->with('status','X??a b??nh lu???n th??nh c??ng.');
    }
    public function xoa_rep($cmt_id,$rep_id){
        $uid = Auth::user()->id;
        $data_reply = data_rep($uid);
        check_data($data_reply);
        unset($data_reply[$cmt_id][$rep_id]);
        save_rep($data_reply,$uid);
        return Redirect()->back()->with('status','X??a tr??? l???i th??nh c??ng.');
    }
    public function quen_c2(){
        $uid = Auth::user()->id;
        $profile = Profile::find($uid);
        $ma_xn = MaXacNhan::find($uid);
        $ran = random_ma_xn();
        if( empty($ma_xn) ){
            $details = [
                'title' => 'M?? x??c nh???n',
                'body' => 'M?? x??c nh???n c???a b???n: '.$ran
            ];
            Mail::to(Auth::user()->email)->send(new \App\Mail\SendMails($details));
            $ma_xn = new MaXacNhan();
            $ma_xn->id = $uid;
            $ma_xn->ma_xn = $ran;
            $ma_xn->time_out = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15));
            $ma_xn->save();
        }else{
            $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
            if( $ma_xn->time_out < $now ){
                $details = [
                    'title' => 'M?? x??c nh???n',
                    'body' => 'M?? x??c nh???n c???a b???n: '.$ran
                ];
                Mail::to(Auth::user()->email)->send(new \App\Mail\SendMails($details));
                $ma_xn->ma_xn = $ran;
                $ma_xn->time_out = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15));
                $ma_xn->save();
            }
        }
        return view('pages.quen_mac2')->with(compact('profile'));
    }
    public function send_again(){
        $uid = Auth::user()->id;
        $ma_xn = MaXacNhan::find($uid);
        check_data($ma_xn);
        $now = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $ran = random_ma_xn();
        if( $ma_xn->time_out > $now ){
            return Redirect()->back()->with('error','Vui l??ng ch??? '.($ma_xn->time_out - $now).' gi??y ????? g???i l???i m?? x??c nh???n.');
        }else{
            $details = [
                'title' => 'M?? x??c nh???n qu??n m?? c???p 2',
                'body' => 'M?? x??c nh???n c???a b???n: '.$ran
            ];
            Mail::to(Auth::user()->email)->send(new \App\Mail\SendMails($details));
            $ma_xn->ma_xn = $ran;
            $ma_xn->time_out = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15));
            $ma_xn->save();
            return Redirect()->back()->with('status','???? g???i l???i m?? x??c nh???n th??nh c??ng.');
        }
    }
    public function xn_quen_c2(Request $request){
        $data = $request->validate([
            'ma_xn' => 'required|string|max:10',
            'ma_c2' => 'required|string|max:10',
        ],[
            'ma_xn.required' => 'M?? x??c nh???n kh??ng ???????c ????? tr???ng.',
            'ma_xn.max' => 'M?? x??c nh???n kh??ng ???????c qu?? 10 k?? t???.',
            'ma_c2.required' => 'M?? c???p 2 kh??ng ???????c ????? tr???ng.',
            'ma_c2.max' => 'M?? c???p 2 kh??ng ???????c qu?? 10 k?? t???.',
        ]);
        $uid = Auth::user()->id;
        $ma_xn = MaXacNhan::find($uid);
        check_data($ma_xn);
        if($data['ma_xn'] == $ma_xn->ma_xn){
            $user = User::find($uid);
            check_data($user);
            $user->ma_c2 = Hash::make($data['ma_c2']);
            $user->save();
            return Redirect('trang-ca-nhan/'.$uid)->with('status','M?? c???p 2 c???a b???n ???? ???????c c???p nh???t.');
        }else{
            return Redirect()->back()->with('error','M?? x??c nh???n kh??ng ch??nh x??c.');
        }
    }
    public function tu_truyen(){
        $data_tutruyen = data_tutruyen(Auth::user()->id);
        try{
            $cout_tutruyen = count($data_tutruyen);
        }catch(Throwable $e){
            $cout_tutruyen = 0;
        }
        return view('pages.tu_truyen')->with(compact('data_tutruyen','cout_tutruyen'));
    }
}
