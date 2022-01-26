<?php

namespace App\Http\Controllers\Truyen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Goutte\Client;
use Carbon\Carbon;
use Throwable;
use App\Models\Truyen\Truyen;
use App\Models\User;

class NhungController extends Controller
{
    public function nhung(Request $request){
        $data = $request->validate([
            'link' => 'required|url',
        ],
        [
            'link.required' => 'Link không được để trống',
            'link.url' => 'Link không đúng định dạng',
        ]);
        $url = $data['link'];
        $host = get_host($url);
        $link = get_link($url);
        if($host == 0){
            return redirect()->back()->with('error', 'Hệ thống chưa hỗ trợ host này.');
        }
        if($link == 0){
            return redirect()->back()->with('error', 'Hệ thống chưa hỗ trợ link này.');
        }
        $iset = Truyen::where('link',$link)->where('nguon',$host)->first();
        if(isset($iset)){
            return redirect('truyen/'.$iset->nguon.'/'.$iset->id)->with('error','Truyện đã tồn tại');
        }
        $client = new Client();
        $get_url = get_url($host,$link);
        if($get_url == 0){
            return redirect()->back()->with('error', 'Link bị lỗi.');
        }
        $crawler = $client->request('GET', $get_url);
        $truyen = new Truyen();
        $truyen->nguoi_nhung = Auth::user()->id;
        $truyen->so_chuong = 0;
        $truyen->trang_thai = 0;
        $truyen->tong_like = 0;
        $truyen->dislike = 0;
        $truyen->gift = 0;
        $truyen->curr_gif = 0;
        $truyen->tu = 0;
        $truyen->danh_muc = 0;
        $truyen->de_cu = 0;
        $truyen->time_suf = Carbon::now('Asia/Ho_Chi_Minh');
        $truyen->time_up = Carbon::now('Asia/Ho_Chi_Minh');
        $truyen->link = $link;
        $truyen->nguon = $host;
        $arr = get_header($host,$crawler);
        if($arr == 0){
            return redirect()->back()->with('error', 'Hệ thống chưa hỗ trợ link này.');
        }
        $truyen->tieu_de = $arr['tieu_de'];
        $truyen->gioi_thieu = $arr['gioi_thieu'];
        $truyen->tac_gia = explode('：',$arr['tac_gia'])[1];
        $truyen->img = $arr['img'];
        $truyen->save();
        check_nhung();
        check_truyen_sub();
        try{
            $new_truyen = Truyen::orderBy('time_up', 'desc')->where('nguoi_nhung',Auth::user()->id)->first();
            return redirect('truyen/'.$new_truyen->nguon.'/'.$new_truyen->id)->with('status','Đã nhúng truyện.');
        }catch(Throwable $e){
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra.');
        }
    }
    public function dsc($host,$id){
        $truyen = Truyen::find($id);
        check_data($truyen);
        if($truyen->nguon != $host){
            return redirect()->back()->with('error', 'Truyện đã bị lỗi.');
        }
        $user = User::find($truyen->nguoi_nhung);
        if(empty($user)){
            $truyen->nguoi_nhung = 0;
            $truyen->save();
        }
        $url = get_url($truyen->nguon,$truyen->link);
        $data_chapter = data_chapter($id);
        $arr = get_chapter($host,$url,$data_chapter,$id,$truyen);
        if($arr == 0){
            return redirect()->back()->with('error', 'Có lỗi xảy ra.');
        }
        return redirect()->back()->with('status','Đã cập nhật truyện.');
    }
}
