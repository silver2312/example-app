@extends('layouts.app')
@section('title', 'Creator hệ')
@section('content')
<?php
use App\Models\Game\HeModel;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="container mt-5">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_he">Thêm hệ</a>
    {{-- Thêm hệ --}}
    <div class="modal fade" id="them_he" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm hệ</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/he/them')}}">
                    @csrf
                        <div class="form-group">
                            <label>Tên hệ</label>
                            <input type="text" class="form-control" name="ten_he" value="{{old('ten_he')}}">
                        </div>
                        <div class="form-group">
                            <label>Khắc chế : </label>
                            <br>
                            @foreach($he as $key_kt => $value_he_kt)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="He[]" type="checkbox" value="{{$value_he_kt->id}}">
                                    <label class="form-check-label" >{{$value_he_kt->ten_he}}</label>
                                </div>
                            @endforeach
                        </div>
                        <button type="submit" class="btn btn-primary" name="them_he">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm hệ --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark" id="datatable-basic">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Khắc chế</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($he as $key_he => $value_he)
                    <tr>
                        <th scope="row">{{$value_he->id}}</th>
                        <td>{{$value_he->ten_he}}</td>
                        <td>
                            <?php
                                if(isset($data_he[$value_he->id])){
                                    $id_he = [];
                                    foreach($data_he[$value_he->id]['khac_che'] as $key_khac_che => $value_khac_che){
                                        $id_he[] = $value_khac_che;
                                    }
                                    $khac_che = HeModel::whereIn('id', $id_he)->get();
                                    foreach($khac_che as $key_khacche => $value_khacche){
                                        echo '<span class="badge badge-dark p-1">'.$value_khacche->ten_he.'</span>';
                                    }
                                }
                            ?>
                        </td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_he_{{$value_he->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/he/xoa/'.$value_he->id)}}">Xoá</a></td>
                    </tr>
                    {{-- sửa hệ --}}
                    <div class="modal fade" id="sua_he_{{$value_he->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa hệ</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/he/sua/'.$value_he->id)}}">
                                    @csrf
                                        <div class="form-group">
                                            <label>Tên hệ</label>
                                            <input type="text" class="form-control" name="ten_he" value="{{$value_he->ten_he}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Khắc chế : </label>
                                            @php
                                                $new_he = HeModel::where('id','!=',$value_he->id)->get();
                                            @endphp
                                            <br>
                                            @foreach($new_he as $key_new => $value_new)
                                                <div class="form-check form-check-inline">
                                                    <input
                                                        @if(isset($data_he[$value_he->id])){
                                                            @foreach($id_he as $key => $value_id_he)
                                                                @if($value_id_he == $value_new->id)
                                                                    checked
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    class="form-check-input" name="He[]" type="checkbox" value="{{$value_new->id}}">
                                                    <label class="form-check-label" >{{$value_new->ten_he}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="sua_he">Sửa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  end sửa hệ --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
