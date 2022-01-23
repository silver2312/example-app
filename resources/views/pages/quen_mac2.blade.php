@extends('layouts.app')
@section('title', 'Đổi mã cấp 2')
@section('content')
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
    <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
            <div class="card bg-secondary shadow border-0">
                <div class="card-header px-lg-5" style="color:red;">Một email có mã xác nhận đã được gửi đến email của bạn vui lòng kiểm tra.</div>
                <div class="card-body px-lg-5 py-lg-5">
                    <form role="form" method="POST" action="{{url('trang-ca-nhan/xac-nhan-ma')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                </div>
                                <input class="form-control" maxlength="10" placeholder="Mã xác nhận" type="text" name="ma_xn" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                </div>
                                <input class="form-control" maxlength="10" name="ma_c2" placeholder="Mã cấp 2 mới" type="password"  required>
                            </div>
                        </div>
                            <button type="submit" class="btn btn-primary my-4">Xác nhận</button>
                            <a type="button" class="btn btn-info my-4" href="{{ url('trang-ca-nhan/gui-lai-ma') }}">Gửi lại mã</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
