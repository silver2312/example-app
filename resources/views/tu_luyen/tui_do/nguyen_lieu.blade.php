<?php
use App\Models\Game\Item\NguyenLieuModel;
$data_tuido_nguyenlieu = data_tuido($uid)
?>
@if(isset($data_tuido_nguyenlieu[0]['tuido_nguyenlieu']) )
    @foreach($data_tuido_nguyenlieu[0]['tuido_nguyenlieu'] as $key_nguyenlieu => $value_nguyenlieu)
            @if($data_tuido_nguyenlieu[0]['tuido_nguyenlieu'][$key_nguyenlieu]['so_luong'] >= 1)
                <?php
                    $list_item_nguyenlieu = NguyenLieuModel::find($key_nguyenlieu);
                ?>
                <a href="#" rel="tooltip" data-placement="bottom" data-html="true" title="{{$list_item_nguyenlieu->ten.' <br>Số lượng: '.$data_tuido_nguyenlieu[0]['tuido_nguyenlieu'][$key_nguyenlieu]['so_luong'].'<br>'.$list_item_nguyenlieu->gioi_thieu}}" data-toggle="modal" data-target="#ghep_nguyenlieu{{$key_nguyenlieu}}"><img src="https://i.imgur.com/0rAXIg7.png" width="30" alt=""></a>
                {{-- form nguyên liệu --}}
                <div class="modal fade" id="ghep_nguyenlieu{{$key_nguyenlieu}}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{$list_item_nguyenlieu->ten}}</h5>
                            </div>
                            <div class="modal-body">
                                <form id="form_nguyenlieu_{{$key_nguyenlieu}}" name="form_{{$key_nguyenlieu}}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Số lượng hiện có : {{$data_tuido_nguyenlieu[0]['tuido_nguyenlieu'][$key_nguyenlieu]['so_luong']}}</label>
                                        <textarea class="form-control" style="resize: none;">{{$list_item_nguyenlieu->gioi_thieu}}</textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Số lượng</label>
                                            <input type="number" min="1" max="{{$data_tuido_nguyenlieu[0]['tuido_nguyenlieu'][$key_nguyenlieu]['so_luong']}}" class="form-control" name="so_luong" value="1">
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
                                    <button type="button" class="btn btn-secondary" onclick="luyen_{{$key_nguyenlieu}}()">Luyện</button>
                                    <button type="button" class="btn btn-success" onclick="ban_nl_{{$key_nguyenlieu}}()">Bán shop</button>
                                    <button type="button" class="btn btn-info" onclick="nguyenlieu_chuyen_{{$key_nguyenlieu}}()">Chuyển</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end form nguyên liệu --}}
                <script>
                    // luyện nguyên liệu
                    function luyen_{{$key_nguyenlieu}}(){
                        if( confirm("Bạn chắc chắn muốn luyện không?") == true ){
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").action = "{{url('tu-luyen/cua-hang/nguyen-lieu/su-dung/'.$key_nguyenlieu)}}";
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").submit();
                        }
                    }
                    //end luyện nguyên liệu
                    // bán shop
                    function ban_nl_{{$key_nguyenlieu}}(){
                        if( confirm("Bạn chắc chắn muốn bán không?") == true ){
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").action = "{{url('tu-luyen/cua-hang/nguyen-lieu/ban/'.$key_nguyenlieu)}}";
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").submit();
                        }
                    }
                    //end bán shop
                    // chuyển đồ
                    function nguyenlieu_chuyen_{{$key_nguyenlieu}}(){
                        if( confirm("Bạn chắc chắn muốn chuyển không?") == true ){
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").action = "{{url('tu-luyen/cua-hang/nguyen-lieu/chuyen/'.$key_nguyenlieu)}}";
                            document.getElementById("form_nguyenlieu_{{$key_nguyenlieu}}").submit();
                        }
                    }
                    //end chuyển đồ
                </script>
            @endif
    @endforeach
@endif
