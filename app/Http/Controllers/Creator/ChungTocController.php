<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Game\ChungTocModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\TheChatModel;
use App\Models\PathAll;

class ChungTocController extends Controller
{
    public function index(){
        $chung_toc = ChungTocModel::paginate(10);
        $nang_luong = NangLuongModel::get();
        $the_chat = TheChatModel::get();
        $path =  PathAll::first();
        $data_chungtoc = data_chungtoc();
        $path_chungtoc = $path->path_chungtoc;
        //edn check
        return view('creator.chung_toc', compact('chung_toc', 'nang_luong', 'the_chat', 'data_chungtoc', 'path_chungtoc'));
    }
    public function them(Request $request)
    {
        $chung_toc = new ChungTocModel();
        $path =  PathAll::first();
        $data = $request->validate([
            'ten' => 'required|unique:chung_toc|max:255',
            'ty_le' => 'required',
            'nangLuong' => 'required',
            'theChat' => 'required',
            'max_luc' => 'required',
            'max_tri' => 'required',
            'max_ben' => 'required',
            'max_man' => 'required',
            'max_exp' => 'required',
            'max_thonguyen' => 'required',
            'gioi_thieu' => 'required'
        ]);
        // end check
        $chung_toc->ten = $data['ten'];
        $chung_toc->ty_le = $data['ty_le'];
        $chung_toc->max_luc = $data['max_luc'];
        $chung_toc->max_tri = $data['max_tri'];
        $chung_toc->max_ben = $data['max_ben'];
        $chung_toc->max_man = $data['max_man'];
        $chung_toc->max_exp = $data['max_exp'];
        $chung_toc->max_thonguyen = $data['max_thonguyen'];
        $chung_toc->gioi_thieu = $data['gioi_thieu'];
        $chung_toc->save();
        $chung_toc_id = ChungTocModel::orderBy('id','DESC')->first()->id;
        //thêm id thể chất + năng lượng
        $json_chungtoc = file_get_contents($path->path_chungtoc);
        $data_chungtoc = json_decode($json_chungtoc,true);
        $data_chungtoc[$chung_toc_id] = [
            'id' => $chung_toc_id,
            'the_chat' => $data['theChat'],
            'nang_luong' => $data['nangLuong']
        ];
        $newJsonString = json_encode($data_chungtoc, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
        file_put_contents($path->path_chungtoc, $newJsonString);
        //thêm năng lượng
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request,$chungtoc_id){
        $chung_toc = ChungTocModel::find($chungtoc_id);
        $data_chungtoc = data_chungtoc();
        $data = $request->validate([
            'ten' => 'required|max:255',
            'ty_le' => 'required',
            'nangLuong' => 'required',
            'theChat' => 'required',
            'max_luc' => 'required',
            'max_tri' => 'required',
            'max_ben' => 'required',
            'max_man' => 'required',
            'max_exp' => 'required',
            'max_thonguyen' => 'required',
            'gioi_thieu' => 'required'
        ]);
        //xoá năng lượng + thể chất với tộc id
        unset($data_chungtoc[$chungtoc_id]);
        save_chungtoc($data_chungtoc);
        //end xoá
        $chung_toc->ten = $data['ten'];
        $chung_toc->ty_le = $data['ty_le'];
        $chung_toc->max_luc = $data['max_luc'];
        $chung_toc->max_tri = $data['max_tri'];
        $chung_toc->max_ben = $data['max_ben'];
        $chung_toc->max_man = $data['max_man'];
        $chung_toc->max_exp = $data['max_exp'];
        $chung_toc->max_thonguyen = $data['max_thonguyen'];
        $chung_toc->gioi_thieu = $data['gioi_thieu'];
        $chung_toc->update_at = Carbon::now('Asia/Ho_Chi_Minh');
        $chung_toc->save();
        //thêm năng lượng + thể chất
        $data_chungtoc[$chungtoc_id] = [
            'id' => $chungtoc_id,
            'the_chat' => $data['theChat'],
            'nang_luong' => $data['nangLuong']
        ];
        save_chungtoc($data_chungtoc);
        //end thêm năng lượng + thể chất
        return Redirect()->back()->with('status','Đã sửa');
    }
    public function xoa($chungtoc_id){
        $chung_toc = ChungTocModel::find($chungtoc_id);
        $data_chungtoc = data_chungtoc();
        //xoá năng lượng + thể chất id
        unset($data_chungtoc[$chungtoc_id]);
        save_chungtoc($data_chungtoc);
        //end xoá
        $chung_toc->delete();
        return Redirect()->back()->with('status','Đã xoá');
    }
}
