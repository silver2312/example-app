<?php
use App\Models\Game\ChungTocModel;
use App\Models\Game\TheChatModel;
use App\Models\Game\HeModel;
use App\Models\Game\NangLuongModel;
use App\Models\Game\ChiTiet\ChiTietNangLuongModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\ThienKiepModel;
use App\Models\Game\NgheNghiepModel;
use App\Models\Game\ChiTiet\ChiTietNgheNghiepModel;
?>
<div class="col-12">
    <div class="card khong_mau">
        <div class="card-header kieu_chu">Tu Luyện</div>
        <div class="card-body">
            <div class="row">
                @if( isset($data_nhanvat[0]) )
                    <?php
                        $chungtoc = ChungTocModel::find($data_nhanvat[0]['chung_toc_id']);
                        $thechat_name = TheChatModel::find($data_nhanvat[0]['the_chat_id']);
                        $he_hientai = HeModel::find($thechat_name->he_id)->ten_he;
                    ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header text-center border-0">
                                        @if( isset($uid) && $user->level <= 4 && $user->ngan_te >= 1000 )
                                            <a href="#!">
                                                <img src="{{$data_nhanvat[0]['link_img']}}" alt="Nhân vật của {{$user->name}}" id="phongto" width="200" data-toggle="modal" data-target="#edit_img">
                                            </a>
                                        @else
                                            <img src="{{$data_nhanvat[0]['link_img']}}" alt="Nhân vật của {{$user->name}}" id="phongto" width="200">
                                        @endif
                                        <p class="heading"><a href="#!" rel="tooltip" data-html="true" title='{!!$chungtoc->gioi_thieu!!}'>{{$chungtoc->ten}}</a> : <a href="#!" rel="tooltip" data-placement="bottom"  data-html="true" title='Đặc tính hệ : {{$he_hientai}}'>{{$thechat_name->ten_the_chat}}</a></p>
                                        @if( isset($data_nhanvat[0]['nangluong_id']) )
                                            <?php $nang_luong = NangLuongModel::find($data_nhanvat[0]['nangluong_id']);?>
                                            <p><a href="#!" class="heading" style="color:red" rel="tooltip" data-html="true" title="{!! $nang_luong->gioi_thieu !!}">{{ $nang_luong->ten }}</a></p>
                                            @if(isset($data_thongtin[0]))
                                                <?php
                                                    if($data_thongtin[0]['level'] <= 100){
                                                        $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',$data_thongtin[0]['level'])->first();
                                                    }else{
                                                        $chi_tiet = ChiTietNangLuongModel::where('nangluong_id',$data_nhanvat[0]['nangluong_id'])->where('level',100)->first();
                                                    }
                                                    $tam_makiep = ThienKiepModel::find(12);
                                                    $thien_kiep = ThienKiepModel::find($data_thongtin[0]['do_kiep']);
                                                ?>
                                                <div id="canh_gioi">
                                                    <a class="kieu_chu {{$chi_tiet->css}}" href="#!" rel="tooltip" data-html="true" title="Cấp : {{ $data_thongtin[0]['level'] }}">{{ $chi_tiet->ten }}</a><br>
                                                    @if($data_nhanvat[0]['nghenghiep_id'] != null)
                                                        <?php
                                                        $nghe_nghiep = NgheNghiepModel::where('id',$data_nhanvat[0]['nghenghiep_id'])->first();
                                                        $chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$data_nhanvat[0]['nghenghiep_id'])->where('level',$data_nhanvat[0]['level_nghenghiep'])->first();
                                                        ?>
                                                        <a  rel="tooltip" data-placement="bottom" data-html="true" title="Exp: {{$data_nhanvat[0]['exp_nghenghiep_hientai'].' / '.$data_nhanvat[0]['exp_nghenghiep_max']}}">{{$nghe_nghiep->ten}} • <span class="{{$chitiet_nghenghiep->css}} ">{{$chitiet_nghenghiep->ten}}</span></a><br>
                                                    @endif
                                                    <span><span class="heading">Tốc độ tu luyện</span> : {{ format_num($data_thongtin[0]['hut_exp']) }} exp/phút</span><br>
                                                </div>
                                            @endif
                                        @else
                                            @if(isset($uid))
                                                <?php
                                                    $data_nangluong = data_nangluong();
                                                    $id_nangluong = [];
                                                    foreach($data_nangluong[$data_nhanvat[0]['chung_toc_id']]['nang_luong'] as $key_nl_c => $value_nl_c){
                                                        $id_nangluong[] = $value_nl_c;
                                                    }
                                                    $nang_luong = NangLuongModel::whereIn('id',$id_nangluong)->get();
                                                ?>
                                                <a href="#!" class="btn btn-info" data-toggle="modal" data-target="#them_nl">Chọn năng lượng tu luyện</a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="them_nl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Chọn năng lượng tu luyện</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form enctype='multipart/form-data' method="POST" action="{{url('tu-luyen/nhan-vat/them-nang-luong')}}">
                                                                    @csrf
                                                                        <div class="form-group">
                                                                            <select class="form-control" name="nangluong_id">
                                                                                @foreach($nang_luong as $key_nangluong => $value_nangluong)
                                                                                    <option value="{{$value_nangluong->id}}">{{$value_nangluong->ten}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary" name="them_nangluong_tuluyen">Thêm</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                @include('tu_luyen.button')
                            </div>
                        </div>
                    </div>
                    @if( isset($data_nhanvat[0]['nangluong_id']) )
                        @if(isset($data_thongtin[0]))
                            @include('tu_luyen.thong_tin')
                        @else
                            @if(isset($uid))
                                <div class="col-md-6">
                                    <a href="{{ url('tu-luyen/nhan-vat/them-tu-luyen') }}" class="btn btn-info">Tạo thông tin</a>
                                </div>
                            @endif
                        @endif
                    @endif
                @else
                    @if(isset($uid))
                        <div class="col-md-6">
                            <a href="#!" class="btn btn-info" data-toggle="modal" data-target="#tao_nv">Tạo nhân vật</a>
                            <!-- Modal -->
                            <div class="modal fade"  id="tao_nv" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Tạo nhân vật</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form enctype='multipart/form-data' method="POST" action="{{url('tu-luyen/nhan-vat/them')}}">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label>Giới tính</label>
                                                    <select class="form-control" name="gioi_tinh">
                                                        <option value="0">Nam</option>
                                                        <option value="1">Nữ</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-6">
                                                    <label>Vũ khí</label>
                                                    <select class="form-control" name="vu_khi_chinh">
                                                        @foreach($vu_khi as $key_vk => $value_vk)
                                                        <option value="{{$value_vk->id}}">{{$value_vk->ten}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                                <button type="submit" class="btn btn-primary" name="them_css">Thêm</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                @if(isset($uid) && isset($data_nhanvat[0]['nangluong_id']) && isset($data_thongtin[0]) )
                <div class="col-12">
                    <div class="card khong_mau">
                        <div class="card-header kieu_chu">Túi đồ</div>
                    </div>
                    <div class="card-body">
                        @include('tu_luyen.tui_do.van_nang')
                        @include('tu_luyen.tui_do.nguyen_lieu')
                        @include('tu_luyen.tui_do.dot_pha')
                        @include('tu_luyen.tui_do.cong_phap')
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
