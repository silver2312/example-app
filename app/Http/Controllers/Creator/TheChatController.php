<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game\TheChatModel;
use App\Models\Game\HeModel;

class TheChatController extends Controller
{
    public function index(){
        $the_chat = TheChatModel::orderBy('id','asc')->paginate(10);
        $he = HeModel::get();
        return view('creator.the_chat')->with(compact('the_chat','he'));
    }
    public function them(Request $request){
        $data = $request->validate([
            'ten_the_chat' => 'required|unique:the_chat|max:255',
            'ty_le' => 'required',
            'he_id' => 'required',
            'buff_exp' => 'required',
            'buff_luc' => 'required',
            'buff_ben' => 'required',
            'buff_tri' => 'required',
            'buff_man' => 'required',
        ]);
        $the_chat = new TheChatModel();
        $the_chat->ten_the_chat = $data['ten_the_chat'];
        $the_chat->ty_le = $data['ty_le'];
        $the_chat->he_id = $data['he_id'];
        $the_chat->buff_exp = $data['buff_exp'];
        $the_chat->buff_luc = $data['buff_luc'];
        $the_chat->buff_ben = $data['buff_ben'];
        $the_chat->buff_tri = $data['buff_tri'];
        $the_chat->buff_man = $data['buff_man'];
        $the_chat->save();
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request,$thechat_id){
        $data = $request->validate([
            'ten_the_chat' => 'required|max:255',
            'ty_le' => 'required',
            'he_id' => 'required',
            'buff_exp' => 'required',
            'buff_luc' => 'required',
            'buff_ben' => 'required',
            'buff_tri' => 'required',
            'buff_man' => 'required',
        ]);
        $the_chat = TheChatModel::find($thechat_id);
        $the_chat->ten_the_chat = $data['ten_the_chat'];
        $the_chat->ty_le = $data['ty_le'];
        $the_chat->he_id = $data['he_id'];
        $the_chat->buff_exp = $data['buff_exp'];
        $the_chat->buff_luc = $data['buff_luc'];
        $the_chat->buff_ben = $data['buff_ben'];
        $the_chat->buff_tri = $data['buff_tri'];
        $the_chat->buff_man = $data['buff_man'];
        $the_chat->save();
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($thechat_id){
        $the_chat = TheChatModel::find($thechat_id);
        $the_chat->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
