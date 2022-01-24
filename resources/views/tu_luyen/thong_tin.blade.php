<?php
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\ThienKiepModel;
?>
<div class="col-md-6">
    <div class="card">
        <div id="thanh_exp">
            <div class="col-12">
                <span class="heading" id="exp">
                    <div class="progress-wrapper">
                        <div class="progress-info">
                            <div class="progress-label">
                                <div>Exp: <span>{{ format_num($data_thongtin[0]['exp_hientai']).' / '.format_num($data_thongtin[0]['exp_nextlevel']) }}</span></div>
                            </div>
                            <div class="progress-percentage">
                                    <span>{{ tinh_phantram( $data_thongtin[0]['exp_hientai'], $data_thongtin[0]['exp_nextlevel'] ) }}%</span>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-default" role="progressbar" aria-valuenow="{{ tinh_phantram( $data_thongtin[0]['exp_hientai'], $data_thongtin[0]['exp_nextlevel'] ) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ tinh_phantram( $data_thongtin[0]['exp_hientai'], $data_thongtin[0]['exp_nextlevel'] ) }}%;"></div>
                        </div>
                    </div>
                </span>
                <span class="heading" id="exp_da_dung">
                    <div class="progress-wrapper">
                        <div class="progress-info">
                            <div class="progress-label">
                                <div>Exp đa dụng: <span>{{ format_num($data_thongtin[0]['exp_dubi_hientai']).' / '.format_num($data_thongtin[0]['exp_dubi_nextlevel']) }}</span></div>
                            </div>
                            <div class="progress-percentage">
                                    <span>{{ tinh_phantram( $data_thongtin[0]['exp_dubi_hientai'], $data_thongtin[0]['exp_dubi_nextlevel'] ) }}%</span>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="{{ tinh_phantram( $data_thongtin[0]['exp_dubi_hientai'], $data_thongtin[0]['exp_dubi_nextlevel'] ) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ tinh_phantram( $data_thongtin[0]['exp_dubi_hientai'], $data_thongtin[0]['exp_dubi_nextlevel'] ) }}%;"></div>
                        </div>
                    </div>
                </span>
                <span class="heading" id="tinh_luc">
                    <div class="progress-wrapper">
                        <div class="progress-info">
                            <div class="progress-label">
                                <div>Tinh lực: <span>{{ format_num($data_thongtin[0]['ben_hentai']).' / '.format_num($data_thongtin[0]['ben']) }}</span></div>
                            </div>
                            <div class="progress-percentage">
                                    <span>{{ tinh_phantram( $data_thongtin[0]['ben_hentai'], $data_thongtin[0]['ben'] ) }}%</span>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ tinh_phantram( $data_thongtin[0]['ben_hentai'], $data_thongtin[0]['ben'] ) }}" aria-valuemin="0" aria-valuemax="100" style="width: {{ tinh_phantram( $data_thongtin[0]['ben_hentai'], $data_thongtin[0]['ben'] ) }}%;"></div>
                        </div>
                    </div>
                </span>
            </div>
        </div>
        <div id="thong_tin" class="ml-3 mb-3">
            @if(isset($uid) || Auth::user()->level == 0)
                <span><span class="heading">Tài sản</span> : {{number_format($user->dong_te)}} đồng tệ , {{number_format($user->ngan_te)}} ngân tệ , {{number_format($user->kim_te)}} kim tệ , {{number_format($user->me)}} ME</span><br>
            @endif
            <span><span class="heading">Tâm cảnh</span> : {{format_num($data_thongtin[0]['tam_canh'])}}</span><br>
            <span><span class="heading">Thọ nguyên</span> : @if($data_thongtin[0]['tho_nguyen'] == -1) Bất tử @else {{format_num($data_thongtin[0]['tho_nguyen'])}} năm @endif</span><br>
            <span><span class="heading">Trạng thái</span> : {{$data_thongtin[0]['trang_thai']}}</span><br>
            <span><span class="heading" rel="tooltip" data-placement="bottom" data-html="true" title="cân = {{ format_num(1) }} kg <br>xà = {{ format_num(250) }} kg<br>hùng = {{ format_num(440) }} kg<br>tịnh = {{ format_num(900) }} kg<br>tượng = {{ format_num(9000) }} kg<br>thạch = {{ format_num(60000) }} kg (khối lượng thiên thạch lớn nhất đã rơi vào trái đất)<br>địa= {{ format_num(85706243) }} kg ( căn bậc 2 mặt trăng )<br>thiên = {{ format_num(772787164) }}  ( căn bậc 2 trái đất )<br>quy = {{ format_num(7345560000000000) }}  kg (mặt trăng )<br>long = {{ number_format(597200000000000000) }} kg (trái đất)<br>tinh = {{ format_num(19891000000000000000000000000000000) }} kg (mặt trời)<br>giới = {{ format_num(596730000000000000000000000000000000000000000000000) }} kg (vũ trụ)">Lực lượng</span> : {{ luc_luong($data_thongtin[0]['luc']) }}</span><br>
            <span><span class="heading">Trí lực</span> : {{ format_num($data_thongtin[0]['tri']) }} IQ</span><br>
            <span><span class="heading">Nhanh nhẹn</span> : {{format_num($data_thongtin[0]['man'])}} m/s</span><br>
            <span><span class="heading" rel="tooltip" data-placement="bottom" data-html="true" title="E : 0.013%<br>E+ : 1%<br>E++ : 5%<br>D : 6%<br>D+ : 7%<br>D++ : 8%<br>C : 10%<br>C+ : 11%<br>C++ : 12%<br>B : 14%<br>B+ : 15%<br>B++ : 17%<br>A : 20%<br>A+ : 30%<br>A++ : 40%<br>EX : 70%">May mắn</span> : {{$data_thongtin[0]['may_man']}}</span><br>
            <span><span class="heading">Công đức</span> : {{format_num($data_thongtin[0]['cong_duc'])}}</span><br>
            <span><span class="heading">Nghiệp lực</span> : {{format_num($data_thongtin[0]['nghiep_luc'])}}</span><br>
            <span><span class="heading">Đồ đột phá </span> : {{ DotPhaModel::find($data_thongtin[0]['phu_tro'])->ten }} / {{ $data_thongtin[0]['so_luong'] }}</span><br>
            <span><span class="heading">Thiên kiếp</span> : {{ ThienKiepModel::find($data_thongtin[0]['do_kiep'])->ten }}</span><br>
        </div>
    </div>
</div>
