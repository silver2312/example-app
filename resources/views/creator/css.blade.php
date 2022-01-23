@extends('layouts.app')
@section('title', 'Creator css')
@section('content')

<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_he">Thêm css</a>
        {{-- Thêm css --}}
        <div class="modal fade" id="them_he" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm css</h5>
                    </div>
                    <div class="modal-body">
                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/css/them')}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Tên</label>
                                <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                            </div>
                            <div class="form-group col-6">
                                <label>Tên không dấu</label>
                                <input type="text" class="form-control" name="slug" value="{{old('slug')}}">
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{--  end Thêm css --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark" id="datatable-basic">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tên không dấu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($css as $key_css => $value_css)
                    <tr>
                        <th scope="row">{{$value_css->id}}</th>
                        <td class="{{$value_css->slug}} kieu_chu">{{$value_css->ten}}</td>
                        <td>{{$value_css->slug}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_css->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/css/xoa/'.$value_css->id)}}">Xoá</a></td>
                             {{-- sửa css --}}
                                <div class="modal fade" id="sua_{{$value_css->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Sửa css</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype='multipart/form-data' method="POST" action="{{url('creator/css/sua/'.$value_css->id)}}">
                                                @csrf
                                                <div class="form-row">
                                                    <div class="form-group col-6">
                                                        <label>Tên</label>
                                                        <input type="text" class="form-control" name="ten" value="{{$value_css->ten}}">
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label>Tên không dấu</label>
                                                        <input type="text" class="form-control" name="slug" value="{{$value_css->slug}}">
                                                    </div>
                                                </div>
                                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--  end sửa css --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
