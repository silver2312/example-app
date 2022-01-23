<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\ThienKiepModel;

class ThienKiepController extends Controller
{
    public function index()
    {
        $thien_kiep = ThienKiepModel::get();
        return view('creator.thien_kiep')->with(compact('thien_kiep'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:thien_kiep|max:255',
            'thanh_cong' => 'required',
            'tieu_thuong' => 'required',
            'trong_thuong' => 'required',
            'chet' => 'required',
        ]);
        $thien_kiep = new ThienKiepModel();
        $thien_kiep->ten = $data['ten'];
        $thien_kiep->thanh_cong = $data['thanh_cong'];
        $thien_kiep->tieu_thuong = $data['tieu_thuong'];
        $thien_kiep->trong_thuong = $data['trong_thuong'];
        $thien_kiep->chet = $data['chet'];
        $thien_kiep->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $thienkiep_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'thanh_cong' => 'required',
            'tieu_thuong' => 'required',
            'trong_thuong' => 'required',
            'chet' => 'required',
        ]);
        $thien_kiep = ThienKiepModel::find($thienkiep_id);
        $thien_kiep->ten = $data['ten'];
        $thien_kiep->thanh_cong = $data['thanh_cong'];
        $thien_kiep->tieu_thuong = $data['tieu_thuong'];
        $thien_kiep->trong_thuong = $data['trong_thuong'];
        $thien_kiep->chet = $data['chet'];
        $thien_kiep->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($thienkiep_id){
        $thien_kiep = ThienKiepModel::find($thienkiep_id);
        $thien_kiep->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
