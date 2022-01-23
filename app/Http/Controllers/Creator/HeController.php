<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Throwable;
use App\Models\PathAll;
use App\Models\Game\HeModel;

class HeController extends Controller
{
    public function index(){
        $he = HeModel::get();
        $path = PathAll::first();
        $data_he = data_he();
        return view('creator.he')->with(compact('he','path','data_he'));

    }
    public function them(Request $request){
        $data = $request->validate([
            'ten_he' => 'required|max:255',
            'He' => 'required',
        ]);
        $he = new HeModel();
        $he->ten_he = $data['ten_he'];
        $he->save();
        $data_he = data_he();
        $new_id_he = HeModel::orderBy('id','desc')->first();
        $data_he[$new_id_he->id]['khac_che'] = $data['He'];
        save_he($data_he);
        return Redirect()->back()->with('status','Đã thêm');
    }
    public function sua(Request $request,$he_id){
        $data = $request->validate([
            'ten_he' => 'required|max:255',
            'He' => 'required',
        ]);
        $he = HeModel::find($he_id);
        $he->ten_he = $data['ten_he'];
        $he->save();
        $data_he = data_he();
        try{
            unset($data_he[$he_id]);
            save_he($data_he);
            $data_he[$he_id]['khac_che'] = $data['He'];
            save_he($data_he);
        }catch(Throwable $e){
            $data_he[$he_id]['khac_che'] = $data['He'];
            save_he($data_he);
        }
        return Redirect()->back()->with('status','Đã sửa');

    }
    public function xoa($he_id){
        $he = HeModel::find($he_id);
        $he->delete();
        $data_he = data_he();
        try{
            unset($data_he[$he_id]);
            save_he($data_he);
            return Redirect()->back()->with('status','Đã xoá');
        }catch (Throwable $e){
            return Redirect()->back()->with('status','Đã xoá');
        }
    }
}
