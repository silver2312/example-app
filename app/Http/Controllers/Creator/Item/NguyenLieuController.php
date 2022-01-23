<?php

namespace App\Http\Controllers\Creator\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\Item\NguyenLieuModel;

class NguyenLieuController extends Controller
{
    public function index()
    {
        $nguyen_lieu = NguyenLieuModel::paginate(10);
        return view('creator.item.nguyen_lieu')->with(compact('nguyen_lieu'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:item_nguyenlieu|max:255',
            'level' => 'required',
            'status' => 'required',
            'dong_te' => 'required',
            'ngan_te' => 'required',
            'kim_te' => 'required',
            'gioi_thieu' => 'required',
        ]);
        $nguyen_lieu = new NguyenLieuModel();
        $nguyen_lieu->ten = $data['ten'];
        $nguyen_lieu->level = $data['level'];
        $nguyen_lieu->status = $data['status'];
        $nguyen_lieu->dong_te = $data['dong_te'];
        $nguyen_lieu->ngan_te = $data['ngan_te'];
        $nguyen_lieu->kim_te = $data['kim_te'];
        $nguyen_lieu->gioi_thieu = $data['gioi_thieu'];
        $nguyen_lieu->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $nguyenlieu_id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'level' => 'required',
            'status' => 'required',
            'dong_te' => 'required',
            'ngan_te' => 'required',
            'kim_te' => 'required',
            'gioi_thieu' => 'required',
        ]);
        $nguyen_lieu = NguyenLieuModel::find($nguyenlieu_id);
        $nguyen_lieu->ten = $data['ten'];
        $nguyen_lieu->level = $data['level'];
        $nguyen_lieu->status = $data['status'];
        $nguyen_lieu->dong_te = $data['dong_te'];
        $nguyen_lieu->ngan_te = $data['ngan_te'];
        $nguyen_lieu->kim_te = $data['kim_te'];
        $nguyen_lieu->gioi_thieu = $data['gioi_thieu'];
        $nguyen_lieu->save();
        return redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($nguyenlieu_id){
        $nguyen_lieu = NguyenLieuModel::find($nguyenlieu_id);
        $nguyen_lieu->delete();
        return redirect()->back()->with('status','Đã xoá');
    }
}
