@extends('layouts.app')
@section('title', 'Creator vũ khí')
@section('content')

<div class="col-12 mt-2">
    <a href="#!" class="btn btn-primary" style="margin-left:20px;margin-bottom:20px;" data-toggle="modal" data-target="#them_vukhi">Thêm vũ khí</a>
    {{-- Thêm vũ khí --}}
    <div class="modal fade" id="them_vukhi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Thêm vũ khí</h5>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/vu-khi/them')}}">
                    @csrf
                        <div class="form-group">
                            <label>Tên vũ khí</label>
                            <input type="text" class="form-control" name="ten" value="{{old('ten')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--  end Thêm vũ khí --}}
    <div class="table-responsive">
        <table class="table table-flush table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Cài đặt</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vu_khi as $key_vukhi => $value_vukhi)
                    <tr>
                        <th scope="row">{{$value_vukhi->id}}</th>
                        <td>{{$value_vukhi->ten}}</td>
                        <td><a class="btn btn-info" href="#" data-toggle="modal" data-target="#sua_{{$value_vukhi->id}}">Sửa</a>&nbsp;<a class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')" href="{{url('creator/vu-khi/xoa/'.$value_vukhi->id)}}">Xoá</a></td>
                    </tr>
                    {{-- sửa vũ khí --}}
                    <div class="modal fade" id="sua_{{$value_vukhi->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Thêm vũ khí</h5>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{url('creator/vu-khi/sua/'.$value_vukhi->id)}}">
                                    @csrf
                                        <div class="form-group">
                                            <label>Tên vũ khí</label>
                                            <input type="text" class="form-control" name="ten" value="{{$value_vukhi->ten}}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--  end sửa vũ khí --}}
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
