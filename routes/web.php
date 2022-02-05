<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Goutte\Client;
use App\Models\User;
use App\Models\Session;
use App\Models\Profile;
use App\Models\Truyen\Truyen;
use App\Models\Game\ChungTocModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\TheChatModel;
use App\Models\PathAll;
use App\Models\Game\HeModel;

include('extensions/function.php');
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['auth','verified']], function(){
    Route::prefix('tu-luyen')->group(function () {
        Route::prefix('nhan-vat')->group(function () {
            Route::post('them', [App\Http\Controllers\Game\TuLuyenController::class, 'them']);
            Route::post('them-nang-luong', [App\Http\Controllers\Game\TuLuyenController::class, 'them_nang_luong']);
            Route::get('them-tu-luyen', [App\Http\Controllers\Game\TuLuyenController::class, 'them_tu_luyen']);
            Route::get('lich-luyen', [App\Http\Controllers\Game\LichLuyenController::class, 'index']);
            Route::get('len-cap', [App\Http\Controllers\Game\LichLuyenController::class, 'len_cap']);
            Route::get('tam-ma-kiep', [App\Http\Controllers\Game\LichLuyenController::class, 'tam_ma_kiep']);
            Route::get('do-kiep', [App\Http\Controllers\Game\LichLuyenController::class, 'do_kiep']);
        });
    });
    Route::prefix('trang-ca-nhan')->group(function () {
        Route::get('cai-dat', [App\Http\Controllers\ProfileController::class, 'setting']);
        Route::post('tao-ma-cap-2', [App\Http\Controllers\ProfileController::class, 'tao_ma_cap_2']);
        Route::post('cmt/{uid}', [App\Http\Controllers\ProfileController::class, 'cmt']);
        Route::post('rep/{uid}/{cmt_id}', [App\Http\Controllers\ProfileController::class, 'rep']);
        Route::get('xoa-cmt/{cmt_id}', [App\Http\Controllers\ProfileController::class, 'xoa_cmt']);
        Route::get('xoa-rep/{cmt_id}/{rep_id}', [App\Http\Controllers\ProfileController::class, 'xoa_rep']);
    });
    Route::get('/check-vip', function () {
        $uid = Auth::user()->id;
        $user = User::find($uid);
        $data_nhanvat = data_nhanvat($uid);
        $profile = Profile::find($uid);
        $new_time = strtotime(Carbon::now('Asia/Ho_Chi_Minh'));
        if($user->vip_time - $new_time < 0){
            $user->level = 10;
            $user->save();
            if(isset($data_nhanvat[0])){
                if($data_nhanvat[0]['gioi_tinh'] == 0){
                    $data_nhanvat[0]['link_img'] = "https://i.imgur.com/Tk4Un40.png";
                }else{
                    $data_nhanvat[0]['link_img'] = "https://i.imgur.com/hSvRTEU.png";
                }
                save_nhanvat($data_nhanvat,$uid);
            }
            if(isset($profile)){
                $profile->bg_img = "https://i.imgur.com/7Aj9IFs.png";
                $profile->link_nhac = null;
                $profile->ten_nhac = null;
                $profile->save();
            }
            echo "over_vip";
        }else{
            echo "vip";
        }
    });
    Route::group(['middleware'=>'checkpwd2'], function(){
        Route::prefix('tu-luyen')->group(function () {
            Route::prefix('nhan-vat')->group(function () {
                Route::post('sua-anh', [App\Http\Controllers\Game\TuLuyenController::class, 'sua_anh']);
                Route::get('rut-do/{id}', [App\Http\Controllers\Game\TuLuyenController::class, 'rut_do']);
                Route::get('nhan-do/{id}', [App\Http\Controllers\Game\TuLuyenController::class, 'nhan_do']);
                Route::get('xoa-tieu-phi', [App\Http\Controllers\Game\TuLuyenController::class, 'del_tp']);
            });
            Route::prefix('cua-hang')->group(function () {
                Route::prefix('nguyen-lieu')->group(function () {
                    Route::post('/{item_id}', [App\Http\Controllers\Game\CuaHangController::class, 'nguyen_lieu']);
                    Route::post('su-dung/{item_id}', [App\Http\Controllers\Game\Item\SuDungItemController::class, 'nguyen_lieu']);
                    Route::post('ban/{item_id}', [App\Http\Controllers\Game\Item\BanItemController::class, 'nguyen_lieu']);
                    Route::post('chuyen/{item_id}', [App\Http\Controllers\Game\Item\ChuyenItemController::class, 'nguyen_lieu']);
                });
                Route::prefix('van-nang')->group(function () {
                    Route::post('/{item_id}', [App\Http\Controllers\Game\CuaHangController::class, 'van_nang']);
                    Route::post('su-dung/{item_id}', [App\Http\Controllers\Game\Item\SuDungItemController::class, 'van_nang']);
                    Route::post('ban/{item_id}', [App\Http\Controllers\Game\Item\BanItemController::class, 'van_nang']);
                    Route::post('chuyen/{item_id}', [App\Http\Controllers\Game\Item\ChuyenItemController::class, 'van_nang']);
                });
                Route::prefix('dot-pha')->group(function () {
                    Route::post('/{item_id}', [App\Http\Controllers\Game\CuaHangController::class, 'dot_pha']);
                    Route::post('ban/{item_id}', [App\Http\Controllers\Game\Item\BanItemController::class, 'dot_pha']);
                    Route::post('chuyen/{item_id}', [App\Http\Controllers\Game\Item\ChuyenItemController::class, 'dot_pha']);
                });
                Route::prefix('cong-phap')->group(function () {
                    Route::post('/{item_id}', [App\Http\Controllers\Game\CuaHangController::class, 'cong_phap']);
                    Route::post('su-dung/{item_id}', [App\Http\Controllers\Game\Item\SuDungItemController::class, 'cong_phap']);
                    Route::post('ban/{item_id}', [App\Http\Controllers\Game\Item\BanItemController::class, 'cong_phap']);
                    Route::post('chuyen/{item_id}', [App\Http\Controllers\Game\Item\ChuyenItemController::class, 'cong_phap']);
                });
            });
            Route::prefix('nghe-nghiep')->group(function () {
                Route::post('exp', [App\Http\Controllers\Game\TuLuyenController::class, 'exp_nghenghiep']);
            });
        });
        Route::prefix('trang-ca-nhan')->group(function () {
            Route::post('doi-ma-cap-2', [App\Http\Controllers\ProfileController::class, 'doi_mac2']);
            Route::post('doi-mat-khau', [App\Http\Controllers\ProfileController::class, 'doi_mk']);
            Route::post('doi-email', [App\Http\Controllers\ProfileController::class, 'doi_email']);
            Route::post('xoa-tai-khoan', [App\Http\Controllers\ProfileController::class, 'del_acc']);
            Route::post('sua-anh', [App\Http\Controllers\ProfileController::class, 'doi_avt']);
            Route::post('doi-ten', [App\Http\Controllers\ProfileController::class, 'doi_ten']);
            Route::post('doi-anh-bia', [App\Http\Controllers\ProfileController::class, 'doi_anh_bia']);
            Route::post('doi-nhac', [App\Http\Controllers\ProfileController::class, 'doi_nhac']);
            Route::post('doi-thong-tin', [App\Http\Controllers\ProfileController::class, 'doi_thong_tin']);
            Route::get('quen-ma-cap-2', [App\Http\Controllers\ProfileController::class, 'quen_c2']);
            Route::get('gui-lai-ma', [App\Http\Controllers\ProfileController::class, 'send_again']);
            Route::post('xac-nhan-ma', [App\Http\Controllers\ProfileController::class, 'xn_quen_c2']);
            Route::get('tu-truyen', [App\Http\Controllers\ProfileController::class, 'tu_truyen']);
        });
        Route::prefix('ky-nang')->group(function () {
            Route::prefix('cong-phap')->group(function () {
                Route::post('them-exp', [App\Http\Controllers\Game\Item\SkillController::class, 'cp_exp']);
                Route::post('tan-cong', [App\Http\Controllers\Game\Item\SkillController::class, 'tan_cong']);
                Route::post('sua', [App\Http\Controllers\Game\Item\SkillController::class, 'sua_cp']);
            });
        });
        Route::post('nap-tien/them', [App\Http\Controllers\HomeController::class, 'nap_tien']);
        Route::post('/doi-tien', [App\Http\Controllers\HomeController::class, 'doi_tien']);
        Route::prefix('truyen')->group(function () {
            Route::post('nhung', [App\Http\Controllers\Truyen\NhungController::class, 'nhung']);
            Route::get('cua-toi', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'cua_toi']);
            Route::get('dang-doc/{id}/{position}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'dang_doc']);
            Route::get('data-dang-doc', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'data_dangdoc']);
            Route::get('del-dang-doc/{key}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'del_dd']);
            Route::get('them-tu/{id}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'them_tu']);
            Route::get('like/{id}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'like']);
            Route::get('dislike/{id}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'dislike']);
        });
    });
});
Route::prefix('creator')->middleware('checkpwd2','verified','auth','creator')->group(function () {
    Route::prefix('chung-toc')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\ChungTocController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\ChungTocController::class, 'them']);
        Route::post('sua/{chungtoc_id}', [App\Http\Controllers\Creator\ChungTocController::class, 'sua']);
        Route::get('xoa/{chungtoc_id}', [App\Http\Controllers\Creator\ChungTocController::class, 'xoa']);
    });
    Route::prefix('the-chat')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\TheChatController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\TheChatController::class, 'them']);
        Route::post('sua/{thechat_id}', [App\Http\Controllers\Creator\TheChatController::class, 'sua']);
        Route::get('xoa/{thechat_id}', [App\Http\Controllers\Creator\TheChatController::class, 'xoa']);
    });
    Route::prefix('nang-luong')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\NangLuongController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\NangLuongController::class, 'them']);
        Route::post('sua/{nangluong_id}', [App\Http\Controllers\Creator\NangLuongController::class, 'sua']);
        Route::get('xoa/{nangluong_id}', [App\Http\Controllers\Creator\NangLuongController::class, 'xoa']);
        Route::prefix('chi-tiet')->group(function () {
            Route::get('/{nangluong_id}', [App\Http\Controllers\Creator\ChiTietNangLuongController::class, 'index']);
            Route::post('/them/{nangluong_id}', [App\Http\Controllers\Creator\ChiTietNangLuongController::class, 'them']);
            Route::post('/sua/{chi_tiet_id}', [App\Http\Controllers\Creator\ChiTietNangLuongController::class, 'sua']);
            Route::get('/xoa/{chi_tiet_id}', [App\Http\Controllers\Creator\ChiTietNangLuongController::class, 'xoa']);
        });
    });
    Route::prefix('he')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\HeController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\HeController::class, 'them']);
        Route::post('sua/{he_id}', [App\Http\Controllers\Creator\HeController::class, 'sua']);
        Route::get('xoa/{he_id}', [App\Http\Controllers\Creator\HeController::class, 'xoa']);
    });
    Route::prefix('nghe-nghiep')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\NgheNghiepController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\NgheNghiepController::class, 'them']);
        Route::post('sua/{nghenghiep_id}', [App\Http\Controllers\Creator\NgheNghiepController::class, 'sua']);
        Route::get('xoa/{nghenghiep_id}', [App\Http\Controllers\Creator\NgheNghiepController::class, 'xoa']);
        Route::prefix('chi-tiet')->group(function () {
            Route::get('/{nghenghiep_id}', [App\Http\Controllers\Creator\ChiTietNgheNghiepController::class, 'index']);
            Route::post('/them/{nghenghiep_id}', [App\Http\Controllers\Creator\ChiTietNgheNghiepController::class, 'them']);
            Route::post('/sua/{chitiet_id}', [App\Http\Controllers\Creator\ChiTietNgheNghiepController::class, 'sua']);
            Route::get('/xoa/{chitiet_id}', [App\Http\Controllers\Creator\ChiTietNgheNghiepController::class, 'xoa']);
        });
    });
    Route::prefix('thien-kiep')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\ThienKiepController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\ThienKiepController::class, 'them']);
        Route::post('sua/{thienkiep_id}', [App\Http\Controllers\Creator\ThienKiepController::class, 'sua']);
        Route::get('xoa/{thienkiep_id}', [App\Http\Controllers\Creator\ThienKiepController::class, 'xoa']);
    });
    Route::prefix('css')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\CssController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\CssController::class, 'them']);
        Route::post('sua/{css_id}', [App\Http\Controllers\Creator\CssController::class, 'sua']);
        Route::get('xoa/{css_id}', [App\Http\Controllers\Creator\CssController::class, 'xoa']);
    });
    Route::prefix('vu-khi')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\VuKhiController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\VuKhiController::class, 'them']);
        Route::post('sua/{vukhi_id}', [App\Http\Controllers\Creator\VuKhiController::class, 'sua']);
        Route::get('xoa/{vukhi_id}', [App\Http\Controllers\Creator\VuKhiController::class, 'xoa']);
    });
    Route::prefix('hinh-anh')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\HinhAnhController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Creator\HinhAnhController::class, 'them']);
        Route::post('sua/{vukhi_id}', [App\Http\Controllers\Creator\HinhAnhController::class, 'sua']);
        Route::get('xoa/{vukhi_id}', [App\Http\Controllers\Creator\HinhAnhController::class, 'xoa']);
    });
    Route::prefix('item')->group(function () {
        Route::prefix('nguyen-lieu')->group(function () {
            Route::get('/', [App\Http\Controllers\Creator\Item\NguyenLieuController::class, 'index']);
            Route::post('/them', [App\Http\Controllers\Creator\Item\NguyenLieuController::class, 'them']);
            Route::post('/sua/{nguyenlieu_id}', [App\Http\Controllers\Creator\Item\NguyenLieuController::class, 'sua']);
            Route::get('/xoa/{nguyenlieu_id}', [App\Http\Controllers\Creator\Item\NguyenLieuController::class, 'xoa']);
        });
        Route::prefix('dot-pha')->group(function () {
            Route::get('/', [App\Http\Controllers\Creator\Item\DotPhaController::class, 'index']);
            Route::post('/them', [App\Http\Controllers\Creator\Item\DotPhaController::class, 'them']);
            Route::post('/sua/{dotpha_id}', [App\Http\Controllers\Creator\Item\DotPhaController::class, 'sua']);
            Route::get('/xoa/{dotpha_id}', [App\Http\Controllers\Creator\Item\DotPhaController::class, 'xoa']);
            Route::post('/them-level-nghe-nghiep/{dotpha_id}', [App\Http\Controllers\Creator\Item\DotPhaController::class, 'level']);
        });
        Route::prefix('van-nang')->group(function () {
            Route::get('/', [App\Http\Controllers\Creator\Item\VanNangController::class, 'index']);
            Route::post('/them', [App\Http\Controllers\Creator\Item\VanNangController::class, 'them']);
            Route::post('/sua/{id}', [App\Http\Controllers\Creator\Item\VanNangController::class, 'sua']);
            Route::get('/xoa/{id}', [App\Http\Controllers\Creator\Item\VanNangController::class, 'xoa']);
        });
        Route::prefix('cong-phap')->group(function () {
            Route::get('/', [App\Http\Controllers\Creator\Item\CongPhapController::class, 'index']);
            Route::post('/them', [App\Http\Controllers\Creator\Item\CongPhapController::class, 'them']);
            Route::post('/sua/{id}', [App\Http\Controllers\Creator\Item\CongPhapController::class, 'sua']);
            Route::get('/xoa/{id}', [App\Http\Controllers\Creator\Item\CongPhapController::class, 'xoa']);
        });
    });
    Route::prefix('nap-tien')->group(function () {
        Route::get('/', [App\Http\Controllers\Creator\Item\NapTienController::class, 'index']);
        Route::get('/tu-choi/{id}', [App\Http\Controllers\Creator\Item\NapTienController::class, 'tu_choi']);
        Route::post('/them-tien/{id}', [App\Http\Controllers\Creator\Item\NapTienController::class, 'them_tien']);
        Route::get('/chap-nhan/{id}', [App\Http\Controllers\Creator\Item\NapTienController::class, 'chap_nhan']);
        Route::post('/rep/{id}', [App\Http\Controllers\Creator\Item\NapTienController::class, 'rep']);
        Route::post('/khuyen-mai/{id}', [App\Http\Controllers\Creator\Item\NapTienController::class, 'khuyen_mai']);
    });
    Route::post('thong-bao-home', [App\Http\Controllers\ThongBaoController::class, 'index']);
    Route::post('thong-bao-tu-luyen', [App\Http\Controllers\ThongBaoController::class, 'tu_luyen']);
});
Route::prefix('mod')->middleware('checkpwd2','verified','auth','mod')->group(function () {
    Route::prefix('the-loai')->group(function () {
        Route::get('/', [App\Http\Controllers\Mod\TheLoaiController::class, 'index']);
        Route::post('them', [App\Http\Controllers\Mod\TheLoaiController::class, 'them']);
        Route::post('sua/{id}', [App\Http\Controllers\Mod\TheLoaiController::class, 'sua']);
    });
    Route::prefix('tag')->group(function () {
        Route::get('/', [App\Http\Controllers\Mod\TagContronller::class, 'index']);
        Route::post('them', [App\Http\Controllers\Mod\TagContronller::class, 'them']);
        Route::post('sua/{id}', [App\Http\Controllers\Mod\TagContronller::class, 'sua']);
    });
    Route::prefix('truyen')->group(function () {
        Route::get('/', [App\Http\Controllers\Mod\TruyenController::class, 'index']);
        Route::get('de-cu/{id}', [App\Http\Controllers\Mod\TruyenController::class, 'de_cu']);
        Route::get('xoa-de-cu/{id}', [App\Http\Controllers\Mod\TruyenController::class, 'del_de_cu']);
        Route::get('tim-kiem', [App\Http\Controllers\Mod\TruyenController::class, 'tim_kiem']);
        Route::get('change-img/{id}', [App\Http\Controllers\Mod\TruyenController::class, 'img']);
    });
});
//không cần đăng nhập
    Route::prefix('/')->group(function () {
        Route::prefix('tu-luyen/huong-dan')->group(function () {
            Route::get('danh-sach-chung-toc', function () {
                $chung_toc = ChungTocModel::orderBy('ty_le','desc')->where('ty_le','>',0.00025)->get();
                $nang_luong = NangLuongModel::get();
                $the_chat = TheChatModel::get();
                $path =  PathAll::first();
                $data_chungtoc = data_chungtoc();
                $path_chungtoc = $path->path_chungtoc;
                return view('chung_toc', compact('chung_toc', 'nang_luong', 'the_chat', 'data_chungtoc', 'path_chungtoc'));
            });
            Route::get('danh-sach-the-chat', function () {
                $the_chat = TheChatModel::orderBy('ty_le','desc')->get();
                $he = HeModel::get();
                return view('the_chat')->with(compact('the_chat','he'));
            });
        });



        Route::prefix('truyen')->group(function () {
            Route::get('{host}/{id}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'index']);
            Route::get('{host}/{id}/fetch_data', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'fetch_data']);
            Route::get('{host}/{id}/{position}', [App\Http\Controllers\Truyen\TruyenAuthController::class, 'chapter'])->middleware('auth');
            Route::get('cap-nhat', [App\Http\Controllers\HomeController::class, 'update']);
            Route::get('tim-kiem', [App\Http\Controllers\HomeController::class, 'tim_kiem']);
        });
        Route::get('dsc/{id}', [App\Http\Controllers\Truyen\NhungController::class, 'dsc']);
        Route::get('trans/{host}/{id}', [App\Http\Controllers\Truyen\NhungController::class, 'trans']);

        Route::prefix('trang-ca-nhan')->group(function () {
            Route::get('/{id}', [App\Http\Controllers\ProfileController::class, 'index']);
        });
        Route::get('/check-truyen', function () {
            try{
                $truyen = Truyen::get();
                foreach($truyen as $key => $value){
                    if(isset($value->link)){
                        $data_theloai = data_theloai($value->id);
                        try{
                            $count = count($data_theloai);
                        }catch (Throwable $e){
                            $count = 0;
                        }
                        if($count == 0){
                            $truyen1 = Truyen::find($value->id);
                            $url = get_url($truyen1->nguon,$truyen1->link);
                            $client = new Client();
                            $crawler = $client->request('GET', $url);
                            get_the_loai($truyen1->nguon,$crawler,$value->id);
                        }
                        $data_tag = data_tag($value->id);
                        try{
                            $count = count($data_tag);
                        }catch (Throwable $e){
                            $count = 0;
                        }
                        if($count == 0){
                            $data_tag[1]['ten'] = "khác";
                            save_tag($data_tag,$value->id);
                        }
                    }
                }
            }catch (Throwable $e){
                echo "Lỗi thể loại<br>";
            }
            try{
                check_nhung();
                check_truyen_sub();
            }catch (Throwable $e){
                echo "Die<br>";
            }
        });
        Route::get('/check-user', function () {
            try{
                check_file();
                echo "File OK   <br>";
            }catch (Throwable $e){
                echo "File Err<br>";
            }
            if(Auth::check()){
                try{
                    check_log();
                    echo "LOG OK   <br>";
                }catch(Throwable $e){
                    echo "Log Err<br>";
                }
            }
            try{
                check_chuyendo();
                echo "chuyển OK   <br>";
            }catch(Throwable $e){
                echo "chuyển Err<br>";
            }
        });
        Route::get('bang-xep-hang-tu-luyen', function () {
            $user = User::orderBy('level_tuluyen','desc')->where('level_tuluyen','>',0)->orderBy('phan_tram','desc')->take(10)->get();
            return view('tu_luyen.bxh')->with(compact('user'));
        });
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
//không cần đăng nhập
Auth::routes(['verify' => true]);

Route::get('/online', function () {
    $online = Session::whereNotNull('user_id')->groupBy('user_id')->pluck('user_id');
    $khach = Session::whereNull('user_id')->get();
    if(empty($khach)){
        $khach_number = 0;
    }else{
        $khach_number = count($khach);
    }
    if(empty($online)){
        $online_number = 0;
    }
    else{
        $online_number = count($online);
    }
    $offline = count(User::get()) - $online_number;
    if($offline < 0){
        $offline = 0;
    }
    echo '<button class="btn btn-default" style="opacity:1;">'.$online_number.' <i class="fas fa-user-check"></i> - '.$khach_number.' <i class="fas fa-user-secret"></i> - '.$offline.' <i class="fas fa-user-times"></i></button><br>';
});

//xác nhận email
    Route::get('/email/verify', function () {
        return view('auth.verify');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/home');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Đã gửi link xác nhận!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//end xác nhận email

