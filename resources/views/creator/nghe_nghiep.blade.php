@extends('layouts.app')
@section('title', 'Creator nghề nghiệp')
@section('content')
<?php
use App\Models\Game\NangLuongModel;
?>

<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_anh">Thêm Nghề Nghiệp</a>
    {{-- Thêm nghề nghiệp --}}
    <div class="modal fade" id="them_anh" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm Nghề Nghiêp</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nghe-nghiep/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group col-6">
                            <label>Năng lượng</label>
                            <select class="form-control" name="nangluong_id">
                                @foreach($nang_luong as $key_nangluong => $value_nangluong)
                                    <option value="{{$value_nangluong->id}}">{{$value_nangluong->ten}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm nghề nghiệp --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Chi tiết</th>
                    <th scope="col">Năng lượng</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nghe_nghiep as $key_nghenghiep => $value_nghenghiep)
                    <tr>
                        <th scope="row">{{$value_nghenghiep->id}}</th>
                        <td>{{$value_nghenghiep->ten}}</td>
                        <td><a href="{{url('creator/nghe-nghiep/chi-tiet/'.$value_nghenghiep->id)}}" class="btn btn-primary">Chi tiết</a></td>
                        <td><?php $id_nangluong =  NangLuongModel::find($value_nghenghiep->nangluong_id); ?>{{$id_nangluong->ten}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_nghenghiep->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/nghe-nghiep/xoa/'.$value_nghenghiep->id)}}">Xoá</a></td>
                    </tr>
                    {{-- Thêm nghề nghiệp --}}
                    <div class="modal fade" id="sua_{{$value_nghenghiep->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa Nghề Nghiêp</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nghe-nghiep/sua/'.$value_nghenghiep->id)}}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-6">
                                            <label>Tên</label>
                                            <input type="text" class="form-control" name="ten" value="{{$value_nghenghiep->ten}}">
                                        </div>
                                        <div class="form-group col-6">
                                            <label>Năng lượng</label>
                                            <select class="form-control" name="nangluong_id">
                                                @foreach($nang_luong as $key_nangluong => $value_nangluong)
                                                    <option value="{{$value_nangluong->id}}" @if($value_nangluong->id == $value_nghenghiep->nangluong_id) selected @endif>{{$value_nangluong->ten}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  end Thêm nghề nghiệp --}}

                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
