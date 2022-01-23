@extends('layouts.app')
@section('title', 'Cài đặt')
@section('content')
<?php
    use App\Models\Profile;
    $profile = Profile::find(Auth::user()->id);
?>
@if( isset($profile->bg_img) )
    <style>
        .bg{
            height: 100%;
            background-image: url("{{$profile->bg_img}}");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .bg::before{
            content: ' ';
            position: absolute;
            top: 0;
            width: 100%;
            height: 120%;
            background-color: rgba(94, 89, 89, 0.288);
        }
    </style>
    <script>
        function add_bg() {
            var element = document.getElementById("panel");
            element.classList.add("bg");
        }
        add_bg();
    </script>
@endif
    <div class="container mt-8">
        <div class="row">
            <div class="col-12">
                @if( empty(Auth::user()->ma_c2) )
                    <div class="card">
                        <div class="card-header">Tạo mã cấp 2</div>
                        <div class="card-body">
                            <form action="{{ url('trang-ca-nhan/tao-ma-cap-2') }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label>Mật khẩu</label>
                                        <input type="password" class="form-control" name="pwd">
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Mã cấp 2</label>
                                        <input type="password" class="form-control" name="ma_c2">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Tạo mã</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Đổi mã cấp 2</div>
                                <div class="card-body">
                                    <form action="{{ url('trang-ca-nhan/doi-ma-cap-2') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Mật khẩu</label>
                                                <input type="password" class="form-control" name="pwd">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Mã cấp 2 cũ</label>
                                                <input type="password" class="form-control" name="old">
                                            </div>
                                            <div class="form-group col-12">
                                                <label>Mã cấp 2 mới</label>
                                                <input type="password" class="form-control" name="new">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Đổi mã</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Đổi mật khẩu</div>
                                <div class="card-body">
                                    <form action="{{ url('trang-ca-nhan/doi-mat-khau') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Mật khẩu cũ</label>
                                                <input type="password" class="form-control" name="old">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Mật khẩu mới</label>
                                                <input type="password" class="form-control" name="new">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Đổi email</div>
                                <div class="card-body">
                                    <form action="{{ url('trang-ca-nhan/doi-email') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-6">
                                                <label>Mật khẩu</label>
                                                <input type="password" class="form-control" name="pwd">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Mã cấp 2</label>
                                                <input type="password" class="form-control" name="ma_c2">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Email cũ</label>
                                                <input type="email" class="form-control" name="email_old">
                                            </div>
                                            <div class="form-group col-6">
                                                <label>Email mới</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Đổi email mới</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">Chức năng thêm</div>
                                <div class="card-body">
                                    <a href="#!" class="btn btn-danger" data-toggle="modal" data-target="#xoa_tk">Xoá tài khoản</a>
                                    <a href="#!" class="btn btn-info" data-toggle="modal" data-target="#log_his">Lịch sử đăng nhập</a>
                                    <a href=" {{ url('trang-ca-nhan/quen-ma-cap-2') }} " class="btn btn-warning">Quên mã cấp 2</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="xoa_tk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Thông tin xác nhận</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('trang-ca-nhan/xoa-tai-khoan') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-4">
                                                <label>Mật khẩu</label>
                                                <input type="password" class="form-control" name="pwd">
                                            </div>
                                            <div class="form-group col-4">
                                                <label>Mã cấp 2</label>
                                                <input type="password" class="form-control" name="ma_c2">
                                            </div>
                                            <div class="form-group col-4">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá không?')">Xoá tài khoản</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="log_his" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Lịch sử đăng nhập</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive py-4">
                                        <table class="table table-flush" id="datatable-basic">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th>Thời gian</th>
                                                    <th>Địa chỉ</th>
                                                    <th>Thiết bị</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if( isset($log))
                                                    @foreach($log as $time => $value)
                                                        <tr>
                                                            <td>{{date("Y-m-d H:i:s", $time)}}</td>
                                                            <td>{{ $value['thanh_pho'].'-'.$value['nuoc'] }}</td>
                                                            <td>{{ $value['trinh_duyet'].' - '.$value['hdh'].' - '.$value['thiet_bi'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
