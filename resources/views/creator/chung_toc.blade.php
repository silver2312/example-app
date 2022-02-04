@extends('layouts.app')
@section('title', 'Creator chủng tộc')
@section('content')
<?php
use App\Models\Game\NangLuongModel;
use App\Models\Game\TheChatModel;
?>
<div class="container mt-5">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_chung_toc">Thêm Chủng tộc</a>
    {{-- Thêm chung_toc --}}
    <div class="modal fade" id="them_chung_toc" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm Chủng tộc</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/chung-toc/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Tên chủng tộc</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group col-6">
                            <label>Tỷ lệ</label>
                            <input type="number" step="any" class="form-control" name="ty_le" value="{{old('ty_le')}}">
                        </div>
                    </div>
                        <div class="form-group">
                            <label>Năng lượng</label>
                            <br>
                            @foreach($nang_luong as $key => $nl)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="nangLuong[]" type="checkbox" value="{{$nl->id}}">
                                    <label class="form-check-label" >{{$nl->ten}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label>Thể chất</label>
                            <br>
                            @foreach($the_chat as $key => $tc)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="theChat[]" type="checkbox" value="{{$tc->id}}">
                                    <label class="form-check-label" >{{$tc->ten_the_chat}}</label>
                                </div>
                            @endforeach
                        </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Max lực</label>
                            <input type="number" step="any" class="form-control" name="max_luc" value="{{old('max_luc')}}">
                        </div>
                        <div class="form-group col-6">
                            <label>Max thọ nguyên</label>
                            <input type="number" class="form-control" name="max_thonguyen" value="{{old('max_thonguyen')}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label>Max trí</label>
                            <input type="number" step="any" class="form-control" name="max_tri" value="{{old('max_tri')}}">
                        </div>
                        <div class="form-group col-3">
                            <label>Max bền</label>
                            <input type="number col-3" step="any"  class="form-control" name="max_ben" value="{{old('max_ben')}}">
                        </div>
                        <div class="form-group col-3">
                            <label>Max mẫn</label>
                            <input type="number" step="any" class="form-control" name="max_man" value="{{old('max_man')}}">
                        </div>
                        <div class="form-group col-3">
                            <label>max tu luyện</label>
                            <input type="number" step="any" class="form-control" name="max_exp" value="{{old('max_exp')}}">
                        </div>
                    </div>
                        <div class="form-group">
                            <label>Giới thiệu</label>
                            <textarea name="gioi_thieu" class="form-control">{{old('gioi_thieu')}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="them_chung_toc">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm chung_toc --}}
    {{ $chung_toc->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tỷ lệ</th>
                    <th scope="col">Năng lượng</th>
                    <th scope="col">Thể chất</th>
                    <th scope="col">max lực</th>
                    <th scope="col">max trí</th>
                    <th scope="col">max bền</th>
                    <th scope="col">max mẫn</th>
                    <th scope="col">max tu luyện</th>
                    <th scope="col">max thọ nguyên</th>
                    <th scope="col">Update</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chung_toc as $key_chungtoc => $value_chungtoc)
                    <tr>
                        <th scope="row">{{$value_chungtoc->id}}</th>
                        <td><a href="#!" data-placement="bottom" rel="tooltip" data-html="true" title='{!!$value_chungtoc->gioi_thieu!!}'>{{$value_chungtoc->ten}}</a></td>
                        <td>{{$value_chungtoc->ty_le}}</td>
                        <td>
                            <?php
                                if(isset($data_chungtoc[$value_chungtoc->id])){
                                    $id_nangluong = [];
                                    foreach($data_chungtoc[$value_chungtoc->id]['nang_luong'] as $key_nl_c => $value_nl_c){
                                        $id_nangluong[] = $value_nl_c;
                                    }
                                    $nang_luong_ct = NangLuongModel::whereIn('id', $id_nangluong)->get();
                                    foreach($nang_luong_ct as $key_nl_ct => $value_nl_ct){
                                        echo '<span class="btn btn-sm btn-success mt-1">'.$value_nl_ct->ten.'</span>';
                                    }
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                                if(isset($data_chungtoc[$value_chungtoc->id])){
                                    $id_thechat = [];
                                    foreach($data_chungtoc[$value_chungtoc->id]['the_chat'] as $key_tc_c => $value_tc_c){
                                        $id_thechat[] = $value_tc_c;
                                    }
                                    $the_chat_ct = TheChatModel::whereIn('id', $id_thechat)->get();
                                    foreach($the_chat_ct as $key_tc_ct => $value_tc_ct){
                                        echo '<span class="btn btn-sm btn-success mt-1">'.$value_tc_ct->ten_the_chat.'</span>';
                                    }
                                }
                            ?>
                        </td>
                        <td>{{$value_chungtoc->max_luc}}</td>
                        <td>{{$value_chungtoc->max_tri}}</td>
                        <td>{{$value_chungtoc->max_ben}}</td>
                        <td>{{$value_chungtoc->max_man}}</td>
                        <td>{{$value_chungtoc->max_exp}}</td>
                        <td>{{$value_chungtoc->max_thonguyen}}</td>
                        <td>{{$value_chungtoc->update_at}}</td>
                        <td><a class="btn btn-info"href="#" data-toggle="modal" data-target="#sua_{{$value_chungtoc['id']}}">Sửa</a>&nbsp;<a onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" class="btn btn-danger" href="{{url('creator/chung-toc/xoa/'.$value_chungtoc->id)}}">Xoá</a></td>
                    </tr>
                        {{-- sửa chung_toc --}}
                        <div class="modal fade" id="sua_{{$value_chungtoc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Sửa Chủng tộc</h5>
                                    </div>
                                    <div class="modal-body">
                                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/chung-toc/sua/'.$value_chungtoc->id)}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Tên chủng tộc</label>
                                                <input type="text" class="form-control" name="ten" value="{{$value_chungtoc->ten}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Tỷ lệ</label>
                                                <input type="number" step="any" class="form-control" name="ty_le" value="{{$value_chungtoc->ty_le}}">
                                            </div>
                                        </div>
                                            <div class="form-group">
                                                <label>Năng lượng</label>
                                                <br>
                                                @foreach($nang_luong as $key => $nl)
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            @if(isset($data_chungtoc[$value_chungtoc->id])){
                                                                @foreach($id_nangluong as $key => $value_id_nl)
                                                                    @if($value_id_nl == $nl->id)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        class="form-check-input" name="nangLuong[]" type="checkbox" value="{{$nl->id}}">
                                                        <label class="form-check-label" >{{$nl->ten}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="form-group">
                                                <label>Thể chất</label>
                                                <br>
                                                @foreach($the_chat as $key => $tc)
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            @if(isset($data_chungtoc[$value_chungtoc->id])){
                                                                @foreach($id_thechat as $key => $value_id_tc)
                                                                    @if($value_id_tc == $tc->id)
                                                                        checked
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        class="form-check-input" name="theChat[]" type="checkbox" value="{{$tc->id}}">
                                                        <label class="form-check-label" >{{$tc->ten_the_chat}}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Max lực</label>
                                                <input type="number" step="any" class="form-control" name="max_luc" value="{{$value_chungtoc->max_luc}}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Max thọ nguyên</label>
                                                <input type="number" class="form-control" name="max_thonguyen" value="{{$value_chungtoc->max_thonguyen}}">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-3">
                                                <label>Max trí</label>
                                                <input type="number" step="any" class="form-control" name="max_tri" value="{{$value_chungtoc->max_tri}}">
                                            </div>
                                            <div class="form-group col-3">
                                                <label>Max bền</label>
                                                <input type="number" step="any"  class="form-control" name="max_ben" value="{{$value_chungtoc->max_ben}}">
                                            </div>
                                            <div class="form-group col-3">
                                                <label>Max mẫn</label>
                                                <input type="number" step="any" class="form-control" name="max_man" value="{{$value_chungtoc->max_man}}">
                                            </div>
                                            <div class="form-group col-3">
                                                <label>max tu luyện</label>
                                                <input type="number" step="any" class="form-control" name="max_exp" value="{{$value_chungtoc->max_exp}}">
                                            </div>
                                        </div>
                                            <div class="form-group">
                                                <label>Giới thiệu</label>
                                                <textarea  name="gioi_thieu" class="form-control">{{$value_chungtoc->gioi_thieu}}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="sua_chung_toc">Sửa</button>
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
    {{ $chung_toc->links('vendor.pagination.simple-default') }}
</div>
@endsection
