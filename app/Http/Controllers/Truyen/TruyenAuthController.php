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
        if(empty($data_chapter[$position])){
            return redirect('truyen/'.$host.'/'.$id)->with('error', 'Truyện chưa có chương này.');
        }
        $po = [];
        foreach ($data_chapter as $key => $value) {
            $po[] = $key;
        }
        $po_min = min($po);
        $po_max = max($po);
        if(empty($data_chapter[$position]['noi_dung']) || empty($data_chapter[$position]['noi_dung_sub'])){
            $get_url = get_url($host,$truyen->link).'/'.$data_chapter[$position]['link'];
            if($get_url == 0){
                return redirect()->back()->with('error', 'Link bị lỗi.');
            }
            $check1 = get_data_chapter($host,$position,$data_chapter,$truyen);
            $check = get_data_chapter_sub($host,$position,$data_chapter,$truyen);
            if($check1 == 0 || $check == 0){
                return redirect()->back()->with('error', 'Link bị lỗi.');
            }
            $data_chapter[$position]['noi_dung'] = $check1;
            $data_chapter[$position]['noi_dung_sub'] = $check;
            save_chapter($data_chapter,$truyen->id);
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
        return view('chapter')->with(compact('truyen','user','data_chapter','position','min','max','header'));
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
