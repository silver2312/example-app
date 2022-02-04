@extends('layouts.app')
@section('title', 'Creator thể chất')
@section('content')
<?php
use App\Models\Game\HeModel;
?>
<div class="container mt-5">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_the_chat">Thêm thể chất</a>
    {{-- Thêm thể chất --}}
    <div class="modal fade" id="them_the_chat" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm thể chất</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/the-chat/them')}}">
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-6">
                                <label>Tên thể chất</label>
                                <input type="text" class="form-control" name="ten_the_chat" value="{{old('ten_the_chat')}}">
                            </div>
                            <div class="form-group col-6">
                                <label>Hệ</label>
                                <select class="form-control" name="he_id">
                                    @foreach($he as $key => $value)
                                        <option value="{{$value->id}}">{{$value->ten_he}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-2">
                                <label>Tỷ lệ</label>
                                <input type="text" class="form-control" name="ty_le" value="{{old('ty_le')}}">
                            </div>
                            <div class="form-group col-2">
                                <label>Lực</label>
                                <input type="number" step="any" class="form-control" name="buff_luc" value="{{old('buff_luc')}}">
                            </div>
                            <div class="form-group col-2">
                                <label>Bền</label>
                                <input type="number" step="any" class="form-control" name="buff_ben" value="{{old('buff_ben')}}">
                            </div>
                            <div class="form-group col-2">
                                <label>Trí</label>
                                <input type="number" step="any" class="form-control" name="buff_tri" value="{{old('buff_tri')}}">
                            </div>
                            <div class="form-group col-2">
                                <label>Mẫn</label>
                                <input type="number" step="any" class="form-control" name="buff_man" value="{{old('buff_man')}}">
                            </div>
                            <div class="form-group col-2">
                                <label>Hút exp</label>
                                <input type="number" step="any" class="form-control" name="buff_exp" value="{{old('buff_exp')}}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" name="them_the_chat">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm thể chất --}}

    {{ $the_chat->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tỷ lệ</th>
                    <th scope="col">Hệ</th>
                    <th scope="col">Thêm lực</th>
                    <th scope="col">Thêm bền</th>
                    <th scope="col">Thêm trí</th>
                    <th scope="col">Thêm mẫn</th>
                    <th scope="col">Thêm buff hút exp</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($the_chat as $key_thechat => $value_thechat)
                    <tr>
                        <th scope="row">{{$value_thechat->id}}</th>
                        <td>{{$value_thechat->ten_the_chat}}</td>
                        <td>{{$value_thechat->ty_le}}</td>
                        <td><?php $tenhe = HeModel::find($value_thechat->he_id); echo $tenhe->ten_he; ?></td>
                        <td>{{$value_thechat->buff_luc}}</td>
                        <td>{{$value_thechat->buff_ben}}</td>
                        <td>{{$value_thechat->buff_tri}}</td>
                        <td>{{$value_thechat->buff_man}}</td>
                        <td>{{$value_thechat->buff_exp}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_thechat->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/the-chat/xoa/'.$value_thechat->id)}}">Xoá</a></td>
                    </tr>
                    {{-- sửa thể chất --}}
                    <div class="modal fade" id="sua_{{$value_thechat->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa thể chất</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/the-chat/sua/'.$value_thechat->id)}}">
                                    @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Tên thể chất</label>
                                                <input type="text" class="form-control" name="ten_the_chat" value="{{$value_thechat->ten_the_chat}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Hệ</label>
                                                <select class="form-control" name="he_id">
                                                    @foreach($he as $key => $value)
                                                        <option value="{{$value->id}}" <?php if($value->id == $value_thechat->he_id){ echo "selected"; } ?>>{{$value->ten_he}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-2">
                                                <label>Tỷ lệ</label>
                                                <input type="text" class="form-control" name="ty_le" value="{{$value_thechat->ty_le}}">
                                            </div>
                                            <div class="form-group col-2">
                                                <label>Lực</label>
                                                <input type="number" step="any" class="form-control" name="buff_luc" value="{{$value_thechat->buff_luc}}">
                                            </div>
                                            <div class="form-group col-2">
                                                <label>Bền</label>
                                                <input type="number" step="any" class="form-control" name="buff_ben" value="{{$value_thechat->buff_ben}}">
                                            </div>
                                            <div class="form-group col-2">
                                                <label>Trí</label>
                                                <input type="number" step="any" class="form-control" name="buff_tri" value="{{$value_thechat->buff_tri}}">
                                            </div>
                                            <div class="form-group col-2">
                                                <label>Mẫn</label>
                                                <input type="number" step="any" class="form-control" name="buff_man" value="{{$value_thechat->buff_man}}">
                                            </div>
                                            <div class="form-group col-2">
                                                <label>Exp</label>
                                                <input type="number" step="any" class="form-control" name="buff_exp" value="{{$value_thechat->buff_exp}}">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="sua">Sửa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  end sửa thể chất --}}
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $the_chat->links('vendor.pagination.simple-default') }}
</div>

@endsection
