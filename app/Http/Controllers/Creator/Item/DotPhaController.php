<?php

namespace App\Http\Controllers\Creator\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\NgheNghiepModel;
use App\Models\Game\Item\DotPhaModel;

class DotPhaController extends Controller
{
    public function index()
    {
        $dot_pha = DotPhaModel::paginate(10);
        $nguyen_lieu = NguyenLieuModel::get();
        $nghe_nghiep = NgheNghiepModel::get();
        return view('creator.item.dot_pha')->with(compact('dot_pha','nguyen_lieu','nghe_nghiep'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:item_dotpha|max:255',
            'nguyenlieu_id' => 'required',
            'nghenghiep_id' => 'required',
            'level' => 'required',
            'status' => 'required',
            'dong_te' => 'required',
            'ngan_te' => 'required',
            'kim_te' => 'required',
            'gioi_thieu' => 'required',
            'so_luong' => 'required',
        ]);
        $dot_pha = new DotPhaModel();
        $dot_pha->ten = $data['ten'];
        $dot_pha->nguyenlieu_id = $data['nguyenlieu_id'];
        $dot_pha->nghenghiep_id = $data['nghenghiep_id'];
        $dot_pha->level_nghenghiep = 1;
        $dot_pha->level = $data['level'];
        $dot_pha->status = $data['status'];
        $dot_pha->dong_te = $data['dong_te'];
        $dot_pha->ngan_te = $data['ngan_te'];
        $dot_pha->kim_te = $data['kim_te'];
        $dot_pha->gioi_thieu = $data['gioi_thieu'];
        $dot_pha->so_luong = $data['so_luong'];
        $dot_pha->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $dotpha_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'nguyenlieu_id' => 'required',
            'nghenghiep_id' => 'required',
            'level' => 'required',
            'status' => 'required',
            'dong_te' => 'required',
            'ngan_te' => 'required',
            'kim_te' => 'required',
            'gioi_thieu' => 'required',
            'so_luong' => 'required',
        ]);
        $dot_pha = DotPhaModel::find($dotpha_id);
        $dot_pha->ten = $data['ten'];
        $dot_pha->nguyenlieu_id = $data['nguyenlieu_id'];
        $dot_pha->nghenghiep_id = $data['nghenghiep_id'];
        $dot_pha->level_nghenghiep = $dot_pha->level_nghenghiep;
        $dot_pha->level = $data['level'];
        $dot_pha->status = $data['status'];
        $dot_pha->dong_te = $data['dong_te'];
        $dot_pha->ngan_te = $data['ngan_te'];
        $dot_pha->kim_te = $data['kim_te'];
        $dot_pha->gioi_thieu = $data['gioi_thieu'];
        $dot_pha->so_luong = $data['so_luong'];
        $dot_pha->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function xoa($dotpha_id){
        $dot_pha = DotPhaModel::find($dotpha_id);
        $dot_pha->delete();
        return redirect()->back()->with('status','Đã xoá');
    }
    public function level(Request $request,$dotpha_id){
        $data = $request->all();
        $dot_pha = DotPhaModel::find($dotpha_id);
        if($dot_pha->nghenghiep_id !=5){
            $dot_pha->level_nghenghiep = $data['level_nghenghiep'];
            $dot_pha->save();
            return redirect()->back()->with('status','Đã thêm lv');
        }else{
            return Redirect()->back()->with('error','Không có nghề nghiệp đâu');
        }
    }
}
