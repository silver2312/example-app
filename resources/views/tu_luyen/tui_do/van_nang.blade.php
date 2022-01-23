<?php
use App\Models\Game\Item\VanNangModel;

$data_tuido_vannang = data_tuido($uid);
?>
@if(isset($data_tuido_vannang[0]['tuido_vannang']) )
    @foreach($data_tuido_vannang[0]['tuido_vannang'] as $key_vannang => $value_vannang)
        @if($data_tuido_vannang[0]['tuido_vannang'][$key_vannang]['so_luong'] >= 1)
            <?php
                $list_item = VanNangModel::find($key_vannang);
            ?>
            <a rel="tooltip" href="#" data-placement="bottom" data-html="true" title="{{$list_item->ten.'<br>Số lượng: '.$data_tuido_vannang[0]['tuido_vannang'][$key_vannang]['so_luong'].'<br>'.$list_item->gioi_thieu}}" data-toggle="modal" data-target="#van_nang{{$key_vannang}}"><img src="https://i.imgur.com/GZRQNwV.png" width="30"></a>
            <div class="modal fade" id="van_nang{{$key_vannang}}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{$list_item->ten}}</h5>
                        </div>
                        <div class="modal-body">
                            <form id="form_vannang_{{$key_vannang}}" name="form_{{$key_vannang}}" method="POST" >
                                @csrf
                                <div class="form-group">
                                    <label>Số lượng hiện có : {{$data_tuido_vannang[0]['tuido_vannang'][$key_vannang]['so_luong']}}</label>
                                    <textarea class="form-control" style="resize: none;">{{$list_item->gioi_thieu}}</textarea>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Số lượng</label>
                                        <input type="number" min="1" max="{{$data_tuido_vannang[0]['tuido_vannang'][$key_vannang]['so_luong']}}" class="form-control" name="so_luong" value="1">
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
                                <button type="button" class="btn btn-secondary" onclick="dung_{{$key_vannang}}()" >Sử dụng</button>
                                <button type="button" class="btn btn-success" onclick="ban_vn_{{$key_vannang}}()">Bán shop</button>
                                <button type="button" class="btn btn-info" onclick="chuyen_vn_{{$key_vannang}}()">Chuyển</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end form nguyên liệu --}}
            <script>
                // dùng item
                function dung_{{$key_vannang}}(){
                    if( confirm("Bạn chắc chắn muốn dùng không?") == true){
                        document.getElementById("form_vannang_{{$key_vannang}}").action = "{{url('tu-luyen/cua-hang/van-nang/su-dung/'.$key_vannang)}}";
                        document.getElementById("form_vannang_{{$key_vannang}}").submit();
                    }
                }
                //end dùng
                // bán shop
                function ban_vn_{{$key_vannang}}(){
                    if( confirm("Bạn chắc chắn muốn bán không?") == true){
                        document.getElementById("form_vannang_{{$key_vannang}}").action = "{{url('tu-luyen/cua-hang/van-nang/ban/'.$key_vannang)}}";
                        document.getElementById("form_vannang_{{$key_vannang}}").submit();
                    }
                }
                //end bán shop
                // bán shop
                function chuyen_vn_{{$key_vannang}}(){
                    if( confirm("Bạn chắc chắn muốn chuyển không?") == true){
                        document.getElementById("form_vannang_{{$key_vannang}}").action = "{{url('tu-luyen/cua-hang/van-nang/chuyen/'.$key_vannang)}}";
                        document.getElementById("form_vannang_{{$key_vannang}}").submit();
                    }
                }
                //end bán shop
            </script>
        @endif
    @endforeach
@endif
