<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen\TagModel;

class TagContronller extends Controller
{
    public function index(){
        $tag = TagModel::paginate(21);
        return view('mod.tag', compact('tag'));
    }
    public function them(Request $request){
        $data = $request->validate([
            'ten' => 'required|unique:tag,ten|max:30',
            'gioi_thieu' => 'required|max:255',
        ],
        [
            'ten.required' => 'Bạn chưa nhập tag',
            'ten.unique' => 'Tag đã tồn tại',
            'ten.max' => 'Tag không được vượt quá 30 ký tự',
            'gioi_thieu.required' => 'Bạn chưa nhập giới thiệu',
            'gioi_thieu.max' => 'Giới thiệu không được vượt quá 255 ký tự',
        ]);
        $tag = new TagModel();
        $tag->ten = $data['ten'];
        $tag->gioi_thieu = $data['gioi_thieu'];
        $tag->save();
        return redirect()->back()->with('status', 'Thêm thể loại thành công');
    }
    public function sua(Request $request, $id){
        $data = $request->validate([
            'ten' => 'required|max:30',
            'gioi_thieu' => 'required|max:255',
        ],
        [
            'ten.required' => 'Bạn chưa nhập tag',
            'ten.unique' => 'Tag đã tồn tại',
            'ten.max' => 'Tag không được vượt quá 30 ký tự',
            'gioi_thieu.required' => 'Bạn chưa nhập giới thiệu',
            'gioi_thieu.max' => 'Giới thiệu không được vượt quá 255 ký tự',
        ]);
        $tag = TagModel::find($id);
        $tag->ten = $data['ten'];
        $tag->gioi_thieu = $data['gioi_thieu'];
        $tag->save();
        return redirect()->back()->with('status', 'Sửa thể loại thành công');
    }
}
