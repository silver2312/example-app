@extends('layouts.app')
@section('title', 'Creator đột phá')
@section('content')
<?php
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\NgheNghiepModel;
use App\Models\Game\ChiTiet\ChiTietNgheNghiepModel;
?>
<style>
    .table td, .table th{
        white-space:inherit;
    }
</style>
<div class="col-12 mt-2">
    <a href="#" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_vukhi">Thêm đột phá</a>
    {{-- Thêm đột phá --}}
    <div class="modal fade" id="them_vukhi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm đột phá</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/dot-pha/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group col-4">
                            <label>Level</label>
                            <input type="number" min="0" class="form-control" name="level" value="0">
                        </div>
                        <div class="form-group col-4">
                            <label>Trạng thái</label>
                            <select class="form-control" name="status">
                                <option value="0">Chưa bán</option>
                                <option value="1">Đang bán</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Đồng</label>
                            <input type="number" step="any" min="0" class="form-control" name="dong_te" value="0">
                        </div>
                        <div class="form-group col-4">
                            <label>Ngân</label>
                            <input type="number" step="any" min="0" class="form-control" name="ngan_te" value="0">
                        </div>
                        <div class="form-group col-4">
                            <label>Kim</label>
                            <input type="number" step="any" min="0" class="form-control" name="kim_te" value="0">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Nghề nghiệp</label>
                            <select class="form-control" name="nghenghiep_id">
                                @foreach($nghe_nghiep as $key_nghenghiep => $value_nghenghiep)
                                <option value="{{$value_nghenghiep->id}}">{{$value_nghenghiep->ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Nguyên liệu</label>
                            <select class="form-control" name="nguyenlieu_id">
                                @foreach($nguyen_lieu as $key_nguyenlieu => $value_nguyenlieu)
                                <option value="{{$value_nguyenlieu->id}}">{{$value_nguyenlieu->ten}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-4">
                            <label>Số lượng nguyên liệu</label>
                            <input type="number" min="1" class="form-control" name="so_luong" value="1">
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
    {{--  end Thêm đột phá --}}
    {{ $dot_pha->links('vendor.pagination.simple-default') }}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Nghề nghiệp</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Nguyên liệu ghép</th>
                    <th scope="col">Level</th>
                    <th scope="col">Giới thiệu</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dot_pha as $key =>$value)
                <?php
                $id_nghenghiep = NgheNghiepModel::find($value->nghenghiep_id);
                $id_nguyenlieu = NguyenLieuModel::find($value->nguyenlieu_id);
                ?>
                    <tr>
                        <td>{{$value->id}}</td>
                        <td>{{$value->ten}}</td>
                        <td>{{$id_nghenghiep->ten}}@if($value->nghenghiep_id !=5) / <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#them_lv_{{$value->id}}">
                        <?php
                        $chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$value->nghenghiep_id)->get();
                        try{
                            $id_chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$value->nghenghiep_id)->where('level',$value->level_nghenghiep)->first();
                            echo $id_chitiet_nghenghiep->ten;
                        }catch(Throwable $e){
                            echo "Chưa có";
                        }
                        ?>
                        </a>@endif</td>
                        <td>{{$value->dong_te}} đồng - {{$value->ngan_te}} ngân - {{$value->kim_te}} kim</td>
                        <td>@if($value->status == 0) chưa bán @else đang bán @endif</td>
                        <td>{{$id_nguyenlieu->ten}} / {{$value->so_luong}}</td>
                        <td>{{$value->level}}</td>
                        <td>{{$value->gioi_thieu}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/item/dot-pha/xoa/'.$value->id)}}">Xoá</a></td>
                    </tr>
                        @if($value->nghenghiep_id !=5)
                            {{-- thêm level nghề nghiệp --}}
                            <div class="modal fade" id="them_lv_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Thêm Level {{$id_nghenghiep->ten}}</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/dot-pha/them-level-nghe-nghiep/'.$value->id)}}">
                                            @csrf
                                            <div class="form-group">
                                                <label>Level nghề nghiệp</label>
                                                <select class="form-control" name="level_nghenghiep">
                                                    @foreach($chitiet_nghenghiep as $key_chitiet_nghenghiep => $value_chitiet_nghenghiep)
                                                        <option value="{{$value_chitiet_nghenghiep->level}}" @if($value->level_nghenghiep == $value_chitiet_nghenghiep->level) selected @endif>{{$value_chitiet_nghenghiep->ten}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- end thêm level nghề nghiệp --}}
                        @endif
                            {{-- Sửa đột phá --}}
                            <div class="modal fade" id="sua_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sửa đột phá</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype='multipart/form-data' method="POST" action="{{url('creator/item/dot-pha/sua/'.$value->id)}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Tên</label>
                                                    <input type="text" class="form-control" name="ten" value="{{$value->ten}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Level</label>
                                                    <input type="number" min="0" class="form-control" name="level" value="{{$value->level}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Trạng thái</label>
                                                    <select class="form-control" name="status">
                                                        <option value="0" @if($value->status == 0) selected @endif>Chưa bán</option>
                                                        <option value="1" @if($value->status == 1) selected @endif>Đang bán</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Đồng</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="dong_te" value="{{$value->dong_te}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Ngân</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="ngan_te" value="{{$value->ngan_te}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Kim</label>
                                                    <input type="number" step="any" min="0" class="form-control" name="kim_te" value="{{$value->kim_te}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Nghề nghiệp</label>
                                                    <select class="form-control" name="nghenghiep_id">
                                                        @foreach($nghe_nghiep as $key_nghenghiep => $value_nghenghiep)
                                                        <option value="{{$value_nghenghiep->id}}" @if($value->nghenghiep_id == $value_nghenghiep->id) selected @endif>{{$value_nghenghiep->ten}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Nguyên liệu</label>
                                                    <select class="form-control" name="nguyenlieu_id">
                                                        @foreach($nguyen_lieu as $key_nguyenlieu => $value_nguyenlieu)
                                                        <option value="{{$value_nguyenlieu->id}}" @if($value->nguyenlieu_id == $value_nguyenlieu->id) selected @endif>{{$value_nguyenlieu->ten}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Số lượng nguyên liệu</label>
                                                    <input type="number" min="1" class="form-control" name="so_luong" value="{{$value->so_luong}}">
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
                            {{--  end sửa đột phá --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
