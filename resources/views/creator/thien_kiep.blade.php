@extends('layouts.app')
@section('title', 'Creator thiên kiếp')
@section('content')

<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_thienkiep">Thêm thiên kiếp</a>
    {{-- Thêm thiên kiếp --}}
    <div class="modal fade" id="them_thienkiep" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm thiên kiếp</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/thien-kiep/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-6">
                            <label>Tên</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <div class="form-group col-6">
                            <label>Thành công</label>
                            <input type="number" step="any" class="form-control" name="thanh_cong" value="{{old('thanh_cong')}}">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-4">
                            <label>Tiểu thương</label>
                            <input type="number" step="any" class="form-control" name="tieu_thuong" value="{{old('tieu_thuong')}}">
                        </div>
                        <div class="form-group col-4">
                            <label>Trọng thương</label>
                            <input type="number" step="any" class="form-control" name="trong_thuong" value="{{old('trong_thuong')}}">
                        </div>
                        <div class="form-group col-4">
                            <label>Tử vong</label>
                            <input type="number" step="any" class="form-control" name="chet" value="{{old('chet')}}">
                        </div>
                    </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm thiên kiếp --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Tỷ lệ thành công</th>
                    <th scope="col">Tiểu thương</th>
                    <th scope="col">Trọng thương</th>
                    <th scope="col">Tử vong</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($thien_kiep as $key_thienkiep => $value_thienkiep)
                    <tr>
                        <th scope="row">{{$value_thienkiep->id}}</th>
                        <td>{{$value_thienkiep->ten}}</td>
                        <td>{{$value_thienkiep->thanh_cong*100}}%</td>
                        <td>{{$value_thienkiep->tieu_thuong*100}}%</td>
                        <td>{{$value_thienkiep->trong_thuong*100}}%</td>
                        <td>{{$value_thienkiep->chet*100}}%</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_thienkiep->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/thien-kiep/xoa/'.$value_thienkiep->id)}}">Xoá</a></td>
                    </tr>
                            {{-- sửa thiên kiếp --}}
                            <div class="modal fade" id="sua_{{$value_thienkiep->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Sửa thiên kiếp</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype='multipart/form-data' method="POST" action="{{url('creator/thien-kiep/sua/'.$value_thienkiep->id)}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label>Tên</label>
                                                    <input type="text" class="form-control" name="ten" value="{{$value_thienkiep->ten}}">
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Thành công</label>
                                                    <input type="number" step="any" class="form-control" name="thanh_cong" value="{{$value_thienkiep->thanh_cong}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-4">
                                                    <label>Tiểu thương</label>
                                                    <input type="number" step="any" class="form-control" name="tieu_thuong" value="{{$value_thienkiep->tieu_thuong}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Trọng thương</label>
                                                    <input type="number" step="any" class="form-control" name="trong_thuong" value="{{$value_thienkiep->trong_thuong}}">
                                                </div>
                                                <div class="form-group col-4">
                                                    <label>Tử vong</label>
                                                    <input type="number" step="any" class="form-control" name="chet" value="{{$value_thienkiep->chet}}">
                                                </div>
                                            </div>
                                                <button type="submit" class="btn btn-primary">Sửa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--  end sửa thiên kiếp --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
