@extends('layouts.app')
@section('title', 'MyScáthach')
@section('content')
<?php
use App\Models\Truyen\TruyenSub;
?>
{{-- đề cử --}}
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header text-center  text-danger"><i class="ni ni-air-baloon"></i> Thông báo</h3>
                <div class="card-body">
                    @if(Auth::check() && Auth::user()->level == 0)
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#thong_bao_modal">Quản lý thông báo</button>
                        <!-- Modal -->
                        <div class="modal fade" id="thong_bao_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Thông báo</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                                <form enctype='multipart/form-data' method="POST" action="{{url('creator/thong-bao-home')}}" autocomplete="off">
                                                @csrf
                                                    <div class="form-group">
                                                        <label>Giới thiệu</label>
                                                        @if(empty($thong_bao))
                                                            <textarea  name="noi_dung" id="gioi_thieu_tb" class="form-control"></textarea>
                                                        @else
                                                        <textarea  name="noi_dung" id="gioi_thieu_tb" class="form-control">{!! $thong_bao->noi_dung !!}</textarea>
                                                        @endif
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                </form>
                                                @section('script_ll')
                                                    <script>
                                                        CKEDITOR.replace( 'gioi_thieu_tb' );
                                                    </script>
                                                @endsection
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if(isset($thong_bao))
                        <div class="pl-10 pr-10 text-center">
                            {!! $thong_bao->noi_dung !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
{{-- đề cử --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Truyện đề cử</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($de_cu as $key_dc => $value_dc)
                        <?php
                            $nhung_sub_dc = TruyenSub::find($value_dc->id);
                            try{
                                $tieu_de_dc = $nhung_sub_dc->tieu_de;
                            }catch(Throwable $e){
                                $tieu_de_dc = $value_dc->tieu_de;
                            }
                            try{
                                $tac_gia_dc = $nhung_sub_dc->tac_gia;
                            }catch(Throwable $e){
                                $tac_gia_dc = $value_dc->tac_gia;
                            }
                        ?>
                            <div class="col-md-2 col-sm-4 col-4">
                                <div class="card">
                                    <img src="{{ $value_dc->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" rel="tooltip" data-html="true" data-placement="bottom" title="{!! $tieu_de_dc !!}">
                                    <div class="card-body text-center">
                                        <a href="{{ url('truyen/'.$value_dc->nguon.'/'.$value_dc->id) }}" class="wrd font-weight-bold" rel="tooltip" data-html="true" title="{!! $tieu_de_dc !!}">{!! $tieu_de_dc !!}</a>
                                        <small class="wrd">{!! $tac_gia_dc !!}</small>
                                        <small class="wrd" >{!! check_name($value_dc->nguoi_nhung) !!}</small>
                                        <small><button class="btn btn-sm btn-success"><i class="ni ni-like-2"></i>{{format_text($value_dc->tong_like)}}<i class="ni ni-book-bookmark"></i>{{format_text($value_dc->tu)}}<i class="ni ni-books"></i> {{format_text($value_dc->so_chuong)}}</button></small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- like --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Truyện nhiều lượt thích</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($truyen_like as $key_like => $value_like)
                        <?php
                            $nhung_sub_like = TruyenSub::find($value_like->id);
                            try{
                                $tieu_de_like = $nhung_sub_like->tieu_de;
                            }catch(Throwable $e){
                                $tieu_de_like = $value_like->tieu_de;
                            }
                            try{
                                $tac_gia_like = $nhung_sub_like->tac_gia;
                            }catch(Throwable $e){
                                $tac_gia_like = $value_like->tac_gia;
                            }
                        ?>
                            <div class="col-md-2 col-sm-4 col-4">
                                <div class="card">
                                    <img src="{{ $value_like->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" rel="tooltip" data-html="true" data-placement="bottom" title="{!! $tieu_de_like !!}">
                                    <div class="card-body text-center">
                                        <a href="{{ url('truyen/'.$value_like->nguon.'/'.$value_like->id) }}" class="wrd font-weight-bold" rel="tooltip" data-html="true" title="{!! $tieu_de_like !!}">{!! $tieu_de_like !!}</a>
                                        <small class="wrd">{!! $tac_gia_like !!}</small>
                                        <small class="wrd" >{!! check_name($value_like->nguoi_nhung) !!}</small>
                                        <small><button class="btn btn-sm btn-success"><i class="ni ni-like-2"></i>{{format_text($value_like->tong_like)}}<i class="ni ni-books"></i> {{format_text($value_like->so_chuong)}}</button></small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- theo dõi --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Truyện nhiều theo dõi nhất</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($truyen_tu as $key_tu => $value_tu)
                        <?php
                            $nhung_sub_tu = TruyenSub::find($value_tu->id);
                            try{
                                $tieu_de_tu = $nhung_sub_tu->tieu_de;
                            }catch(Throwable $e){
                                $tieu_de_tu = $value_tu->tieu_de;
                            }
                            try{
                                $tac_gia_tu = $nhung_sub_tu->tac_gia;
                            }catch(Throwable $e){
                                $tac_gia_tu = $value_tu->tac_gia;
                            }
                        ?>
                            <div class="col-md-2 col-sm-4 col-4">
                                <div class="card">
                                    <img src="{{ $value_tu->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" rel="tooltip" data-html="true" data-placement="bottom" title="{!! $tieu_de_tu !!}">
                                    <div class="card-body text-center">
                                        <a href="{{ url('truyen/'.$value_tu->nguon.'/'.$value_tu->id) }}" class="wrd font-weight-bold" rel="tooltip" data-html="true" title="{!! $tieu_de_tu !!}">{!! $tieu_de_tu !!}</a>
                                        <small class="wrd">{!! $tac_gia_tu !!}</small>
                                        <small class="wrd" >{!! check_name($value_tu->nguoi_nhung) !!}</small>
                                        <small><button class="btn btn-sm btn-success"><i class="ni ni-book-bookmark"></i>{{format_text($value_tu->tu)}}<i class="ni ni-books"></i> {{format_text($value_tu->so_chuong)}}</button></small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- nhúng --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Truyện nhúng ngẫu nhiên</h5>
                <div class="card-body">
                    <div class="row">
                        @foreach ($truyen_nhung as $key_nhung => $value_nhung)
                        <?php
                            $nhung_sub = TruyenSub::find($value_nhung->id);
                            try{
                                $tieu_de = $nhung_sub->tieu_de;
                            }catch(Throwable $e){
                                $tieu_de = $value_nhung->tieu_de;
                            }
                            try{
                                $tac_gia = $nhung_sub->tac_gia;
                            }catch(Throwable $e){
                                $tac_gia = $value_nhung->tac_gia;
                            }
                        ?>
                            <div class="col-md-2 col-sm-4 col-4">
                                <div class="card">
                                    <img src="{{ $value_nhung->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" rel="tooltip" data-html="true" data-placement="bottom" title="{!! $tieu_de !!}">
                                    <div class="card-body text-center">
                                        <a href="{{ url('truyen/'.$value_nhung->nguon.'/'.$value_nhung->id) }}" class="wrd font-weight-bold" rel="tooltip" data-html="true" title="{!! $tieu_de !!}">{!! $tieu_de !!}</a>
                                        <small class="wrd">{!! $tac_gia !!}</small>
                                        <small class="wrd" >{!! check_name($value_nhung->nguoi_nhung) !!}</small>
                                        <small><button class="btn btn-sm btn-success"><i class="ni ni-like-2"></i>{{format_text($value_nhung->tong_like)}}<i class="ni ni-book-bookmark"></i>{{format_text($value_nhung->tu)}}<i class="ni ni-books"></i> {{format_text($value_nhung->so_chuong)}}</button></small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Truyện Mới cập nhật <a href="{{ url('truyen/cap-nhat') }}" class="float-right">Xem thêm</a></h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @foreach($truyen_update as $key_update => $value_update)
                                <?php
                                    $nhung_update = TruyenSub::find($value_update->id);
                                    try{
                                        $tieu_de_up = $nhung_update->tieu_de;
                                    }catch(Throwable $e){
                                        $tieu_de_up = $value_update->tieu_de;
                                    }
                                    try{
                                        $tac_gia_up = $nhung_update->tac_gia;
                                    }catch(Throwable $e){
                                        $tac_gia_up = $value_update->tac_gia;
                                    }
                                ?>
                                <div class="card">
                                    <div class="row">
                                        <div class="col-2">
                                            <a href="{{ url('truyen/'.$value_update->nguon.'/'.$value_update->id) }}"><img src="{{ $value_update->img }}" class="card-img-top p-1" alt="{{$tieu_de}}" style="height:70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" ></a>
                                        </div>
                                        <div class="card-body col-10" style="flex:none;">
                                            <span class="font-weight-bold wrd" rel="tooltip" data-html="true" title="{!! $tieu_de_up !!}">{{$tieu_de_up}}</span>
                                            <small class="wrd" >{!! check_name($value_update->nguoi_nhung) !!}</small>
                                            <small class="wrd">{{$tac_gia_up}} - {{$value_update->time_up}}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if(Auth::check())
                            <div class="col-md-4">
                                <?php
                                if(file_exists(Auth::user()->u_image )){
                                    $image_cbox = url(Auth::user()->u_image);
                                }else{
                                    $image_cbox = 'https://i.imgur.com/nAE9VPf.png';
                                }

                                    $secret = "eDrSyQrsHoZh4_uL";

                                    $params = array(
                                        'boxid' => 930744,
                                        'boxtag' => 'ASUV78',
                                        'nme' =>Auth::user()->name,	// Replace with user name variable
                                        'lnk' => url('trang-ca-nhan/'.Auth::user()->id),		// Replace with profile URL (optional)
                                        'pic' => $image_cbox		// Replace with avatar URL (optional)
                                    );

                                    $arr = array();
                                    foreach ($params as $k => $v) {
                                        if (!$v) {
                                            continue;
                                        }
                                        $arr[] = $k.'='.urlencode($v);
                                    }

                                    $path = '/box/?'.implode('&', $arr);
                                    $sig = urlencode(base64_encode(hash_hmac("sha256", $path, $secret, true)));
                                    $url = 'https://www5.cbox.ws'.$path.'&sig='.$sig;

                                    echo '<iframe width="100%" height="400" src="'.$url.'" marginheight="0" marginwidth="0" scrolling="no" allowtransparency="yes" frameborder="0"></iframe>';

                                ?>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
