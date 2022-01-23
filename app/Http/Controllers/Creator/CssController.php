<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\CssModel;

class CssController extends Controller
{
    public function index()
    {
        $css = CSSModel::get();
        return view('creator.css')->with(compact('css'));
    }
    public function them(Request $request)
    {
        $data = $request->validate([
            'ten' => 'required|unique:css|max:255',
            'slug' => 'required|unique:css|max:255',
        ]);
        $css = new CSSModel();
        $css->ten = $data['ten'];
        $css->slug = $data['slug'];
        $css->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request, $css_id){
        $data = $request->validate([
            'ten' => 'required|max:255',
            'slug' => 'required|max:255',
        ]);
        $css = CSSModel::find($css_id);
        $css->ten = $data['ten'];
        $css->slug = $data['slug'];
        $css->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($css_id){
        $css = CSSModel::find($css_id);
        $css->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
