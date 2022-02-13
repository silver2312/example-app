<?php

namespace App\Http\Controllers\Truyen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Truyen\Truyen;
use App\Models\Truyen\TruyenSub;
use App\Models\User;
use Goutte\Client;

class TruyenAuthController extends Controller
{
    public function index($host,$id){
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
        $truyen_sub = TruyenSub::find($id);
        $data_chapter = data_chapter($id);
        if(isset($data_chapter)){
            $data_chapter = $this->paginate($data_chapter);
        }
        if(empty($truyen_sub)){
            $truyen_sub = $truyen;
        }
        return view('truyen')->with(compact('truyen','user','data_chapter','truyen_sub'));
    }
    public function chapter($host,$id,$position){
        $truyen = Truyen::find($id);
        $truyen_sub = TruyenSub::find($id);
        if(empty($truyen_sub)){
            $truyen_sub = $truyen;
        }
        check_data($truyen);
        if($truyen->nguon != $host){
            return redirect()->back()->with('error', 'Truyện đã bị lỗi.');
        }
        $user = User::find($truyen->nguoi_nhung);
        if(empty($user)){
            $truyen->nguoi_nhung = 0;
            $truyen->save();
        }
        $data_chapter = data_chapter($id);
        if(empty($data_chapter[$position]) || empty($data_chapter[$position]['link'])){
            return redirect('truyen/'.$host.'/'.$id)->with('error', 'Truyện chưa có chương này.');
        }
        $po = [];
        foreach ($data_chapter as $key => $value) {
            $po[] = $key;
        }
        $po_min = min($po);
        $po_max = max($po);
        if(empty($data_chapter[$position]['noi_dung']) || empty($data_chapter[$position]['noi_dung_sub'])){
            $arr = get_data_chapter($position,$data_chapter,$truyen);
            if($arr == 0){
                return redirect()->back()->with('error', 'Dịch lỗi.');
            }
        }
        $data_chapter = data_chapter($id);
        if($position > $po_min){
            $min = $position - 1;
        }else{
            $min = $po_min;
        }
        if($position < $po_max){
            $max = $position + 1;
        }else{
            $max = $po_max;
            $url = get_url($truyen->nguon,$truyen->link);
            $arr = get_chapter($host,$url,$data_chapter,$id,$truyen);
            if($arr == 0){
                return redirect()->back()->with('error', 'Có lỗi xảy ra.');
            }
        }
        try{
            $header = $data_chapter[$position]['header_sub'];
        }catch(\Exception $e){
            $header = $data_chapter[$position]['header'];
        }
        return view('chapter')->with(compact('truyen','user','data_chapter','position','min','max','header','truyen_sub'));
    }
    public function cua_toi(){
        $truyen = Truyen::orderBy('time_up', 'desc')->where('nguoi_nhung',auth()->user()->id)->paginate(21);
        $truyen_c = Truyen::where('nguoi_nhung',auth()->user()->id)->get();
        try{
            $count = count($truyen_c);
        }catch(\Exception $e){
            $count = 0;
        }
        return view('pages.truyen')->with(compact('truyen','count'));
    }
    public function dang_doc($id,$position){
        $truyen = Truyen::find($id);
        $uid = auth()->user()->id;
        $data_dangdoc = data_dangdoc($uid);
        if(empty($data_dangdoc[$id]) || empty($data_dangdoc[$id][$position])){
            $data_dangdoc[$id]['chapter'] = $position;
            save_dangdoc($data_dangdoc,$uid);
        }
        return "Đã thêm vào danh sách đang đọc.";
    }
    public function data_dangdoc(){
        return view('modal.data_dangdoc');
    }
    public function del_dd($key){
        $data_dangdoc = data_dangdoc(auth()->user()->id);
        if(isset($data_dangdoc[$key])){
            unset($data_dangdoc[$key]);
            save_dangdoc($data_dangdoc,auth()->user()->id);
        }
        return "Đã xóa khỏi danh sách đang đọc.";
    }
    public function them_tu($id){
        $data_tutruyen = data_tutruyen((auth()->user()->id));
        if(isset($data_tutruyen[$id])){
            return 0;
        }
        $data_tutruyen[$id]['id'] = $id;
        save_tutruyen($data_tutruyen,auth()->user()->id);
        $truyen = Truyen::find($id);
        $truyen->tu = $truyen->tu + 1;
        $truyen->save();
        return 1;
    }
    public function like($id){
        $data_like = data_like($id);
        $data_dislike = data_dislike($id);
        $truyen = Truyen::find($id);
        if(isset($data_like[auth()->user()->id])){
            unset($data_like[auth()->user()->id]);
            save_like($data_like,$id);
            $truyen->tong_like = $truyen->tong_like - 1;
            $truyen->save();
            return 0;
        }
        if(isset($data_dislike[auth()->user()->id])){
            return 1;
        }
        $data_like[auth()->user()->id]['id'] = auth()->user()->id;
        save_like($data_like,$id);
        $truyen->tong_like = $truyen->tong_like + 1;
        $truyen->save();
        return 2;
    }
    public function dislike($id){
        $data_like = data_like($id);
        $data_dislike = data_dislike($id);
        $truyen = Truyen::find($id);
        if(isset($data_dislike[auth()->user()->id])){
            unset($data_dislike[auth()->user()->id]);
            save_dislike($data_dislike,$id);
            $truyen->dislike = $truyen->dislike - 1;
            $truyen->save();
            return 0;
        }
        if(isset($data_like[auth()->user()->id])){
            return 1;
        }
        $data_dislike[auth()->user()->id]['id'] = auth()->user()->id;
        save_dislike($data_dislike,$id);
        $truyen->dislike = $truyen->dislike + 1;
        $truyen->save();
        return 2;
    }











































    public function paginate($items, $perPage = 21, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
        'path' => Paginator::resolveCurrentPath(),
        'pageName' => 'page',
        ]);
    }
    function fetch_data(Request $request,$host,$id)
    {
        if($request->ajax())
        {
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
            $data_chapter = data_chapter($id);
            $data_chapter = $this->paginate($data_chapter);
            return view('custom.paginate_chapter')->with(compact('truyen','user','data_chapter'));
        }
    }
}
