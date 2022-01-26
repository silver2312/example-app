@extends('layouts.app')
@section('title', 'Quản lý truyện')
@section('content')
<?php
use App\Models\Truyen\TruyenSub;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <!-- Search form -->
    <form class="navbar-search navbar-search-light form-inline mr-sm-3 mb-2" id="navbar-search-main" method="GET" action="{{ url('mod/truyen/tim-kiem') }}" autocomplete="off">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Tên truyện,tác giả,người nhúng,.." type="search" name="tu_khoa">
            </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </form>
    {{--  end Thêm chung_toc --}}
    {{ $truyen->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Tác giả</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Người nhúng(viết)</th>
                    <th scope="col">Chương - Thích - Không thích - Tủ - Quà</th>
                    <th scope="col">Thời gian</th>
                    <th scope="col">Đề cử</th>
                </tr>
            </thead>
            <tbody>
                @foreach($truyen as $key => $value)
                    <?php
                        $truyen_sub = TruyenSub::find($value->id);
                        try{
                            $tieu_de = $truyen_sub->tieu_de;
                        }catch(Throwable $e){
                            $tieu_de = $value->tieu_de;
                        }
                        try{
                            $tac_gia = $truyen_sub->tac_gia;
                        }catch(Throwable $e){
                            $tac_gia = $value->tac_gia;
                        }
                        try{
                            $gioi_thieu = $truyen_sub->gioi_thieu;
                        }catch(Throwable $e){
                            $gioi_thieu = $value->gioi_thieu;
                        }
                    ?>
                    <tr>
                        <th scope="row">{{$value->id}}</th>
                        <td><a href="{{ url('truyen/'.$value->nguon.'/'.$value->id) }}">{{ $tieu_de }}</a> / {{$value->tieu_de}}</td>
                        <td>{{ $tac_gia }} / {{$value->tac_gia}}</td>
                        <td>{{ $gioi_thieu }}</td>
                        <td>{{$value->gioi_thieu}}</td>
                        <td><img src="{{$value->img}}" alt="{{$tieu_de}}" style="max-height: 70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" id="phongto"></td>
                        <td><a href="{{ url('trang-ca-nhan/'.$value->nguoi_nhung) }}">{{check_name($value->nguoi_nhung)}}</a></td>
                        <td>{{$value->so_chuong}} - {{$value->tong_like}} - {{$value->dislike}} - {{$value->tu}} - {{$value->curr_gif}} /  {{$value->gift}}</td>
                        <td>{{$value->time_suf}} /  {{$value->time_up}}</td>
                        <td><a href="{{url('mod/truyen/de-cu/'.$value->id)}}" class="btn btn-sm btn-primary" onclick="return confirm('Bạn có chắc muốn đề cử truyện này không ?')">Đề cử</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $truyen->links('vendor.pagination.simple-default') }}
</div>
@endsection
