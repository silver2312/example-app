@extends('layouts.app')
@section('title', 'Creator chi tiết '.$nang_luong->ten)
@section('content')
<?php
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\ThienKiepModel;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_chi_tiet_nang_luong">Thêm chi tiết năng lượng</a>
    {{-- Thêm chi tiết năng lượng --}}
    <div class="modal fade" id="them_chi_tiet_nang_luong" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết năng lượng</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nang-luong/chi-tiet/them/'.$nang_luong->id)}}">
                    @csrf
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label>Tên cấp độ</label>
                                <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Level</label>
                                <input type="number" class="form-control" name="level" value="{{$next_lv}}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label>Exp</label>
                                <input type="number" step="any" class="form-control" name="exp" value="1">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Thọ nguyên</label>
                                <input type="number" step="any" class="form-control" name="tho_nguyen" value="-1">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Css</label>
                                <select class="form-control" name="css">
                                    @foreach($css as $key => $value)
                                    <option value="{{$value->slug}}">{{$value->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Độ kiếp</label>
                                <select class="form-control" name="do_kiep">
                                    @foreach($thien_kiep as $key => $value)
                                    <option value="{{$value->id}}">{{$value->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label>Buff lực</label>
                                <input type="number" step="any" class="form-control" name="buff_luc" value="1000">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Buff trí</label>
                                <input type="number" step="any"  class="form-control" name="buff_tri" value="1000">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Buff bền</label>
                                <input type="number" step="any"  class="form-control" name="buff_ben" value="1000">
                            </div>
                            <div class="form-group col-md-3">
                                <label>Buff mẫn</label>
                                <input type="number" step="any" class="form-control" name="buff_man" value="1000">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tốc độ tu luyện</label>
                            <input type="number" step="any" class="form-control" name="hut_exp" value="1000">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Item phụ trợ</label>
                                <select class="form-control" name="phu_tro">
                                    @foreach($dot_pha as $key => $value)
                                    <option value="{{$value->id}}">{{$value->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Số lượng item phụ trợ</label>
                                <input type="number" class="form-control" name="so_luong" value="0">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end thêm chi tiết năng lượng --}}

    {{ $chitiet_nangluong->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Buff Lực - Trí - Bền - Mẫn</th>
                    <th scope="col">Exp</th>
                    <th scope="col">Hút exp</th>
                    <th scope="col">Phụ trợ</th>
                    <th scope="col">Độ kiếp</th>
                    <th scope="col">Thọ nguyên</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chitiet_nangluong as $key_chitiet =>$value_chitiet)
                    <?php
                    $id_dokiep = ThienKiepModel::find($value_chitiet->do_kiep);
                    $id_phutro = DotPhaModel::find($value_chitiet->phu_tro);
                    ?>
                    <tr>
                        <th scope="row">{{$value_chitiet->level}}</th>
                        <td class="{{$value_chitiet->css}} kieu_chu">{{$value_chitiet->ten}}</td>
                        <td>{{$value_chitiet->buff_luc}} - {{$value_chitiet->buff_tri}} - {{$value_chitiet->buff_ben}} - {{$value_chitiet->buff_man}}</td>
                        <td>{{$value_chitiet->exp}}</td>
                        <td>{{$value_chitiet->hut_exp}}</td>
                        <td>{{$id_phutro->ten}} / {{$value_chitiet->so_luong}}</td>
                        <td>{{$id_dokiep->ten}}</td>
                        <td>{{$value_chitiet->tho_nguyen}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_chitiet->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/nang-luong/chi-tiet/xoa/'.$value_chitiet->id)}}">Xoá</a></td>
                    </tr>
                                {{-- sửa chi tiết năng lượng --}}
                                <div class="modal fade" id="sua_{{$value_chitiet->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết năng lượng</h5>
                                            </div>
                                            <div class="modal-body">
                                                <form enctype='multipart/form-data' method="POST" action="{{url('creator/nang-luong/chi-tiet/sua/'.$value_chitiet->id)}}">
                                                @csrf
                                                    <div class="form-row">
                                                        <div class="form-group col-5">
                                                            <label>Tên cấp độ</label>
                                                            <input type="text" class="form-control" name="ten" value="{{$value_chitiet->ten}}">
                                                        </div>
                                                        <div class="form-group col-2">
                                                            <label>Level</label>
                                                            <input type="number" class="form-control" name="level" value="{{$value_chitiet->level}}" readonly>
                                                        </div>
                                                        <div class="form-group col-2">
                                                            <label>Exp</label>
                                                            <input type="number" step="any" class="form-control" name="exp" value="{{$value_chitiet->exp}}">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <label>Thọ nguyên</label>
                                                            <input type="number" step="any" class="form-control" name="tho_nguyen" value="{{$value_chitiet->tho_nguyen}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-6">
                                                            <label>Css</label>
                                                            <select class="form-control" name="css">
                                                                @foreach($css as $key => $value)
                                                                <option value="{{$value->slug}}" @if($value_chitiet->css == $value->slug) selected @endif>{{$value->ten}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label>Độ kiếp</label>
                                                            <select class="form-control" name="do_kiep">
                                                                @foreach($thien_kiep as $key => $value)
                                                                <option value="{{$value->id}}" @if($value_chitiet->do_kiep == $value->id) selected @endif>{{$value->ten}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-3">
                                                            <label>Buff lực</label>
                                                            <input type="number" step="any" min="1" class="form-control" name="buff_luc" value="{{$value_chitiet->buff_luc}}">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <label>Buff trí</label>
                                                            <input type="number" step="any" min="1"  class="form-control" name="buff_tri" value="{{$value_chitiet->buff_tri}}">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <label>Buff bền</label>
                                                            <input type="number" step="any" min="1"  class="form-control" name="buff_ben" value="{{$value_chitiet->buff_ben}}">
                                                        </div>
                                                        <div class="form-group col-3">
                                                            <label>Buff mẫn</label>
                                                            <input type="number" step="any" min="1" class="form-control" name="buff_man" value="{{$value_chitiet->buff_man}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tốc độ tu luyện</label>
                                                        <input type="number" step="any" min="1" class="form-control" name="hut_exp" value="{{$value_chitiet->hut_exp}}">
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-6">
                                                            <label>Item phụ trợ</label>
                                                            <select class="form-control" name="phu_tro">
                                                                @foreach($dot_pha as $key => $value)
                                                                <option value="{{$value->id}}" @if($value_chitiet->phu_tro == $value->id) selected @endif>{{$value->ten}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <label>Số lượng item phụ trợ</label>
                                                            <input type="number" class="form-control" name="so_luong" value="{{$value_chitiet->so_luong}}">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Sửa</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- end sửa chi tiết năng lượng --}}

                @endforeach
            </tbody>
        </table>
    </div>
    {{ $chitiet_nangluong->links('vendor.pagination.simple-default') }}
</div>
@endsection
