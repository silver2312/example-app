<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen\TheLoaiModel;

class TheLoaiController extends Controller
{
    public function index(){
        $the_loai = TheLoaiModel::paginate(21);
        return view('mod.the_loai', compact('the_loai'));
    }
    public function them(Request $request){
        $data = $request->validate([
            'ten' => 'required|unique:the_loai,ten|max:30',
            'gioi_thieu' => 'required|max:255',
        ],
        [
            'ten.required' => 'Bạn chưa nhập tên thể loại',
            'ten.unique' => 'Tên thể loại đã tồn tại',
            'ten.max' => 'Tên thể loại không được vượt quá 30 ký tự',
            'gioi_thieu.required' => 'Bạn chưa nhập giới thiệu',
            'gioi_thieu.max' => 'Giới thiệu không được vượt quá 255 ký tự',
        ]);
        $the_loai = new TheLoaiModel();
        $the_loai->ten = $data['ten'];
        $the_loai->gioi_thieu = $data['gioi_thieu'];
        $the_loai->save();
        return redirect()->back()->with('status', 'Thêm thể loại thành công');
    }
    public function sua(Request $request, $id){
        $data = $request->validate([
            'ten' => 'required|max:30',
            'gioi_thieu' => 'required|max:255',
        ],
        [
            'ten.required' => 'Bạn chưa nhập tên thể loại',
            'ten.unique' => 'Tên thể loại đã tồn tại',
            'ten.max' => 'Tên thể loại không được vượt quá 30 ký tự',
            'gioi_thieu.required' => 'Bạn chưa nhập giới thiệu',
            'gioi_thieu.max' => 'Giới thiệu không được vượt quá 255 ký tự',
        ]);
        $the_loai = TheLoaiModel::find($id);
        $the_loai->ten = $data['ten'];
        $the_loai->gioi_thieu = $data['gioi_thieu'];
        $the_loai->save();
        return redirect()->back()->with('status', 'Sửa thể loại thành công');
    }
}
