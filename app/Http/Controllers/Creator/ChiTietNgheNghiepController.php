<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Models\Game\NgheNghiepModel;
use App\Models\Game\CssModel;
use App\Models\Game\ChiTiet\ChiTietNgheNghiepModel;

class ChiTietNgheNghiepController extends Controller
{
    public function index($nghenghiep_id)
    {
        $chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$nghenghiep_id)->get();
        $nghe_nghiep = NgheNghiepModel::find($nghenghiep_id);
        $css = CSSModel::get();
        try{
            $lv = [];
            foreach($chitiet_nghenghiep as $key => $value){
                $lv[] = $value->level;
            }
            $next_lv = max($lv) + 1;
        }catch(Throwable $e){
            $next_lv = 1;
        }
        return view('creator.chitiet_nghenghiep')->with(compact('chitiet_nghenghiep','nghe_nghiep','css','next_lv'));
    }
    public function them(Request $request, $nghenghiep_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'css' => 'required',
            'level' => 'required',
            'exp' => 'required',
        ]);
        $chitiet_nghenghiep = new ChiTietNgheNghiepModel();
        $chitiet_nghenghiep->ten = $data['ten'];
        $chitiet_nghenghiep->level = $data['level'];
        $chitiet_nghenghiep->nghenghiep_id = $nghenghiep_id;
        $chitiet_nghenghiep->css = $data['css'];
        $chitiet_nghenghiep->exp = $data['exp'];
        $chitiet_nghenghiep->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $chitiet_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'css' => 'required',
            'level' => 'required',
            'exp' => 'required',
        ]);
        $chitiet_nghenghiep = ChiTietNgheNghiepModel::find($chitiet_id);
        $chitiet_nghenghiep->ten = $data['ten'];
        $chitiet_nghenghiep->level = $data['level'];
        $chitiet_nghenghiep->nghenghiep_id = $chitiet_nghenghiep->nghenghiep_id;
        $chitiet_nghenghiep->css = $data['css'];
        $chitiet_nghenghiep->exp = $data['exp'];
        $chitiet_nghenghiep->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function xoa($chitiet_id){
        $chitiet_nghenghiep = ChiTietNgheNghiepModel::find($chitiet_id);
        $chitiet_nghenghiep->delete();
        return redirect()->back()->with('status','Đã xoá');
    }
}
