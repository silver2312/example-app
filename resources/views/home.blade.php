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
                <h5 class="card-header">Truyện đề cử</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="card">
                                <img src="https://i.imgur.com/Wqh7gGX.png" alt="dsa" class="card-img-top">
                                <div class="card-body text-center">
                                    <span class="wrd font-weight-bold">43243</span>
                                    <small class="wrd">432432</small>
                                    <small class="wrd">{{format_text(123)}}</small>
                                </div>
                            </div>
                        </div>
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
                            }catch(Exception $e){
                                $tieu_de = $value_nhung->tieu_de;
                            }
                            try{
                                $tac_gia = $nhung_sub->tac_gia;
                            }catch(Exception $e){
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
                                        <small><span><i class="ni ni-like-2"></i> {{format_text($value_nhung->tong_like)}}</span> <span><i class="ni ni-like-2" style="transform: rotate(180deg);"></i> {{format_text($value_nhung->dislike)}}</span> <span><i class="fas fa-book"></i> {{format_text($value_nhung->so_chuong)}}</span></small>
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
                                    }catch(Exception $e){
                                        $tieu_de_up = $value_update->tieu_de;
                                    }
                                    try{
                                        $tac_gia_up = $nhung_update->tac_gia;
                                    }catch(Exception $e){
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
