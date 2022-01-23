<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\VuKhiModel;

class VuKhiController extends Controller
{
    public function index()
    {
        $vu_khi = VuKhiModel::get();
        return view('creator.vu_khi')->with(compact('vu_khi'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:vu_khi|max:255',
        ]);
        $vu_khi = new VuKhiModel();
        $vu_khi->ten = $data['ten'];
        $vu_khi->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $vukhi_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
        ]);
        $vu_khi = VuKhiModel::find($vukhi_id);
        $vu_khi->ten = $data['ten'];
        $vu_khi->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($vukhi_id)
    {
        $vu_khi = VuKhiModel::find($vukhi_id);
        $vu_khi->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
