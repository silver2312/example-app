@extends('layouts.app')
@section('title', 'Creator hệ')
@section('content')
<?php
use App\Models\Game\HeModel;
use App\Models\Game\NangLuongModel;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#" class="btn btn-primary m-2" data-toggle="modal" data-target="#cong_phap">Thêm công pháp mới</a>
    {{-- thêm công pháp --}}
        <div class="modal fade" id="cong_phap" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm công pháp</h5>
                    </div>
                    <div class="modal-body">
                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/cong-phap/them')}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Tên</label>
                                <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                            </div>
                            <div class="form-group col-6">
                                <label>Buff exp</label>
                                <input type="number" step="any" class="form-control" name="buff_exp" value="1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-3">
                                <label>Đồng tệ</label>
                                <input type="number" step="any" class="form-control" name="dong_te" value="0">
                            </div>
                            <div class="form-group col-3">
                                <label>Ngân tệ</label>
                                <input type="number" step="any" class="form-control" name="ngan_te" value="0">
                            </div>
                            <div class="form-group col-3">
                                <label>Kim tệ</label>
                                <input type="number" step="any" class="form-control" name="kim_te" value="0">
                            </div>
                            <div class="form-group col-3">
                                <label>ME</label>
                                <input type="number" step="any" class="form-control" name="me" value="0">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3 col-6">
                                <label>Trạng thái</label>
                                    <select class="form-control" name="status">
                                            <option value="0">Chưa bán</option>
                                            <option value="1">Đang bán</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3 col-6">
                                <label>Buff</label>
                                    <select class="form-control" name="buff">
                                            <option value="0">Cộng</option>
                                            <option value="1">Nhân</option>
                                    </select>
                            </div>
                            <div class="form-group col-md-3 col-6">
                                <label>Hệ</label>
                                <select class="form-control" name="he_id">
                                    @foreach($he as $key_he => $value_he)
                                        <option value="{{$value_he->id}}">{{$value_he->ten_he}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3 col-6">
                                <label>Năng lượng</label>
                                <select class="form-control" name="nangluong_id">
                                    @foreach($nang_luong as $key_nangluong => $value_nangluong)
                                        <option value="{{$value_nangluong->id}}">{{$value_nangluong->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Level nhận được</label>
                                <input type="number" class="form-control" name="level" value="0">
                            </div>
                            <div class="form-group col-4">
                                <label>Level lên được max</label>
                                <input type="number"  class="form-control" name="level_max" value="10">
                            </div>
                            <div class="form-group col-4">
                                <label>Tỷ lệ</label>
                                <input type="number" step="any" class="form-control" name="ty_le" >
                            </div>
                        </div>
                            <div class="form-group">
                                <label>Giới thiệu</label>
                                <textarea name="gioi_thieu" class="form-control" id="text-1" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    {{-- end thêm công pháp --}}
    {{ $cong_phap->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tỷ lệ</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Cộng hay nhân</th>
                    <th scope="col">Hệ</th>
                    <th scope="col">Năng lượng</th>
                    <th scope="col">Level nhận được</th>
                    <th scope="col">Level lên được max</th>
                    <th scope="col">Buff Exp</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cong_phap as $key => $value)
                    <?php
                        $he_name = HeModel::find($value->he_id)->ten_he;
                        $nang_luong_name = NangLuongModel::find($value->nangluong_id)->ten;
                    ?>
                    <tr>
                        <th scope="row">{{$value->id}}</th>
                        <td>{{$value->ten}}</td>
                        <td>{{$value->ty_le*100}}%</td>
                        <td>{{$value->dong_te}} đồng tệ, {{$value->ngan_te}} ngân tệ, {{$value->kim_te}} kim tệ, {{$value->me}} ME</td>
                        <td>@if($value->status == 0) Chưa bán @else Đang bán @endif</td>
                        <td>@if($value->buff == 0) Cộng @else Nhân @endif</td>
                        <td>{{$he_name}}</td>
                        <td>{{$nang_luong_name}}</td>
                        <td>{{$value->level}}</td>
                        <td>{{$value->level_max}}</td>
                        <td>{{$value->buff_exp}}%</td>
                        <td>{!!$value->gioi_thieu!!}</td>
                        <td><a href="#" class="btn btn-secondary mr-2" data-toggle="modal" data-target="#sua_{{$value->id}}">Sửa</a><a href="{{url('creator/item/cong-phap/xoa/'.$value->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')">Xoá</a></td>
                    </tr>
                        {{-- sửa công pháp --}}
                            <div class="modal fade" id="sua_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sửa công pháp: <h3>{{$value->ten}}</h3></h5>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/cong-phap/sua/'.$value->id)}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label>Tên</label>
                                                    <input type="text" class="form-control" name="ten" value="{{$value->ten}}">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Buff exp</label>
                                                    <input type="number" step="any" class="form-control" name="buff_exp" value="{{$value->buff_exp}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-3">
                                                    <label>Đồng tệ</label>
                                                    <input type="number" step="any" class="form-control" name="dong_te" value="{{$value->dong_te}}">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label>Ngân tệ</label>
                                                    <input type="number" step="any" class="form-control" name="ngan_te" value="{{$value->ngan_te}}">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label>Kim tệ</label>
                                                    <input type="number" step="any" class="form-control" name="kim_te" value="{{$value->kim_te}}">
                                                </div>
                                                <div class="form-group col-3">
                                                    <label>ME</label>
                                                    <input type="number" step="any" class="form-control" name="me" value="{{$value->me}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3 col-6">
                                                    <label>Trạng thái</label>
                                                        <select class="form-control" name="status">
                                                                <option value="0" @if($value->status == 0) selected @endif>Chưa bán</option>
                                                                <option value="1" @if($value->status == 1) selected @endif>Đang bán</option>
                                                        </select>
                                                </div>
                                                <div class="form-group col-md-3 col-6">
                                                    <label>Buff</label>
                                                        <select class="form-control" name="buff">
                                                                <option value="0" @if($value->buff ==0) selected @endif>Cộng</option>
                                                                <option value="1" @if($value->buff == 1) selected @endif>Nhân</option>
                                                        </select>
                                                </div>
                                                <div class="form-group col-md-3 col-6">
                                                    <label>Hệ</label>
                                                    <select class="form-control" name="he_id">
                                                        @foreach($he as $key_he => $value_he)
                                                            <option value="{{$value_he->id}}" @if($value->he_id == $value_he->id) selected @endif>{{$value_he->ten_he}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3 col-6">
                                                    <label>Năng lượng</label>
                                                    <select class="form-control" name="nangluong_id">
                                                        @foreach($nang_luong as $key_nangluong => $value_nangluong)
                                                            <option value="{{$value_nangluong->id}}" @if($value->nangluong_id == $value_nangluong->id) selected @endif>{{$value_nangluong->ten}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Level nhận được</label>
                                                    <input type="number" class="form-control" name="level" value="{{$value->level}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Level lên được max</label>
                                                    <input type="number"  class="form-control" name="level_max" value="{{$value->level_max}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Tỷ lệ</label>
                                                    <input type="number" step="any" class="form-control" name="ty_le" value="{{$value->ty_le}}">
                                                </div>
                                            </div>
                                                <div class="form-group">
                                                    <label>Giới thiệu</label>
                                                    <textarea name="gioi_thieu" class="form-control" rows="5">{!!$value->gioi_thieu!!}</textarea>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Sửa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- end sửa công pháp --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
