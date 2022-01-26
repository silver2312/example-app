<?php

namespace App\Http\Controllers\Mod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Truyen\Truyen;
use App\Models\Truyen\TruyenSub;
use App\Models\User;

class TruyenController extends Controller
{
    public function index()
    {
        $truyen = Truyen::paginate(21);
        return view('mod.truyen')->with(compact('truyen'));
    }
    public function tim_kiem(){
        $tu_khoa = $_GET['tu_khoa'];
        $truyen_sub = TruyenSub::where('tieu_de','like','%'.$tu_khoa.'%')->orWhere('tac_gia','like','%'.$tu_khoa.'%')->get();
        $id = [];
        foreach ($truyen_sub as $key => $value) {
            $id[] = $value->id;
        }
        $truyen = Truyen::whereIn('id',$id)->paginate(24);
        if(empty($id)){
            $nguoi_nhung = User::where('name','like','%'.$tu_khoa.'%')->get();
            $idu = [];
            foreach ($nguoi_nhung as $keyu => $valueu) {
                $idu[] = $valueu->id;
            }
            $truyen = Truyen::whereIn('nguoi_nhung',$idu)->paginate(24);
        }
        return view('mod.truyen')->with(compact('truyen'));
    }
    public function de_cu($id){
        $truyen = Truyen::find($id);
        if($truyen->de_cu == 1){
            return redirect()->back()->with('error','Truyện đã được đề cử.');
        }
        $all = Truyen::all();
        $max = 0;
        foreach($all as $key => $value){
            if($value->de_cu == 1){
                $max++;
            }
        }
        if($max <12){
            $truyen->de_cu = 1;
            $truyen->save();
        }else{
            return redirect()->back()->with('error','Đã có 12 truyện đề cử.');
        }
        return redirect()->back()->with('staus','Đề cử thành công');
    }
    public function img($id){
        $truyen = Truyen::find($id);
        $truyen->img = "https://i.imgur.com/hQRlkUR.png";
        $truyen->save();
        return 'Đã đổi';
    }
}
