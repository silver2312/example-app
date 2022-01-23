<?php
use App\Models\Game\Item\CongPhapModel;

$data_congphap = data_tuido($uid)
?>
@if(isset($data_congphap[0]['cong_phap']) )
    @foreach($data_congphap[0]['cong_phap'] as $key_congphap => $value_congphap)
            @if($data_congphap[0]['cong_phap'][$key_congphap]['so_luong'] >= 1)
                <?php
                    $cong_phap = CongPhapModel::find( $key_congphap);
                ?>
                <a data-toggle="modal" data-target="#cong_phap{{$key_congphap}}" href="#" style="text-decoration:none" href="#" data-html="true" rel="tooltip" data-placement="bottom" title="{{$cong_phap->ten.'<br>Số lượng: '.$data_congphap[0]['cong_phap'][$key_congphap]['so_luong'].'<br>'.$cong_phap->gioi_thieu}}"><img src="https://i.imgur.com/gxwAo9U.png" width="30" alt="{{$cong_phap->ten}}"></a>
                {{-- form nguyên liệu --}}
                <div class="modal fade" id="cong_phap{{$key_congphap}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$cong_phap->ten}}</h5>
                            </div>
                            <div class="modal-body">
                                <form id="form_cp_{{$key_congphap}}" name="form_{{$key_congphap}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Số lượng hiện có : {{$data_congphap[0]['cong_phap'][$key_congphap]['so_luong']}}</label>
                                        <textarea class="form-control" style="resize: none;">{!! $cong_phap->gioi_thieu !!}</textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Số lượng</label>
                                            <input type="number" min="1" max="{{$data_congphap[0]['cong_phap'][$key_congphap]['so_luong']}}" class="form-control" name="so_luong" value="1">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Mã cấp 2</label>
                                            <input type="password"  class="form-control" name="ma_c2" placeholder="Nhập mã cấp 2" autocomplete="true">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>ID người nhận: </label>
                                            <input type="number" min="0" class="form-control" name="id_nhan" value="0">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Đồng tệ: </label>
                                            <input type="number" step="any" min="0" class="form-control" name="dong_te" value="0">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Ngân tệ: </label>
                                            <input type="number" step="any" min="0" class="form-control" name="ngan_te" value="0">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Kim tệ: </label>
                                            <input type="number" step="any" min="0" class="form-control" name="kim_te" value="0">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-secondary" onclick="su_dung_cp{{$key_congphap}}()">Tu Luyện</button>
                                    <button type="button" class="btn btn-success" onclick="ban_shop_cp{{$key_congphap}}()">Bán shop</button>
                                    <button type="button" class="btn btn-info" onclick="chuyen_cp_{{$key_congphap}}()">Chuyển</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end form nguyên liệu --}}
                <script>
                    var cong_phap_{{$key_congphap}} = document.getElementById("form_cp_{{$key_congphap}}");
                    // luyện nguyên liệu
                    function su_dung_cp{{$key_congphap}}(){
                        if( confirm("Bạn chắc chắn muốn dùng không?") == true ){
                            cong_phap_{{$key_congphap}}.action = "{{url('tu-luyen/cua-hang/cong-phap/su-dung/'.$key_congphap)}}";
                            cong_phap_{{$key_congphap}}.submit();
                        }
                    }
                    //end luyện nguyên liệu
                    //bán shop
                    function ban_shop_cp{{$key_congphap}}(){
                        if( confirm("Bạn chắc chắn muốn bán không?") == true ){
                            cong_phap_{{$key_congphap}}.action = "{{url('tu-luyen/cua-hang/cong-phap/ban/'.$key_congphap)}}";
                            cong_phap_{{$key_congphap}}.submit();
                        }
                    }
                    //end bán shop
                    //chuyển
                    function chuyen_cp_{{$key_congphap}}(){
                        if( confirm("Bạn chắc chắn muốn chuyển không?") == true ){
                            cong_phap_{{$key_congphap}}.action = "{{url('tu-luyen/cua-hang/cong-phap/chuyen/'.$key_congphap)}}";
                            cong_phap_{{$key_congphap}}.submit();
                        }
                    }
                    //end chuyển
                </script>
            @endif
    @endforeach
@endif

