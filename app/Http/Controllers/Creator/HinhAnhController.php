<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\HinhAnhModel;

class HinhAnhController extends Controller
{
    public function index()
    {
        $hinh_anh = HinhAnhModel::get();
        return view('creator.hinh_anh')->with(compact('hinh_anh'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'gioi_tinh' => 'required',
            'link_img' => 'required'
        ]);
        $hinh_anh = new HinhAnhModel();
        $hinh_anh->gioi_tinh = $data['gioi_tinh'];
        $hinh_anh->link_img = $data['link_img'];
        $hinh_anh->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $hinhanh_id)
    {
        $data = $request->validate([
            'gioi_tinh' => 'required',
            'link_img' => 'required'
        ]);
        $hinh_anh = HinhAnhModel::find($hinhanh_id);
        $hinh_anh->gioi_tinh = $data['gioi_tinh'];
        $hinh_anh->link_img = $data['link_img'];
        $hinh_anh->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($hinhanh_id)
    {
        $hinh_anh = HinhAnhModel::find($hinhanh_id);
        $hinh_anh->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
