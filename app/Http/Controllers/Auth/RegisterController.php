<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'u_image' => ['required','file','max:1024'],
            'key' => ['required','unique:users'],
        ],
        [
            'name.required' => 'Tên không được bỏ trống.',
            'name.max' => 'Tên tối đã 30 ký tự.',
            'email.max' => 'Email tối đã 255 ký tự.',
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu tối thiêu 8 ký tự.',
            'password.max' => 'Mật khẩu tối đa 32 ký tự.',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.confirmed' => 'Mật khẩu không trùng khớp.',
            'u_image.required' => 'Ảnh đại diện không được bỏ trống.',
            'u_image.file' => 'Ảnh đại diện không đúng định dạng.',
            'u_image.max' => 'Ảnh đại diện tối đa 1024 kb.',
            'key.required' => 'Mã xác nhận không được bỏ trống.',
            'key.unique' => 'Mỗi người một tài khoản tạo clone qq à.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $request = request();
        $get_image = $request->file('u_image');
        $path = 'upload/user/';
        $cut = preg_split ("/\@/", $data['email']);
        $get_name_image = $get_image->getClientOriginalName();
        $cutname = preg_split ("/\./", $get_name_image);
        $name_image = $cut[0].'.'.$cutname[1];
        $get_image->move($path,$name_image);
        $img = $path.$name_image;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'u_image' => $img,
            'level' => 10,
            'dong_te' => 0,
            'me' => 0,
            'ngan_te' => 0,
            'kim_te' => 0,
            'vip_time' => 0,
            'key' => $data['key'],
            'level_tuluyen' => 0,
            'phan_tram' => 0,
        ]);
    }
}
