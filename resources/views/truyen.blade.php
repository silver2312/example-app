@extends('layouts.app')
@section('title', 'Đọc truyện '.$truyen_sub->tieu_de)
@section('content')
<?php
use App\Models\Truyen\TheLoaiModel;
use App\Models\Truyen\TagModel;
?>
<style>
    .bg_truyen{
        border-bottom:none;
        background-image: url({{$truyen->img}});
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        height:311px;
        position: absolute;
        width:100%;
        filter: blur(8px);
    }
</style>
<?php
if(isset($truyen->link)){
    $url = get_url($truyen->nguon,$truyen->link);
}else{
    $url = "#!";
}
?>
<div class="container mt-5">
    <div class="row">
        {{-- thông tin truyện --}}
        <div class="col-md-12">
            <div class="card text-center">
                <div class="card-header bg_truyen"></div>
                <div class="card-body" style="z-index: 10">
                    <img style="height:325px;width:225px;"  src="{{$truyen->img }}" alt="{{$truyen_sub->tieu_de}}" class="pt-5" onerror="this.src='https://i.imgur.com/hQRlkUR.png';" >
                    <p><h3 ><span style="text-transform: capitalize;"><a href="{{$url}}" target="_blank">{{ $truyen_sub->tieu_de }}</a> - {{ $truyen_sub->tac_gia }}</span></h3></p>
                    <p><a href="{{url('trang-ca-nhan/'.$user->id)}}">{{$user->name}}</a></p>
                    <p>Thể loại:
                        <?php
                            $data_theloai = data_theloai($truyen->id);
                            try{
                                $count = count($data_theloai);
                            }catch(Throwable $e){
                                $count = 0;
                            }
                            if($count > 0){
                                foreach($data_theloai as $key_theloai =>$value_theloai){
                                    echo '<button class="btn btn-primary btn-sm" rel="tooltip" title=" '.TheLoaiModel::find($key_theloai)->gioi_thieu.' ">'.TheLoaiModel::find($key_theloai)->ten.'</button>';
                                }
                            }
                        ?>
                    </p>
                    <p>Tag:
                        <?php
                            $data_tag = data_tag($truyen->id);
                            try{
                                $countag = count($data_tag);
                            }catch(Throwable $e){
                                $countag = 0;
                            }
                            if($countag > 0){
                                foreach($data_tag as $key_tag =>$value_tag){
                                    echo '<button class="btn btn-primary btn-sm" rel="tooltip" title=" '.TagModel::find($key_tag)->gioi_thieu.' ">'.TagModel::find($key_tag)->ten.'</button>';
                                }
                            }
                        ?>
                    </p>
                    <p>{{$truyen->time_suf}} - {{$truyen->time_up}}</p>
                    @include('modal.modal_truyen')
                    <p class="mt-2 pl-4 pr-4" style="text-align: left;">{!! $truyen_sub->gioi_thieu !!}</p>
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
