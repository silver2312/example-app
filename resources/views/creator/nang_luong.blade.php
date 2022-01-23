@extends('layouts.app')
@section('title', 'Creator năng lượng')
@section('content')
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_nang_luong">Thêm năng lượng</a>
    {{-- Thêm năng lượng --}}
    <div class="modal fade" id="them_nang_luong" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm năng lượng</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nang-luong/them')}}">
                    @csrf
                        <div class="form-group">
                            <label>Tên năng lượng</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group">
                            <label>Giới thiệu</label><br>
                            <textarea class="form-control" name="gioi_thieu">{{old('gioi_thieu')}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="them_nang_luong">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm năng lượng --}}
    {{ $nang_luong->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Chi tiết</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nang_luong as $key_nangluong =>$value_nangluong)
                    <tr>
                        <th scope="row">{{$value_nangluong->id}}</th>
                        <td>{{$value_nangluong->ten}}</td>
                        <td><a href="{{url('creator/nang-luong/chi-tiet/'.$value_nangluong->id)}}" class="btn btn-primary">Chi tiết</a></td>
                        <td>{!!$value_nangluong->gioi_thieu!!}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_nangluong['id']}}">Sửa</a>&nbsp;<a onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" class="btn btn-danger" href="{{url('creator/nang-luong/xoa/'.$value_nangluong['id'])}}">Xoá</a></td>
                        {{-- Sửa năng lượng --}}
                    <div class="modal fade" id="sua_{{$value_nangluong['id']}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa năng lượng</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nang-luong/sua/'.$value_nangluong['id'])}}">
                                    @csrf
                                        <div class="form-group">
                                            <label>Tên</label>
                                            <input type="text" class="form-control" name="ten" value="{{$value_nangluong['ten']}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Giới thiệu</label><br>
                                            <textarea class="form-control" name="gioi_thieu">{!!$value_nangluong['gioi_thieu']!!}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="sua_nang_luong">Sửa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end Sửa năng lượng --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
