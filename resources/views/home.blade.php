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
                        ?>
                            <div class="col-md-2 col-sm-4 col-4">
                                <div class="card">
                                    <img src="{{ $value_nhung->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" >
                                    <div class="card-body text-center">
                                        <a href="{{ url('truyen/'.$value_nhung->nguon.'/'.$value_nhung->id) }}" class="wrd font-weight-bold">{!! $nhung_sub->tieu_de !!}</a>
                                        <small class="wrd">{!! $nhung_sub->tac_gia !!}</small>
                                        <small><a class="wrd" href="{{ url('trang-ca-nhan/'.$value_nhung->nguoi_nhung) }}">{!! check_name($value_nhung->nguoi_nhung) !!}</a></small>
                                        <small><span><i class="ni ni-like-2"></i> {{format_text($value_nhung->tong_like)}}</span> <span><i class="ni ni-like-2" style="transform: rotate(180deg);"></i> {{format_text($value_nhung->dislike)}}</span> <span><i class="ni ni-book-bookmark"></i> {{format_text($value_nhung->tu)}}</span></small>
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
                <h5 class="card-header">Truyện Mới cập nhật <a href="#!" class="float-right">Xem thêm</a></h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @foreach($truyen_update as $key_update => $value_update)
                                <?php
                                    $nhung_update = TruyenSub::find($value_update->id);
                                ?>
                                <div class="card">
                                    <div class="row">
                                        <div class="col-2 p-1 pl-2 pt-2">
                                            <img src="{{ $value_update->img }}" class="card-img-top" alt="{{$nhung_update->tieu_de}}" style="max-height:70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" >
                                        </div>
                                        <div class="col-10 card-body">
                                            <a href="{{ url('truyen/'.$value_update->nguon.'/'.$value_update->id) }}" class="font-weight-bold wrd">{{$nhung_update->tieu_de}}</a>
                                            <small><a class="wrd" href="{{ url('trang-ca-nhan/'.$value_nhung->nguoi_nhung) }}">{!! check_name($value_nhung->nguoi_nhung) !!}</a></small>
                                            <small class="wrd">{{$nhung_update->tac_gia}} - {{$value_update->time_up}}</small>
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
