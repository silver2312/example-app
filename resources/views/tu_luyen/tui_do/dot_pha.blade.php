<?php
use App\Models\Game\Item\DotPhaModel;

$data_tuido_dotpha = data_tuido($uid);
?>
@if(isset($data_tuido_dotpha[0]['tuido_dotpha']) )
    @foreach($data_tuido_dotpha[0]['tuido_dotpha'] as $key_dotpha => $value_dotpha)
            @if($data_tuido_dotpha[0]['tuido_dotpha'][$key_dotpha]['so_luong'] >= 1)
                <?php
                    $list_item_dotpha = DotPhaModel::find( $key_dotpha);
                ?>
                <a href="#!" data-toggle="modal" data-target="#dot_pha{{$key_dotpha}}" style="text-decoration:none" href="#" data-html="true" rel="tooltip" data-placement="bottom" title="{{$list_item_dotpha->ten.'<br>Số lượng: '.$data_tuido_dotpha[0]['tuido_dotpha'][$key_dotpha]['so_luong'].'<br>'.$list_item_dotpha->gioi_thieu}}"><img src="https://i.imgur.com/gUuTk0A.png" width="30" alt=""></a>
                @if($key_dotpha != 7)
                    {{-- form nguyên liệu --}}
                    <div class="modal fade" id="dot_pha{{$key_dotpha}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{$list_item_dotpha->ten}}</h5>
                                </div>
                                <div class="modal-body">
                                    <form id="form_dp_{{$key_dotpha}}" name="form_{{$key_dotpha}}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label>Số lượng hiện có : {{$data_tuido_dotpha[0]['tuido_dotpha'][$key_dotpha]['so_luong']}}</label>
                                            <textarea class="form-control" style="resize: none;">{{$list_item_dotpha->gioi_thieu}}</textarea>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label>Số lượng</label>
                                                <input type="number" min="1" max="{{$data_tuido_dotpha[0]['tuido_dotpha'][$key_dotpha]['so_luong']}}" class="form-control" name="so_luong" value="1">
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
                                        <button type="button" class="btn btn-success" onclick="ban_dotpha{{$key_dotpha}}()">Bán shop</button>
                                        <button type="button" class="btn btn-info" onclick="chuyen_dotpha{{$key_dotpha}}()">Chuyển</button>
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end form nguyên liệu --}}
                    <script>
                        //bán
                        function ban_dotpha{{$key_dotpha}}(){
                            if( confirm("Bạn chắc chắn muốn bán không?") == true ){
                                document.getElementById("form_dp_{{$key_dotpha}}").action = "{{url('tu-luyen/cua-hang/dot-pha/ban/'.$key_dotpha)}}";
                                document.getElementById("form_dp_{{$key_dotpha}}").submit();
                            }
                        }
                        //end bán
                        //chuyển
                        function chuyen_dotpha{{$key_dotpha}}(){
                            if( confirm("Bạn chắc chắn muốn chuyển không?") == true ){
                                document.getElementById("form_dp_{{$key_dotpha}}").action = "{{url('tu-luyen/cua-hang/dot-pha/chuyen/'.$key_dotpha)}}";
                                document.getElementById("form_dp_{{$key_dotpha}}").submit();
                            }
                        }
                        //end chuyển
                    </script>
                @endif
            @endif
    @endforeach
@endif

