<?php
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\NgheNghiepModel;
use App\Models\Game\ChiTiet\ChiTietNgheNghiepModel;
$dot_pha = DotPhaModel::where('status',1)->get();
?>
<div class="table-responsive py-4">
    <table class="table table-flush" id="shop_dotpha">
        <thead class="thead-dark">
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Nghề nghiệp</th>
                <th>Nguyên liệu ghép</th>
                <th>Giá</th>
                <th>Cấp tối thiểu</th>
                <th>Cài đặt</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dot_pha as $key => $value)
                <?php
                    $id_nghenghiep = NgheNghiepModel::find($value->nghenghiep_id);
                    $id_nguyenlieu = NguyenLieuModel::find($value->nguyenlieu_id);
                ?>
                <tr>
                    <td>{{$key+1}}</td>
                    <td><a href="#!" rel="tooltip" data-html="true" data-title="{!! $value->gioi_thieu !!}">{{$value->ten}}</a></td>
                    <td>{{$id_nghenghiep->ten}} / <?php
                        $chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$value->nghenghiep_id)->get();
                        try{
                            $id_chitiet_nghenghiep = ChiTietNgheNghiepModel::where('nghenghiep_id',$value->nghenghiep_id)->where('level',$value->level_nghenghiep)->first();
                            echo $id_chitiet_nghenghiep->ten;
                        }catch(Throwable $e){
                            echo "Chưa có";
                        }
                        ?></td>
                    <td>{{$id_nguyenlieu->ten}} / {{$value->so_luong}}</td>
                    <td><?php
                        if($value['dong_te'] != 0){
                            echo number_format($value['dong_te']).' đồng tệ ';
                        }
                        if($value['ngan_te'] != 0){
                            echo number_format($value['ngan_te']).' ngân tệ ';
                        }
                        if($value['kim_te'] != 0){
                            echo number_format($value['kim_te']).' kim tệ ';
                        }
                    ?></td>
                    <td>{{$value->level}}</td>
                    <td><a href="#!" class="btn btn-info"data-toggle="modal" data-target="#mua_dot_pha_{{$value->id}}">Mua</a></td>
                </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="mua_dot_pha_{{$value->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title heading" id="exampleModalLabel">{{$value->ten}}</h5>
                                <button type="button" class="btn btn-sm btn-danger"  onclick="close_cuahang_dp_{{$value->id}}()" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form enctype='multipart/form-data' method="POST" action="{{ url('tu-luyen/cua-hang/dot-pha/'.$value->id) }}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Mã cấp 2</label>
                                                <input type="password" class="form-control" name="ma_c2" autocomplete="on">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Số lượng </label>
                                                <input type="number" min="1" class="form-control" name="so_luong" value="1">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn mua không?')">Mua</button>
                                        <button type="button" class="btn btn-secondary" onclick="close_cuahang_dp_{{$value->id}}()">Đóng</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <script >
                    function close_cuahang_dp_{{$value->id}}() {
                        $('#mua_dot_pha_{{$value->id}}').modal('hide');
                    }
                </script>
            @endforeach
        </tbody>
    </table>
</div>
