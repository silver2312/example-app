<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\NangLuongModel;
use App\Models\Game\NgheNghiepModel;

class NgheNghiepController extends Controller
{
    public function index()
    {
        $nghe_nghiep = NgheNghiepModel::get();
        $nang_luong = NangLuongModel::get();
        return view('creator.nghe_nghiep')->with(compact('nghe_nghiep','nang_luong'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:nghe_nghiep|max:255',
            'nangluong_id' => 'required',
        ]);
        $nghe_nghiep = new NgheNghiepModel();
        $nghe_nghiep->ten = $data['ten'];
        $nghe_nghiep->nangluong_id = $data['nangluong_id'];
        $nghe_nghiep->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $nghenghiep_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'nangluong_id' => 'required',
        ]);
        $nghe_nghiep = NgheNghiepModel::find($nghenghiep_id);
        $nghe_nghiep->ten = $data['ten'];
        $nghe_nghiep->nangluong_id = $data['nangluong_id'];
        $nghe_nghiep->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($nghenghiep_id){
        $nghe_nghiep = NgheNghiepModel::find($nghenghiep_id);
        $nghe_nghiep->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
