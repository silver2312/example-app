@extends('layouts.app')
@section('title', 'Creator chi tiết '.$nghe_nghiep->ten)
@section('content')

<div class="container mt-5">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_he">Thêm chi tiết</a>
    {{-- Thêm chi tiết --}}
    <div class="modal fade" id="them_he" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm chi tiết</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nghe-nghiep/chi-tiet/them/'.$nghe_nghiep->id)}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-3">
                            <label>Level</label>
                            <input type="number" class="form-control" name="level" value="{{$next_lv}}">
                        </div>
                        <div class="form-group col-3">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group col-3">
                            <label>exp</label>
                            <input type="number" step="any" class="form-control" name="exp" value="{{old('exp')}}">
                        </div>
                        <div class="form-group col-3">
                            <label>css</label>
                            <select class="form-control" name="css">
                                @foreach($css as $key => $value)
                                    <option value="{{$value->slug}}">{{$value->ten}}</option>
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
    {{--  end Thêm chi tiết --}}

    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">EXP</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chitiet_nghenghiep as $key_chitiet_nghenghiep => $value_chitiet_nghenghiep)
                    <tr>
                        <th scope="row">{{$value_chitiet_nghenghiep->level}}</th>
                        <td class="{{$value_chitiet_nghenghiep->css}}">{{$value_chitiet_nghenghiep->ten}}</td>
                        <td>{{$value_chitiet_nghenghiep->exp}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_chitiet_nghenghiep->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/nghe-nghiep/chi-tiet/xoa/'.$value_chitiet_nghenghiep->id)}}">Xoá</a></td>
                    </tr>
                    {{--  Sửa chi tiết --}}
                    <div class="modal fade" id="sua_{{$value_chitiet_nghenghiep->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Sửa chi tiết</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/nghe-nghiep/chi-tiet/sua/'.$value_chitiet_nghenghiep->id)}}">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-3">
                                            <label>Level</label>
                                            <input type="number" class="form-control" name="level" value="{{$value_chitiet_nghenghiep->level}}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label>Tên</label>
                                            <input type="text" class="form-control" name="ten" value="{{$value_chitiet_nghenghiep->ten}}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label>exp</label>
                                            <input type="number" step="any" class="form-control" name="exp" value="{{$value_chitiet_nghenghiep->exp}}">
                                        </div>
                                        <div class="form-group col-3">
                                            <label>css</label>
                                            <select class="form-control" name="css">
                                                @foreach($css as $key => $value)
                                                    <option value="{{$value->slug}}" @if($value->slug == $value_chitiet_nghenghiep->css) selected @endif>{{$value->ten}}</option>
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
                    {{--  end sửa chi tiết --}}

                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
