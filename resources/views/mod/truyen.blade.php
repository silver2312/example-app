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
    <form class="navbar-search navbar-search-light form-inline mr-sm-3 mb-2 float-right" id="navbar-search-mod" method="GET" action="{{ url('mod/truyen/tim-kiem') }}" autocomplete="off">
        <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Tên truyện,tác giả,người nhúng,.." type="search" name="tu_khoa">
            </div>
        </div>
        <button type="button" class="close" data-action="search-close" data-target="#navbar-search-mod" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </form>
    <span class="d-sm-none">
        <a class="nav-link" href="#!" data-action="search-show" data-target="#navbar-search-mod">
            <i class="ni ni-zoom-split-in"></i>
        </a>
    </span>
    {{--  end Thêm chung_toc --}}
    {{ $truyen->onEachSide(0)->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Hình ảnh</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Tác giả</th>
                    <th scope="col">Giới thiệu</th>
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
                        <td><img src="{{$value->img}}" alt="{{$tieu_de}}" style="max-height: 70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" id="phongto"></td>
                        <td><a href="{{ url('truyen/'.$value->nguon.'/'.$value->id) }}">{{ $tieu_de }}</a> / {{$value->tieu_de}}</td>
                        <td>{{ $tac_gia }} / {{$value->tac_gia}}</td>
                        <td><a href="#!" data-toggle="modal" data-target="#gioi_thieu_{{$value->id}}" class="btn btn-sm btn-info">Giới thiệu</a></td>
                        <td><a href="{{ url('trang-ca-nhan/'.$value->nguoi_nhung) }}">{{check_name($value->nguoi_nhung)}}</a></td>
                        <td>{{$value->so_chuong}} - {{$value->tong_like}} - {{$value->dislike}} - {{$value->tu}} - {{$value->curr_gif}} /  {{$value->gift}}</td>
                        <td>{{$value->time_suf}} /  {{$value->time_up}}</td>
                        <td>@if($value->de_cu == 0)<a href="{{url('mod/truyen/de-cu/'.$value->id)}}" class="btn btn-sm btn-primary" onclick="return confirm('Bạn có chắc muốn đề cử truyện này không ?')">Đề cử</a>@else <a href="{{url('mod/truyen/xoa-de-cu/'.$value->id)}}" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá đề cử truyện này không ?')">Xoá đề cử</a> @endif</td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="gioi_thieu_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Giới thiệu</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                    <div class="row">
                                        <div class="col-6">{!! $value->gioi_thieu !!}</div>
                                        <div class="col-6">{!! $gioi_thieu !!}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $truyen->onEachSide(0)->links('vendor.pagination.simple-default') }}
</div>
@endsection
