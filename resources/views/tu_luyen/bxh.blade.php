@extends('layouts.app')
@section('title', 'Bảng xếp hạng tu luyện')

@section('content')
<?php
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use App\Models\Game\ChungTocModel;
use App\Models\Game\TheChatModel;
use App\Models\Game\HeModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\VuKhiModel;
?>

<div class="container">
    @foreach($user as $key => $value)
        <?php
            $data_nhanvat = data_nhanvat($value->id);
            $data_thongtin = data_thongtin($value->id);
        ?>
        @if(isset($data_nhanvat[0]) && isset($data_thongtin[0]))
            <?php
                if($data_thongtin[0]['level'] <= 100){
                    $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',$data_thongtin[0]['level'])->first();
                }else{
                    $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',100)->first();
                }
                $chung_toc = ChungTocModel::find($data_nhanvat[0]['chung_toc_id']);
                $the_chat= TheChatModel::find($data_nhanvat[0]['the_chat_id']);
                $he_hientai = HeModel::find($the_chat->he_id)->ten_he;
                $nang_luong = NangLuongModel::find($data_nhanvat[0]['nangluong_id']);
            ?>
            <div class="row mt-2">
                <div class="card col-md-4 mr-2 p-2 mt-2">
                    <center>
                        <img src="{{$data_nhanvat[0]['link_img']}}" id="phongto" width="180">
                        <h3 ><a href="{{url('trang-ca-nhan/'.$value->id)}}" class="kieu_chu {{$chi_tiet->css}}">{{$value->name}}</a></h3>
                        <p>Giới tính: @if($data_nhanvat[0]['gioi_tinh'] == 0 ) Nam @else Nữ @endif</p>
                        <a href="#!" style="text-decoration: none;" data-placement="bottom" rel="tooltip" data-html="true" title='{!!$chung_toc->gioi_thieu!!}'>{{$chung_toc->ten}}</a> : <span data-placement="bottom" rel="tooltip" data-html="true" title='Đặc tính hệ : {{$he_hientai}}'>{{$the_chat->ten_the_chat}}</span><br><br>
                        <p class="text-uppercase font-weight-bold" style="color:red" rel="tooltip" ata-placement="bottom" data-html="true" title="{{$nang_luong->gioi_thieu}}">{{$nang_luong->ten}}</p>
                    </center>
                </div>
                <div class="card col-md-7 p-2 mt-2">
                    <center>
                        <p class="col-12 kieu_chu text-center {{$chi_tiet->css}}"  data-placement="bottom"  rel="tooltip" data-html="true" title='Cấp : {{$data_thongtin[0]['level']}}'>{{$chi_tiet->ten}}</p>
                        <p class="col-12 text-center" style="color:blue;">{{format_num($data_thongtin[0]['hut_exp'])}} exp/phút</p>
                        <p class="col-12 text-center">EXP : {{$value->phan_tram}}%</p>
                        <p class="col-12 text-center">May mắn : {{$data_thongtin[0]['may_man']}}</p>
                        <p class="col-12">
                            <a href="#!" rel="tooltip" data-placement="bottom" data-html="true" title="cân = {{ format_num(1) }} kg <br>xà = {{ format_num(250) }} kg<br>hùng = {{ format_num(440) }} kg<br>tịnh = {{ format_num(900) }} kg<br>tượng = {{ format_num(9000) }} kg<br>thạch = {{ format_num(60000) }} kg (khối lượng thiên thạch lớn nhất đã rơi vào trái đất)<br>địa= {{ format_num(85706243) }} kg ( căn bậc 2 mặt trăng )<br>thiên = {{ format_num(772787164) }}  ( căn bậc 2 trái đất )<br>quy = {{ format_num(7345560000000000) }}  kg (mặt trăng )<br>long = {{ number_format(597200000000000000) }} kg (trái đất)<br>tinh = {{ format_num(19891000000000000000000000000000000) }} kg (mặt trời)<br>giới = {{ format_num(596730000000000000000000000000000000000000000000000) }} kg (vũ trụ)">Lực lượng: </a>
                            {{ luc_luong($data_thongtin[0]['luc']) }}
                        </p>
                        <p class="col-12">Trí: {{format_num($data_thongtin[0]['tri'])}} IQ</p>
                        <p class="col-12">Tinh lực: {{format_num($data_thongtin[0]['ben'])}} Tinh lực</p>
                        <p class="col-12">Nhanh nhẹn: {{ format_num($data_thongtin[0]['man']) }} m/s</p>
                        <p class="col-12">Tâm cảnh: {{format_num($data_thongtin[0]['tam_canh'])}}</p>
                        <p class="col-12">Công đức: {{format_num($data_thongtin[0]['cong_duc'])}}</p>
                        <p class="col-12">Nghiệp lực: {{format_num($data_thongtin[0]['nghiep_luc'])}}</p>
                        <p class="col-12">Thọ nguyên: @if($data_thongtin[0]['tho_nguyen'] == -1) Bất tử @else {{format_num($data_thongtin[0]['tho_nguyen'])}} năm @endif</p>
                    </center>
                </div>
            </div>
            <hr>
        @endif
    @endforeach
</div>

@endsection
