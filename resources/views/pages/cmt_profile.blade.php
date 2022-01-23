<?php
use App\Models\User;
?>
<style>
    .media img {
    width: 60px;
    height: 60px
}

.reply a {
    text-decoration: none
}
</style>
<div class="col-md-12">
    <div class="card">
        <div class="card-header">Bình luận</div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-12">
                    <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/cmt/'.$user->id)}}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-12">
                                <textarea class="form-control" name="noi_dung" ></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Bình luận</button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($data_comment))
                                @foreach($data_comment as $key_cmt => $value_cmt)
                                    {{-- bình luận --}}
                                        <div class="media">
                                            <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="{{ check_img(($value_cmt['uid'])) }}" />
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-8 d-flex">
                                                        <a href="{{url('trang-ca-nhan/'.$value_cmt['uid'])}}" target="_blank"><h3>{{check_name($value_cmt['uid'])}}</h3></a> <span>- {{date("Y-m-d H:i:s", $key_cmt)}}</span>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="pull-right reply"> <a href="#!" data-toggle="modal" data-target="#rep_{{$key_cmt}}"><span><i class="fa fa-reply"></i> Trả lời</span></a> @if(Auth::check() && Auth::user()->id == $user->id)<a href="{{url('trang-ca-nhan/xoa-cmt/'.$key_cmt)}}" class="text-danger" onclick="return confirm('Bạn có chắc muốn xoá bình luận này không?')"><span><i class="ni ni-fat-remove"></i> Xoá bình luận</span></a>@endif</div>
                                                    </div>
                                                </div> {!!$value_cmt['noi_dung']!!}
                                                @include('pages.rep_profile')
                                                @if(isset($data_reply[$key_cmt]))
                                                    @foreach($data_reply[$key_cmt] as $key_reply => $value_reply)
                                                        {{-- trả lời --}}
                                                            <div class="media mt-4">
                                                                <a class="pr-3" href="#"><img class="rounded-circle" alt="Bootstrap Media Another Preview" src="{{check_img($value_reply['uid'])}}" /></a>
                                                                <div class="media-body">
                                                                    <div class="row">
                                                                        <div class="col-8 d-flex">
                                                                            <a href="{{url('trang-ca-nhan/'.$value_reply['uid'])}}" target="_blank"><h5>{{check_name($value_reply['uid'])}}</h5></a> <span>- {{date("Y-m-d H:i:s", $key_reply)}}</span>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="pull-right reply"> <a href="#!" data-toggle="modal" data-target="#rep_{{$key_cmt}}"><span><i class="fa fa-reply"></i> Trả lời</span></a> @if(Auth::check() && Auth::user()->id == $user->id)<a href="{{url('trang-ca-nhan/xoa-rep/'.$key_cmt.'/'.$key_reply)}}" class="text-danger" onclick="return confirm('Bạn có chắc muốn xoá trả lời này không?')"><span><i class="ni ni-fat-remove"></i> Xoá trả lời</span></a>@endif</div>
                                                                        </div>
                                                                    </div>{!!$value_reply['noi_dung']!!}
                                                                </div>
                                                            </div>
                                                        {{-- end trả lời --}}
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    {{-- end bình luận --}}
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
