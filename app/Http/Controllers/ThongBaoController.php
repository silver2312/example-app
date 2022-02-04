<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThongBaoModel;

class ThongBaoController extends Controller
{
    public function index(Request $request){
        $data = $request->all();
        $thong_bao = ThongBaoModel::where('tag',0)->first();
        if(empty($thong_bao)){
            $thong_bao = new ThongBaoModel();
            $thong_bao->tag = 0;
            $thong_bao->noi_dung = $data['noi_dung'];
            $thong_bao->save();
            return redirect()->back()->with('status','Đã thêm thông báo.');
        }
        $thong_bao->noi_dung = $data['noi_dung'];
        $thong_bao->save();
        return redirect()->back()->with('status','Đã sửa thông báo.');
    }
    public function tu_luyen(Request $request){
        $data = $request->all();
        $thong_bao = ThongBaoModel::where('tag',1)->first();
        if(empty($thong_bao)){
            $thong_bao = new ThongBaoModel();
            $thong_bao->tag = 1;
            $thong_bao->noi_dung = $data['noi_dung'];
            $thong_bao->save();
            return redirect()->back()->with('status','Đã thêm thông báo.');
        }
        $thong_bao->noi_dung = $data['noi_dung'];
        $thong_bao->save();
        return redirect()->back()->with('status','Đã sửa thông báo.');
    }
}
