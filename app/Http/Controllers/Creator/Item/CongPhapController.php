<?php

namespace App\Http\Controllers\Creator\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\Item\CongPhapModel;
use App\Models\Game\HeModel;
use App\Models\Game\NangLuongModel;

class CongPhapController extends Controller
{
    public function index()
    {
        $cong_phap = CongPhapModel::paginate(10);
        $nang_luong = NangLuongModel::get();
        $he = HeModel::get();
        return view('creator.item.cong_phap')->with(compact('cong_phap','nang_luong','he'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:cong_phap|max:255',
            'buff_exp' => 'required|numeric|min:0',
            'dong_te' => 'required|numeric|min:0',
            'ngan_te' => 'required|numeric|min:0',
            'kim_te' => 'required|numeric|min:0',
            'me' => 'required|numeric|min:0',
            'status' => 'required|numeric|min:0',
            'buff' => 'required|numeric|min:0',
            'he_id' => 'required',
            'nangluong_id' => 'required',
            'level' => 'required|numeric|min:0',
            'level_max' => 'required|numeric|min:0',
            'gioi_thieu' => 'required',
            'ty_le' => 'required|numeric|min:0',
        ]);
        $cong_phap = new CongPhapModel();
        $cong_phap->ten = $data['ten'];
        $cong_phap->buff_exp = $data['buff_exp'];
        $cong_phap->dong_te = $data['dong_te'];
        $cong_phap->ngan_te = $data['ngan_te'];
        $cong_phap->kim_te = $data['kim_te'];
        $cong_phap->me = $data['me'];
        $cong_phap->status = $data['status'];
        $cong_phap->buff = $data['buff'];
        $cong_phap->he_id = $data['he_id'];
        $cong_phap->nangluong_id = $data['nangluong_id'];
        $cong_phap->level = $data['level'];
        $cong_phap->level_max = $data['level_max'];
        $cong_phap->gioi_thieu = $data['gioi_thieu'];
        $cong_phap->ty_le = $data['ty_le'];
        $cong_phap->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'buff_exp' => 'required|numeric|min:0',
            'dong_te' => 'required|numeric|min:0',
            'ngan_te' => 'required|numeric|min:0',
            'kim_te' => 'required|numeric|min:0',
            'me' => 'required|numeric|min:0',
            'status' => 'required|numeric|min:0',
            'buff' => 'required|numeric|min:0',
            'he_id' => 'required',
            'nangluong_id' => 'required',
            'level' => 'required|numeric|min:0',
            'level_max' => 'required|numeric|min:0',
            'gioi_thieu' => 'required',
            'ty_le' => 'required|numeric|min:0',
        ]);
        $cong_phap = CongPhapModel::find($id);
        $cong_phap->ten = $data['ten'];
        $cong_phap->buff_exp = $data['buff_exp'];
        $cong_phap->dong_te = $data['dong_te'];
        $cong_phap->ngan_te = $data['ngan_te'];
        $cong_phap->kim_te = $data['kim_te'];
        $cong_phap->me = $data['me'];
        $cong_phap->status = $data['status'];
        $cong_phap->buff = $data['buff'];
        $cong_phap->he_id = $data['he_id'];
        $cong_phap->nangluong_id = $data['nangluong_id'];
        $cong_phap->level = $data['level'];
        $cong_phap->level_max = $data['level_max'];
        $cong_phap->gioi_thieu = $data['gioi_thieu'];
        $cong_phap->ty_le = $data['ty_le'];
        $cong_phap->save();
        return redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($id){
        $cong_phap = CongPhapModel::find($id);
        $cong_phap->delete();
        return redirect()->back()->with('status','Đã xoá');
    }
}
