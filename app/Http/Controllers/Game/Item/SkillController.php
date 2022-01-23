<?php

namespace App\Http\Controllers\Game\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Game\UserPath;
use App\Models\Game\Item\CongPhapModel;

class SkillController extends Controller
{
    public function cp_exp(Request $request){
        $data = $request->validate([
            'ma_c2' => 'required|max:10',
            'exp' => 'required|numeric|min:1'
        ],[
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự',
            'exp.required' => 'Bạn chưa nhập số EXP',
            'exp.numeric' => 'Số EXP phải là số',
            'exp.min' => 'Số EXP phải lớn hơn 0'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $data_congphap = data_congphap($uid);
        $data_thongtin = data_thongtin($uid);
        $cong_phap = CongPhapModel::find($data_congphap[0]['cp_id']);
        if(empty($data_congphap[0])){
            return redirect()->back()->with('error', 'Bạn chưa học công pháp nào.');
        }
        if($data_congphap[0]['level'] >= $data_congphap[0]['level_max']){
            return redirect()->back()->with('error', 'Đã max cấp không thể tu tiếp.');
        }
        if($data['exp'] > $data_thongtin[0]['exp_dubi_hientai']){
            return redirect()->back()->with('error', 'Nhập quá exp đa dụng.');
        }
        $data_congphap[0]['exp_hentai'] += $data['exp'];
        if($data_congphap[0]['exp_hentai'] >= $data_congphap[0]['exp_next']){
            if($data_congphap[0]['buff'] == 0){
                $data_congphap[0]['exp_next'] = $data_congphap[0]['exp_next'] * 10;
                $data_congphap[0]['buff_exp'] = $data_congphap[0]['buff_exp'] + $cong_phap->buff_exp;
            }else{
                $data_congphap[0]['exp_next'] = $data_congphap[0]['exp_next'] * $data_congphap[0]['exp_next'];
                $data_congphap[0]['buff_exp'] = $data_congphap[0]['buff_exp'] * $cong_phap->buff_exp;
            }
            $data_congphap[0]['exp_hentai'] = 0;
            $data_congphap[0]['level'] += 1;
        }
        save_congphap($data_congphap,$uid);
        $data_thongtin[0]['exp_dubi_hientai'] -= $data['exp'];
        save_thongtin($data_thongtin,$uid);
        return redirect()->back()->with('status', 'Bạn đã thêm EXP thành công.');
    }
    public function tan_cong(Request $request){
        $data = $request->validate([
            'ma_c2' => 'required|max:10'
        ],[
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $data_congphap = data_congphap($uid);
        if(empty($data_congphap[0])){
            return redirect()->back()->with('error', 'Bạn chưa học công pháp nào.');
        }
        remove_cp($uid);
        return redirect()->back()->with('status', 'Bạn đã tán công.');
    }
    public function sua_cp(Request $request){
        $data = $request->validate([
            'ma_c2' => 'required|max:10',
            'ten' => 'required|max:55',
            'gioi_thieu' => 'required|max:255'
        ],[
            'ma_c2.required' => 'Bạn chưa nhập mã c2',
            'ma_c2.max' => 'Mã c2 không được vượt quá 10 ký tự',
            'ten.required' => 'Bạn chưa nhập tên',
            'ten.max' => 'Tên không được vượt quá 55 ký tự',
            'gioi_thieu.required' => 'Bạn chưa nhập giới thiệu',
            'gioi_thieu.max' => 'Giới thiệu không được vượt quá 255 ký tự'
        ]);
        $uid = Auth::user()->id;
        $user = User::find($uid);
        if(Hash::check($data['ma_c2'],$user->ma_c2) == false){
            return redirect()->back()->with('error','Mã cấp 2 không đúng.');
        }
        $data_congphap = data_congphap($uid);
        if(empty($data_congphap[0])){
            return redirect()->back()->with('error', 'Bạn chưa học công pháp nào.');
        }
        $data_congphap[0]['ten'] = $data['ten'];
        $data_congphap[0]['gioi_thieu'] = $data['gioi_thieu'];
        save_congphap($data_congphap,$uid);
        return redirect()->back()->with('status', 'Bạn đã sửa thông tin công pháp.');
    }
}
