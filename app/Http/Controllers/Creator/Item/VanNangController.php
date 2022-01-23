<?php

namespace App\Http\Controllers\Creator\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\Item\VanNangModel;

class VanNangController extends Controller
{
    public function index()
    {
        $item_vannang = VanNangModel::paginate(10);
        return view('creator.item.van_nang')->with(compact('item_vannang'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:item_vannang|max:255',
            'gioi_thieu' => 'required',
            'dong_te' => 'required|numeric|min:0',
            'ngan_te' => 'required|numeric|min:0',
            'kim_te' => 'required|numeric|min:0',
            'status' => 'required'
        ]);
        $item_vannang = new VanNangModel();
        $item_vannang->ten = $data['ten'];
        $item_vannang->gioi_thieu = $data['gioi_thieu'];
        $item_vannang->dong_te = $data['dong_te'];
        $item_vannang->ngan_te = $data['ngan_te'];
        $item_vannang->kim_te = $data['kim_te'];
        $item_vannang->status = $data['status'];
        $item_vannang->save();
        return redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $id)
    {
        $data = $request->validate([
            'ten' => 'required|max:255',
            'gioi_thieu' => 'required',
            'dong_te' => 'required|numeric|min:0',
            'ngan_te' => 'required|numeric|min:0',
            'kim_te' => 'required|numeric|min:0',
            'status' => 'required'
        ]);
        $item_vannang = VanNangModel::find($id);
        $item_vannang->ten = $data['ten'];
        $item_vannang->gioi_thieu = $data['gioi_thieu'];
        $item_vannang->dong_te = $data['dong_te'];
        $item_vannang->ngan_te = $data['ngan_te'];
        $item_vannang->kim_te = $data['kim_te'];
        $item_vannang->status = $data['status'];
        $item_vannang->save();
        return redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($id){
        $item_vannang = VanNangModel::find($id);
        $item_vannang->delete();
        return redirect()->back()->with('status','Đã xoá');
    }
}
