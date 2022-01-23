@extends('layouts.app')
@section('title', 'Creator vạn năng')
@section('content')

<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_thienkiep">Thêm vạn năng</a>
    {{-- Thêm vạn năng --}}
    <div class="modal fade" id="them_thienkiep" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm vạn năng</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/van-nang/them')}}">
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Tên</label>
                                <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                            </div>
                            <div class="form-group col-6">
                                <label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="0">Chưa bán</option>
                                    <option value="1">Đang bán</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label>Đồng tệ</label>
                                <input type="number" step="any" min="0" class="form-control" name="dong_te" value="0">
                            </div>
                            <div class="form-group col-4">
                                <label>Ngân tệ</label>
                                <input type="number" step="any" min="0" class="form-control" name="ngan_te" value="0">
                            </div>
                            <div class="form-group col-4">
                                <label>Kim tệ</label>
                                <input type="number" step="any" min="0" class="form-control" name="kim_te" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Giới thiệu</label>
                            <textarea class="form-control" name="gioi_thieu"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm vạn năng --}}
    {{ $item_vannang->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($item_vannang as $key => $value)
                    <tr>
                        <th scope="row">{{$value->id}}</th>
                        <td>{{$value->ten}}</td>
                        <td>{{$value->dong_te}} đồng - {{$value->ngan_te}} ngân - {{$value->kim_te}} kim</td>
                        <td>@if($value->status == 0) Chưa bán @else Đang bán @endif</td>
                        <td>{{$value->gioi_thieu}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/item/van-nang/xoa/'.$value->id)}}">Xoá</a></td>
                    </tr>
                                {{-- sửa vạn năng --}}
                        <div class="modal fade" id="sua_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa vạn năng</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/van-nang/sua/'.$value->id)}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Tên</label>
                                                <input type="text" class="form-control" name="ten" value="{{$value->ten}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Trạng thái</label>
                                                <select class="form-control" name="status">
                                                    <option value="0" @if($value->status ==0) selected @endif>Chưa bán</option>
                                                    <option value="1" @if($value->status ==1) selected @endif>Đang bán</option>
                                                </select>
                                            </div>
                                        </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Đồng tệ</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="dong_te" value="{{$value->dong_te}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Ngân tệ</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="ngan_te" value="{{$value->ngan_te}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Kim tệ</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="kim_te" value="{{$value->kim_te}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Giới thiệu</label>
                                                <textarea class="form-control" name="gioi_thieu">{{$value->gioi_thieu}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Sửa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  end sửa vạn năng --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
