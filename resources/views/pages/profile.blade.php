@extends('layouts.app')
@section('title', 'Trang cá nhân của '.$user->name)
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
<div class="container">
    <div class="header pb-8 align-items-center" style="min-height: 150px; background: transparent;">
        @if( isset($profile->link_nhac) )
            <audio controls loop class="form-control col-md-6" id="volum_audio" style="opacity:0;" controlsList="nodownload">
                <source src="{{$profile->link_nhac}}" type="audio/mpeg">
            </audio>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card khong_mau">
                <div class="card-profile-image">
                    @if(isset($uid) && $user->level <= 4 && $user->ngan_te >= 1000)
                        <a href="#!">
                            <img src="{{ check_img($user->id) }}" style="box-shadow: 0 0 12px grey;" class="img-thumbnail" data-toggle="modal" data-target="#edit_avt">
                        </a>
                    @else
                        <img src="{{ check_img($user->id) }}" style="box-shadow: 0 0 12px grey;" class="img-thumbnail">
                    @endif
                </div>
                <div class="card-body pt-6">
                    @if(isset($uid) && $user->level <= 4 && $user->ngan_te >= 1000)
                        <div class="text-center">
                            <div class="d-flex justify-content-between">
                                <a href="#!" class="btn btn-sm btn-info" rel="tooltip" data-html="true" title="Đổi nhạc nền" data-toggle="modal" data-target="#edit_nhac"><i class=" ni ni-sound-wave"></i></a>
                                <a href="#!" class="btn btn-sm btn-success float-right" rel="tooltip" data-html="true" title="Đổi ảnh bìa" data-toggle="modal" data-target="#edit_anh_bia"><i class=" ni ni-image"></i></a>
                            </div>
                        </div>
                        @include('custom.modal_vip')
                    @endif
                    <div class="text-center">
                        @if(isset($uid) && $user->level <= 4 && $user->ngan_te >= 1000)
                            <a href="#!" data-toggle="modal" data-target="#edit_name"><h5 class="h3 mt-5 kieu_chu {{check_level($user->id)}}" >{{$user->name}}</h5></a>
                        @else
                            <h5 class="h3 mt-5 kieu_chu {{check_level($user->id)}}">{{$user->name}}</h5>
                        @endif
                        <span class="heading">{{ get_level($user->level,$user->id) }}</span>
                    </div>
                    <div class="card-profile-stats d-flex justify-content-center">
                        <div>
                            @if( isset($profile->ten_nhac) )
                                <span><marquee style="width:70%;">{{$profile->ten_nhac}}</marquee><br></span>
                            @endif
                            <a href="#!" class="btn btn-sm btn-info" onclick="playVid()" ><i class="ni ni-button-play"></i></a><a href="#!" class="btn btn-sm btn-danger" onclick="pauvid()" ><i class="ni ni-button-pause"></i></a><br>
                            <span class="h4">
                                @if( isset($profile->gioi_thieu) )
                                    {!! $profile->gioi_thieu !!}
                                @endif
                                @if( isset($uid) )
                                    &nbsp;<a href="#!" rel="tooltip" data-html="true" title="Đổi giới thiệu" data-toggle="modal" data-target="#edit_gt"><i class=" ni ni-badge"></i></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="edit_gt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Đổi giới thiệu</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/doi-thong-tin')}}">
                                                        @csrf
                                                        <div class="form-group ">
                                                            <label for="">Mã cấp 2</label>
                                                            <input type="password" class="form-control" name="ma_c2" maxlength="10">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="">Nhập giới thiệu</label>
                                                            <textarea type="text" maxlength="255" class="form-control" name="gioi_thieu">
                                                                @if( isset($profile->gioi_thieu) )
                                                                    {{ $profile->gioi_thieu }}
                                                                @endif</textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Sửa</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Progress track -->
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="progress-wrapper col-12">
                            <div class="progress-info">
                                <div class="progress-label">
                                    <div>Exp: <span>Task completed</span></div>
                                </div>
                                <div class="progress-percentage">
                                        <span>60%</span>
                                </div>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-default" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @include('tu_luyen.index')
    </div>

    <div class="row">
        @include('pages.cmt_profile')
    </div>

</div>
<script>
    var audio = document.getElementById("volum_audio");
    function playVid() {
        audio.play();
    }
    function pauvid() {
        audio.pause();
    }
</script>
@endsection
