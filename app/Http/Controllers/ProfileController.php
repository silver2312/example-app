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
            return redirect()->back()->with('error', 'Bạn đã có mã cấp 2 rồi');
        }
        $data = $request->validate([
            'ma_c2' => 'required|string|max:10',
            'pwd' => 'required|string|min:8',
        ],
        [
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'pwd.required' => 'Mật khẩu không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'pwd.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'pwd.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
        ]);
        if (Hash::check($data['pwd'], $user->password)) {
            $user->ma_c2 = Hash::make($data['ma_c2']);
            $user->save();
            return redirect()->back()->with('status', 'Tạo mã cấp 2 thành công');
        }else{
            return redirect()->back()->with('error', 'Mật khẩu không đúng');
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
            'pwd.required' => 'Mật khẩu không được bỏ trống.',
            'pwd.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'pwd.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'old.required' => 'Mã cấp 2 cũ không được bỏ trống.',
            'old.max' => 'Mã cấp 2 cũ không được quá 10 ký tự.',
            'old.string' => 'Mã cấp 2 cũ phải là chuỗi ký tự.',
            'new.required' => 'Mã cấp 2 mới không được bỏ trống.',
            'new.max' => 'Mã cấp 2 mới không được quá 10 ký tự.',
            'new.string' => 'Mã cấp 2 mới phải là chuỗi ký tự.',
        ]);
        if( Hash::check($data['new'], $user->ma_c2) ){
            return redirect()->back()->with('error', 'Mã cấp 2 mới không được trùng với mã cấp 2 cũ');
        }
        if ( Hash::check($data['pwd'], $user->password) ) {
            if ( Hash::check($data['old'], $user->ma_c2) ) {
                $user->ma_c2 = Hash::make($data['new']);
                $user->save();
                return redirect()->back()->with('status', 'Đổi mã cấp 2 thành công');
            }else{
                return redirect()->back()->with('error', 'Mã cấp 2 cũ không đúng');
            }
        }else{
            return redirect()->back()->with('error', 'Mật khẩu không đúng');
        }
    }
    public function doi_mk(Request $request){
        $data = $request->validate([
            'old' => 'required|string|min:8',
            'new' => 'required|string|min:8',
        ],[
            'old.required' => 'Mật khẩu cũ không được bỏ trống.',
            'old.min' => 'Mật khẩu cũ phải có ít nhất 8 ký tự.',
            'old.string' => 'Mật khẩu cũ phải là chuỗi ký tự.',
            'new.required' => 'Mật khẩu mới không được bỏ trống.',
            'new.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'new.string' => 'Mật khẩu mới phải là chuỗi ký tự.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if( Hash::check($data['new'], $user->password) ){
            return redirect()->back()->with('error', 'Mật khẩu mới không được trùng với mật khẩu cũ');
        }

        if (Hash::check($data['old'], $user->password)) {
            $user->password = Hash::make($data['new']);
            $user->save();
            Auth::logout();
            return redirect('/')->with('status', 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
        }else{
            return redirect()->back()->with('error', 'Mật khẩu không đúng');
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
            'pwd.required' => 'Mật khẩu không được bỏ trống.',
            'pwd.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'pwd.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
            'email.required' => 'Email không được bỏ trống.',
            'email.max' => 'Email không được quá 255 ký tự.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'email_old.required' => 'Email cũ không được bỏ trống.',
            'email_old.max' => 'Email cũ không được quá 255 ký tự.',
            'email_old.string' => 'Email cũ phải là chuỗi ký tự.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if (Hash::check($data['pwd'], $user->password)) {
            if (Hash::check($data['ma_c2'], $user->ma_c2)) {
                if($data['email_old'] != $user->email){
                    return Redirect()->back()->with('error','Email cũ không đúng.');
                }
                $user->email = $data['email'];
                $user->email_verified_at = null;
                $user->created_at = Carbon::now();
                $user->save();
                Auth::logout();
                return Redirect('/')->with('status','Đã đổi email thành công. Vui lòng xác nhận lại email mới.');
            }else{
                return Redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
        }else{
            return Redirect()->back()->with('error','Mật khẩu không đúng.');
        }
    }
    public function del_acc(Request $request){
        $data = $request->validate([
            'pwd' => 'required|min:8|string',
            'ma_c2' => 'required|max:10|string',
            'email' => 'required|max:255|string|email'
        ],
        [
            'pwd.required' => 'Mật khẩu không được bỏ trống.',
            'pwd.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'pwd.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
            'email.required' => 'Email không được bỏ trống.',
            'email.max' => 'Email không được quá 255 ký tự.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Email không đúng định dạng.',
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
                    return Redirect('/')->with('status','Đã xóa tài khoản thành công.');
                }else{
                    return Redirect()->back()->with('error','Email không đúng.');
                }
            }else{
                return Redirect()->back()->with('error','Mã cấp 2 không đúng.');
            }
        }else{
            return Redirect()->back()->with('error','Mật khẩu không đúng.');
        }
    }
    public function doi_avt(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','Bạn không đủ 1000 ngân tệ để đổi nhạc.');
        }
        $request->validate([
            "u_image" => 'required','file','max:1024',
            'ma_c2' => 'required|max:10|string',
        ],[
            'u_image.required' => 'Ảnh đại diện không được bỏ trống.',
            'u_image.file' => 'Ảnh đại diện không đúng định dạng.',
            'u_image.max' => 'Ảnh đại diện tối đa 1024 kb.',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
        ]);
        if(Hash::check($request['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
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
        return Redirect()->back()->with('status','Đổi ảnh đại diện thành công.');
    }
    public function doi_ten(Request $request)
    {
        $data = $request->validate([
            "name" => 'required|max:30|unique:users',
            'ma_c2' => 'required|max:10|string',
        ],[
            'name.required' => 'Tên không được bỏ trống.',
            'name.max' => 'Tên tối đa 30 ký tự.',
            'name.unique' => 'Tên đã tồn tại.',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','Bạn không đủ 1000 ngân tệ để đổi tên.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000,
            'name' => $data['name']
        ])->save();
        return Redirect()->back()->with('status','Đổi tên thành công.');
    }
    public function doi_anh_bia(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','Bạn không đủ 1000 ngân tệ để đổi ảnh bìa.');
        }
        $data = $request->validate([
            'ma_c2' => 'required|max:10|string',
            'link_anh' => 'url',
        ],[
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
            'link_anh.url' => 'Link ảnh bìa không đúng định dạng.',
        ]);
        $profile = Profile::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000
        ])->save();
        $profile->bg_img = $data['link_anh'];
        $profile->save();
        return Redirect()->back()->with('status','Đổi ảnh bìa thành công.');
    }
    public function doi_nhac(Request $request)
    {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        check_data($user);
        if($user->ngan_te < 1000){
            return redirect()->back()->with('error','Bạn không đủ 1000 ngân tệ để đổi nhạc.');
        }
        $data = $request->validate([
            'link_nhac' => 'url',
            'ten_nhac' => 'min:3|max:80',
            'ma_c2' => 'required|max:10|string',
        ],[
            'link_nhac.url' => 'Link nhạc không đúng định dạng.',
            'ten_nhac.min' => 'Tên nhạc lớn hơn 3 chữ số.',
            'ten_nhac.max' => 'Tên nhạc nhỏ hơn 80 chữ số.',
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
        ]);
        $profile = Profile::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $user->fill([
            'ngan_te' => $user->ngan_te - 1000
        ])->save();
        $profile->link_nhac = $data['link_nhac'];
        $profile->ten_nhac = $data['ten_nhac'];
        $profile->save();
        return Redirect()->back()->with('status','Đổi nhạc thành công.');
    }
    public function doi_thong_tin(Request $request)
    {
        $data = $request->validate([
            'ma_c2' => 'required|max:10|string',
            'gioi_thieu' => 'max:255',
        ],[
            'ma_c2.required' => 'Mã cấp 2 không được bỏ trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
            'ma_c2.string' => 'Mã cấp 2 phải là chuỗi ký tự.',
            'gioi_thieu.max' => 'Giới thiệu không được quá 255 ký tự.',
        ]);
        $uid = Auth::user()->id;
        $profile = Profile::find($uid);
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $profile->gioi_thieu = $data['gioi_thieu'];
        $profile->save();
        return Redirect()->back()->with('status','Đổi thông tin thành công.');
    }
    public function cmt(Request $request,$uid){
        $data = $request->validate([
            'noi_dung' => 'required|max:255|string'
        ],
        [
            'noi_dung.required' => 'Nội dung không được bỏ trống.',
            'noi_dung.max' => 'Nội dung tối đa 255 ký tự.',
            'noi_dung.string' => 'Nội dung phải là chuỗi ký tự.',
        ]);
        $data_cmt = data_cmt($uid);
        $time = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $data_cmt[$time]['noi_dung'] = $data['noi_dung'];
        $data_cmt[$time]['uid'] = Auth::user()->id;
        save_cmt($data_cmt,$uid);
        return Redirect()->back()->with('status','Gửi thành công.');
    }
    public function rep(Request $request, $uid,$cmt_id){
        $data = $request->validate([
            'noi_dung' => 'required|max:255|string'
        ],
        [
            'noi_dung.required' => 'Nội dung không được bỏ trống.',
            'noi_dung.max' => 'Nội dung tối đa 255 ký tự.',
            'noi_dung.string' => 'Nội dung phải là chuỗi ký tự.',
        ]);
        $data_rep = data_rep($uid);
        $time = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        $data_rep[$cmt_id][$time]['noi_dung'] = $data['noi_dung'];
        $data_rep[$cmt_id][$time]['uid'] = Auth::user()->id;
        save_rep($data_rep,$uid);
        return Redirect()->back()->with('status','Gửi thành công.');
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
            echo "Chưa có trả lời nào.";
        }
        unset($data_cmt[$cmt_id]);
        save_cmt($data_cmt,$uid);
        return Redirect()->back()->with('status','Xóa bình luận thành công.');
    }
    public function xoa_rep($cmt_id,$rep_id){
        $uid = Auth::user()->id;
        $data_reply = data_rep($uid);
        check_data($data_reply);
        unset($data_reply[$cmt_id][$rep_id]);
        save_rep($data_reply,$uid);
        return Redirect()->back()->with('status','Xóa trả lời thành công.');
    }
    public function quen_c2(){
        $uid = Auth::user()->id;
        $profile = Profile::find($uid);
        $ma_xn = MaXacNhan::find($uid);
        $ran = random_ma_xn();
        if( empty($ma_xn) ){
            $details = [
                'title' => 'Mã xác nhận',
                'body' => 'Mã xác nhận của bạn: '.$ran
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
                    'title' => 'Mã xác nhận',
                    'body' => 'Mã xác nhận của bạn: '.$ran
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
            return Redirect()->back()->with('error','Vui lòng chờ '.($ma_xn->time_out - $now).' giây để gửi lại mã xác nhận.');
        }else{
            $details = [
                'title' => 'Mã xác nhận quên mã cấp 2',
                'body' => 'Mã xác nhận của bạn: '.$ran
            ];
            Mail::to(Auth::user()->email)->send(new \App\Mail\SendMails($details));
            $ma_xn->ma_xn = $ran;
            $ma_xn->time_out = strtotime(Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15));
            $ma_xn->save();
            return Redirect()->back()->with('status','Đã gửi lại mã xác nhận thành công.');
        }
    }
    public function xn_quen_c2(Request $request){
        $data = $request->validate([
            'ma_xn' => 'required|string|max:10',
            'ma_c2' => 'required|string|max:10',
        ],[
            'ma_xn.required' => 'Mã xác nhận không được để trống.',
            'ma_xn.max' => 'Mã xác nhận không được quá 10 ký tự.',
            'ma_c2.required' => 'Mã cấp 2 không được để trống.',
            'ma_c2.max' => 'Mã cấp 2 không được quá 10 ký tự.',
        ]);
        $uid = Auth::user()->id;
        $ma_xn = MaXacNhan::find($uid);
        check_data($ma_xn);
        if($data['ma_xn'] == $ma_xn->ma_xn){
            $user = User::find($uid);
            check_data($user);
            $user->ma_c2 = Hash::make($data['ma_c2']);
            $user->save();
            return Redirect('trang-ca-nhan/'.$uid)->with('status','Mã cấp 2 của bạn đã được cập nhật.');
        }else{
            return Redirect()->back()->with('error','Mã xác nhận không chính xác.');
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
