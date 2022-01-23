@extends('layouts.app')
@section('title', 'Creator nạp tiền')
@section('content')
<?php
use App\Models\User;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th>ID</th>
                    <th scope="col">Người nạp</th>
                    <th scope="col">Người nhận</th>
                    <th scope="col">Nội dung</th>
                    <th scope="col">Phương thức</th>
                    <th scope="col">Mã giao dịch</th>
                    <th scope="col">Khuyến mại</th>
                    <th scope="col">Số tiền</th>
                    <th scope="col">Thời gian</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nap_tien as $key => $value)
                    <tr>
                        <th scope="row">{{$key++}}</th>
                        <th scope="row">{{$value->id}}</th>
                        <td>{{User::find($value->uid)->name}} [{{$value->uid}}]</td>
                        <td>{{User::find($value->id_nhan)->name}} [{{$value->id_nhan}}]</td>
                        <td>@if(empty($value->noi_dung) && $value->status == 0) <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#rep_{{$value->id}}">Thêm trả lời</a> @else {{$value->noi_dung}} @endif</td>
                        <td>@if($value->phuong_thuc == 1 ) MOMO @elseif($value->phuong_thuc == 2) Paypal @else Ngân hàng @endif</td>
                        <td>{{$value->ma_giao_dich}}</td>
                        <td>@if(empty($value->khuyen_mai) && $value->status == 0) <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#khuyen_mai_{{$value->id}}">Thêm khuyến mại</a> @else {{$value->khuyen_mai}} @endif</td>
                        <td>@if(empty($value->so_tien) && $value->status != 2) <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#them_tien_{{$value->id}}">Thêm tiền</a>@else {{number_format($value->so_tien)}} @endif</td>
                        <td>{{$value->time}}</td>
                        <td>@if($value->status ==0 ) Chưa duyệt @elseif($value->status == 1) Đã thanh toán @else Đã từ chối @endif</td>
                        <td>
                            @if($value->status == 0 )
                                <a href="{{url('creator/nap-tien/tu-choi/'.$value->id)}}" class="btn btn-danger mr-2" onclick="confirm('Bạn chắc chắn không?')">Từ chối</a>
                                <a class="btn btn-success" onclick="confirm('Bạn chắc chắn không?')" href="{{url('creator/nap-tien/chap-nhan/'.$value->id)}}">Chấp nhận</a>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="them_tien_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Xác nhận ({{$value->id}})</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nap-tien/them-tien/'.$value->id)}}">
                                    @csrf
                                        <div class="form-group">
                                            <label >Nhập số tiền cần thêm</label>
                                            <input type="text" class="form-control" name="so_tien">
                                        </div>
                                        <button type="submit" class="btn btn-primary" >Gửi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="rep_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Trả lời ({{$value->id}})</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nap-tien/rep/'.$value->id)}}">
                                    @csrf
                                        <div class="form-group">
                                            <label >Nhập số tiền cần thêm</label>
                                            <textarea class="form-control" name="rep"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" >Gửi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="khuyen_mai_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Khuyến mại ({{$value->id}})</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nap-tien/khuyen-mai/'.$value->id)}}">
                                    @csrf
                                        <div class="form-group">
                                            <label >Nhập khuyến mại</label>
                                            <input type="number" min="1" class="form-control" name="khuyen_mai">
                                        </div>
                                        <button type="submit" class="btn btn-primary" >Gửi</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
