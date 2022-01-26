@extends('layouts.app')
@section('title', 'Quản lý thể loại truyện')
@section('content')


<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_the_loai">Thêm thể loại mới</a>
    {{-- Thêm chung_toc --}}
    <div class="modal fade" id="them_the_loai" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm thể loại</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('mod/the-loai/them')}}" autocomplete="off">
                    @csrf
                        <div class="form-group">
                            <label>Tên</label>
                            <input type="text" maxlength="30" name="ten" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Giới thiệu</label>
                            <textarea  name="gioi_thieu" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm chung_toc --}}
    {{ $the_loai->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($the_loai as $key => $value)
                    <tr>
                        <th scope="row">{{$value->id}}</th>
                        <td><a href="#!" >{{$value->ten}}</a></td>
                        <td>{!!$value->gioi_thieu!!}</td>
                        <td><a class="btn btn-info"href="#" data-toggle="modal" data-target="#sua_{{$value->id}}">Sửa</a></td>
                    </tr>
                        {{-- sửa chung_toc --}}
                        <div class="modal fade" id="sua_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa thể loại: {{$value->ten}}</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype='multipart/form-data' method="POST" action="{{url('mod/the-loai/sua/'.$value->id)}}" autocomplete="off">
                                            @csrf
                                            <div class="form-group">
                                                <label>Tên</label>
                                                <input type="text" maxlength="30" name="ten" class="form-control" value="{{$value->ten}}">
                                            </div>
                                            <div class="form-group">
                                                <label>Giới thiệu</label>
                                                <textarea  name="gioi_thieu" class="form-control">{!! $value->gioi_thieu !!}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Sửa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  end sửa chung_toc --}}
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $the_loai->links('vendor.pagination.simple-default') }}
</div>
@endsection
