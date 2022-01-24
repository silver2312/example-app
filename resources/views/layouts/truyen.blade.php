@extends('layouts.app')
@section('title', $title)
@section('content')
<?php
use App\Models\Truyen\TruyenSub;
?>

<div class="container mt-5">
    <h1 style="text-transform: capitalize;color:greenyellow">{{ $title }}</h1>
    {{ $truyen->onEachSide(1)->links('vendor.pagination.simple-default') }}
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card-body">
                <div class="row">
                    @foreach ($truyen as $key => $value)
                    <?php
                        $nhung_sub = TruyenSub::find($value->id);
                        try{
                            $tieu_de = $nhung_sub->tieu_de;
                        }catch(Exception $e){
                            $tieu_de = $value->tieu_de;
                        }
                        try{
                            $tac_gia = $nhung_sub->tac_gia;
                        }catch(Exception $e){
                            $tac_gia = $value->tac_gia;
                        }
                    ?>
                        <div class="col-md-2 col-sm-4 col-4">
                            <div class="card">
                                <img src="{{ $value->img }}" alt="dsa" class="card-img-top img_custom" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" rel="tooltip" data-html="true" data-placement="bottom" title="{!! $tieu_de !!}">
                                <div class="card-body text-center">
                                    <a href="{{ url('truyen/'.$value->nguon.'/'.$value->id) }}" class="wrd font-weight-bold" rel="tooltip" data-html="true" title="{!! $tieu_de !!}">{!! $tieu_de !!}</a>
                                    <small class="wrd">{!! $tac_gia !!}</small>
                                    <small class="wrd" >{!! check_name($value->nguoi_nhung) !!}</small>
                                    <small><span><i class="ni ni-like-2"></i> {{format_text($value->tong_like)}}</span> <span><i class="ni ni-like-2" style="transform: rotate(180deg);"></i> {{format_text($value->dislike)}}</span> <span><i class="fas fa-book"></i> {{format_text($value->so_chuong)}}</span></small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    {{ $truyen->onEachSide(1)->links('vendor.pagination.simple-default') }}
</div>

@endsection
