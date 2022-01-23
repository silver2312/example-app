<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\NangLuongModel;

class NangLuongController extends Controller
{
    public function index()
    {
        $nang_luong = NangLuongModel::paginate(10);
        return view('creator.nang_luong')->with(compact('nang_luong'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:nang_luong|max:255',
            'gioi_thieu' => 'required|unique:nang_luong'
        ]);
        $nang_luong = new NangLuongModel();
        $nang_luong->ten = $data['ten'];
        $nang_luong->gioi_thieu = $data['gioi_thieu'];
        $nang_luong->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $nangluong_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'gioi_thieu' => 'required'
        ]);
        $nang_luong = NangLuongModel::find($nangluong_id);
        $nang_luong->ten = $data['ten'];
        $nang_luong->gioi_thieu = $data['gioi_thieu'];
        $nang_luong->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($nangluong_id)
    {
        $nang_luong = NangLuongModel::find($nangluong_id);
        $nang_luong->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
