<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\ThienKiepModel;
use App\Models\Game\CssModel;

class ChiTietNangLuongController extends Controller
{
    public function index($nangluong_id){
        $nang_luong = NangLuongModel::find($nangluong_id);
        $chitiet_nangluong = ChiTietNangLuongModel::orderBy('level','asc')->where('nangluong_id' , $nang_luong->id)->paginate(10);
        try{
            $lv = [];
            foreach($chitiet_nangluong as $key => $value){
                $lv[] = $value->level;
            }
            $next_lv = max($lv) + 1;
        }catch(Throwable $e){
            $next_lv = 0;
        }
        $thien_kiep = ThienKiepModel::get();
        $css = CssModel::get();
        $dot_pha = DotPhaModel::get();
        return view('creator.chi_tiet_nang_luong')->with(compact('nang_luong','chitiet_nangluong','next_lv','thien_kiep','css','dot_pha'));
    }
    public function them(Request $request, $nangluong_id){
        $data = $request->validate([
            'ten' => 'required|max:255',
            'level' => 'required',
            'exp' => 'required',
            'tho_nguyen' => 'required',
            'css' => 'required',
            'do_kiep' => 'required',
            'buff_luc' => 'required',
            'buff_tri' => 'required',
            'buff_ben' => 'required',
            'buff_man' => 'required',
            'hut_exp' => 'required',
            'phu_tro' => 'required',
            'so_luong' => 'required',
        ]);
        $chi_tiet = new ChiTietNangLuongModel();
        $chi_tiet->nangluong_id = $nangluong_id;
        $chi_tiet->ten = $data['ten'];
        $chi_tiet->level = $data['level'];
        $chi_tiet->exp = $data['exp'];
        $chi_tiet->tho_nguyen = $data['tho_nguyen'];
        $chi_tiet->css = $data['css'];
        $chi_tiet->do_kiep = $data['do_kiep'];
        $chi_tiet->buff_luc = $data['buff_luc'];
        $chi_tiet->buff_tri = $data['buff_tri'];
        $chi_tiet->buff_ben = $data['buff_ben'];
        $chi_tiet->buff_man = $data['buff_man'];
        $chi_tiet->hut_exp = $data['hut_exp'];
        $chi_tiet->phu_tro = $data['phu_tro'];
        $chi_tiet->so_luong = $data['so_luong'];
        $chi_tiet->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $chi_tiet_id){
        $data = $request->validate([
            'ten' => 'required|max:255',
            'level' => 'required',
            'exp' => 'required',
            'tho_nguyen' => 'required',
            'css' => 'required',
            'do_kiep' => 'required',
            'buff_luc' => 'required',
            'buff_tri' => 'required',
            'buff_ben' => 'required',
            'buff_man' => 'required',
            'hut_exp' => 'required',
            'phu_tro' => 'required',
            'so_luong' => 'required',
        ]);
        $chi_tiet = ChiTietNangLuongModel::find($chi_tiet_id);
        $chi_tiet->nangluong_id = $chi_tiet->nangluong_id;
        $chi_tiet->ten = $data['ten'];
        $chi_tiet->level = $data['level'];
        $chi_tiet->exp = $data['exp'];
        $chi_tiet->tho_nguyen = $data['tho_nguyen'];
        $chi_tiet->css = $data['css'];
        $chi_tiet->do_kiep = $data['do_kiep'];
        $chi_tiet->buff_luc = $data['buff_luc'];
        $chi_tiet->buff_tri = $data['buff_tri'];
        $chi_tiet->buff_ben = $data['buff_ben'];
        $chi_tiet->buff_man = $data['buff_man'];
        $chi_tiet->hut_exp = $data['hut_exp'];
        $chi_tiet->phu_tro = $data['phu_tro'];
        $chi_tiet->so_luong = $data['so_luong'];
        $chi_tiet->save();
        return Redirect()->back()->with('status','Đã Sửa');
    }
    public function xoa($chi_tiet_id){
        $chi_tiet = ChiTietNangLuongModel::find($chi_tiet_id);
        $chi_tiet->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
