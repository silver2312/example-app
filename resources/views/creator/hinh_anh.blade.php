@extends('layouts.app')
@section('title', 'Creator hình ảnh')
@section('content')

<div class="container mt-5">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_anh">Thêm Ảnh</a>
    {{-- Thêm ảnh --}}
    <div class="modal fade" id="them_anh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm ảnh</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/hinh-anh/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Link ảnh</label>
                            <input type="text" class="form-control" name="link_img" value="{{old('link_img')}}">
                        </div>
                        <div class="form-group col-6">
                            <label>Giới tính</label>
                            <select class="form-control" name="gioi_tinh">
                                <option value="0">Nam</option>
                                <option value="1">Nữ</option>
                            </select>
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm ảnh --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark" id="datatable-basic">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Giới tính</th>
                    <th scope="col">Ảnh</th>
                    <th scope="col">Link</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hinh_anh as $key_hinhanh => $value_hinhanh)
                    <tr>
                        <th scope="row">{{$value_hinhanh->id}}</th>
                        <td>@if( $value_hinhanh->gioi_tinh == 0 ) Nam @else Nữ @endif</td>
                        <td><img id="phongto" src="{{$value_hinhanh->link_img}}" width="80" class="img-responsive" ></td>
                        <td>{{$value_hinhanh->link_img}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_hinhanh->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/hinh-anh/xoa/'.$value_hinhanh->id)}}">Xoá</a></td>
                    </tr>
                         {{-- Sửa ảnh --}}
                        <div class="modal fade" id="sua_{{$value_hinhanh->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa ảnh</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/hinh-anh/sua/'.$value_hinhanh->id)}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Link ảnh</label>
                                                <input type="text" class="form-control" name="link_img" value="{{$value_hinhanh->link_img}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Giới tính</label>
                                                <select class="form-control" name="gioi_tinh">
                                                    <option value="0" @if($value_hinhanh->gioi_tinh == 0) selected @endif>Nam</option>
                                                    <option value="1" @if($value_hinhanh->gioi_tinh == 1) selected @endif>Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                            <button type="submit" class="btn btn-primary">Sửa</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--  end Thêm ảnh --}}

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
