@extends('layouts.app')
@section('title', 'Truyện của tôi')
@section('content')
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<?php
    use App\Models\Truyen\TruyenSub;
?>
<div class="container mt-5">
    <h2 class="text-center">Bạn đang có : {{$count}} truyện</h2>
    {{ $truyen->onEachSide(0)->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Ảnh truyện</th>
                    <th scope="col">Tiêu đề</th>
                    <th scope="col">Tác giả</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Nguồn</th>
                    <th scope="col">Thời gian</th>
                    <th scope="col">Chương - Thích - Không thích - Tủ - Quà</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($truyen as $key =>$value)
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
                        <th scope="row">{{ $key++ }}</th>
                        <td><img src="{{$value->img}}" id="phongto" style="max-height:70px;" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" ></td>
                        <td><a href="{{ url('truyen/'.$value->nguon.'/'.$value->id) }}">{{ $tieu_de }}</a> / {{$value->tieu_de}}</td>
                        <td>{{ $tac_gia }} / {{$value->tac_gia}}</td>
                        <td><a href="#!" data-toggle="modal" data-target="#gioi_thieu_{{$value->id}}" class="btn btn-sm btn-info">Giới thiệu</a></td>
                        <td>{{$value->nguon}}</td>
                        <td>{{$value->time_suf}} - {{$value->time_up}}</td>
                        <td>{{$value->so_chuong}} - {{$value->tong_like}} - {{$value->dislike}} - {{$value->tu}} - {{$value->curr_gif}} /  {{$value->gift}}</td>
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
