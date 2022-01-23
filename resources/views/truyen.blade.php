@extends('layouts.app')
@section('title', 'Đọc truyện '.$truyen_sub->tieu_de)
@section('content')
<style>
    .bg_truyen{
        border-bottom:none;
        background-image: url({{check_link_img($truyen->img)}});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height:311px;
        position: absolute;
        width:100%;
        filter: blur(8px);
    }
</style>
<div class="container mt-5">
    <div class="row">
        {{-- thông tin truyện --}}
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header bg_truyen"></div>
                <div class="card-body" style="z-index: 10">
                    <img style="max-height:300px;"  src="{{$truyen->img }}" alt="{{$truyen_sub->tieu_de}}" class="pt-5" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" >
                    <p><h3 ><span style="text-transform: capitalize;">{{ $truyen_sub->tieu_de }} - {{ $truyen_sub->tac_gia }}</span></h3></p>
                    <p><a href="{{url('trang-ca-nhan/'.$user->id)}}">{{$user->name}}</a></p>
                    <p>Thể loại: </p>
                    <p>Tag: </p>
                    <p>{{$truyen->time_suf}} - {{$truyen->time_up}}</p>
                    <div class="row">
                        <div class="col-md-2 col-3">
                            <span ><i class="fas fa-thumbs-up"></i>&nbsp;{{ format_text($truyen->tong_like) }}</span>
                        </div>
                        <div class="col-md-2 col-3">
                            <span ><i class="fas fa-thumbs-down"></i>&nbsp;{{ format_text($truyen->dislike) }}</span>
                        </div>
                        <div class="col-md-2 col-3">
                            <span ><i class="fas fa-book"></i>&nbsp;{{ format_text($truyen->so_chuong) }}</span>
                        </div>
                        <div class="col-md-2 col-3">
                            <span ><i class="fas fa-star-half"></i>&nbsp;@if($truyen->trang_thai == 0)@else Tạm ngưng @endif</span>
                        </div>
                        <div class="col-md-2 col-3">
                            <span><i class="fas fa-bookmark"></i>&nbsp;{{ format_text($truyen->tu) }} </span>
                        </div>
                        <div class="col-md-2 col-3">
                            <span ><i class="fa fa-gift"></i>&nbsp;{{ format_text($truyen->gift) }} </span>
                        </div>
                    </div>
                    <p class="mt-2">{!! $truyen_sub->gioi_thieu !!}</p>
                </div>
            </div>
        </div>
        <div class="col-md-12 data">
            @include('custom.paginate_chapter')
        </div>
    </div>
</div>
@if(isset($data_chapter))
    @section('script_ll')
        <script>
            $(document).ready(function(){
                $(document).on('click', '.pagination li a', function(event){
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    fetch_data(page);
                });
                function fetch_data(page)
                {
                    $.ajax({
                        url:"{{$truyen->id}}/fetch_data?page="+page,
                        success:function(data)
                        {
                            $('.data').html(data);
                        }
                    });
                }
            });
        </script>
    @endsection
@endif
@endsection
