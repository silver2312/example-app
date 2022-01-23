<?php
use App\Models\Game\Item\CongPhapModel;
use App\Models\Game\Item\NguyenLieuModel;
use App\Models\Game\Item\DotPhaModel;
use App\Models\Game\Item\VanNangModel;
use App\Models\User;
?>
@if(isset($uid) && isset($data_nhanvat[0]['nangluong_id']) && isset($data_thongtin[0]) )
    <div class="row">
        <div class="col-12">
            <div class="card-body">

                @if($data_thongtin[0]['tu_luyen'] <= 2)
                    <a href="#!" class="btn btn-info" id="lich_luyen" onclick="ra_lich_luyen()">Lịch luyện</a>
                    <script>
                        var text_button_ll = document.getElementById('lich_luyen');
                        function http_lich_luyen(){
                            const http = new XMLHttpRequest();
                            var url = "{{url('tu-luyen/nhan-vat/lich-luyen')}}";
                            http.onreadystatechange = function() {
                                    if (http.readyState == 4 && http.status == 200) {
                                        var res = http.responseText;
                                        if(res.search("die") >= 0){
                                            location.reload();
                                        }
                                        if(res.search("tam_ma") >= 0){
                                            location.reload();
                                        }
                                        if(res.search("err") >= 0){
                                            location.reload();
                                        }
                                        if(res.search("len_cap") >= 0){
                                            location.replace("{{url('tu-luyen/nhan-vat/len-cap')}}");
                                        }
                                        toastr.info(res);
                                    }
                                };
                            http.open("GET", url, true);
                            http.send();
                        }
                        function ra_lich_luyen(){
                            if( text_button_ll.innerText == 'Lịch luyện'){
                                text_button_ll.innerText = 'Đang lịch luyện';
                                var item = {
                                    'id_ll':'lich_luyen',
                                    }
                                localStorage.setItem('lich_luyen', JSON.stringify(item));
                                http_lich_luyen();
                                var ll_loop = setInterval(function () {
                                    http_lich_luyen();
                                }, 61000);
                            }else{
                                text_button_ll.innerText = 'Lịch luyện';
                                const interval_id = window.setInterval(function(){}, Number.MAX_SAFE_INTEGER);
                                // Clear any timeout/interval up to that id
                                for (let i = 1; i < interval_id; i++) {
                                    window.clearInterval(i);
                                }
                                toastr.clear()
                                localStorage.removeItem('lich_luyen');
                            }
                        }
                    </script>
                    @section('script_ll')
                        <script>
                            $(document).ready(function(){
                                if(localStorage.getItem('lich_luyen')!==null){
                                    text_button_ll.innerText = 'Đang lịch luyện';
                                    http_lich_luyen();
                                    var ll_loop = setInterval(function () {
                                        http_lich_luyen();
                                    }, 61000);
                                }
                            });
                        </script>
                    @endsection
                @endif

                @if($data_thongtin[0]['tu_luyen'] == 3 )
                    <a href="{{url('tu-luyen/nhan-vat/tam-ma-kiep')}}" class="btn btn-danger" rel="tooltip" data-html="true" title="Thành công :{{$tam_makiep->thanh_cong*100}}%<br>Tiểu thương: {{$tam_makiep->tieu_thuong*100}}%<br>Trọng thương: {{$tam_makiep->trong_thuong*100}}%<br>Tử vong: {{$tam_makiep->chet*100}}%" onclick="return confirm('Bạn có chắc chắn muốn độ tâm ma kiếp không?')">Tâm ma kiếp</a>
                @endif

                @if($thien_kiep->id != 1 && $data_thongtin[0]['exp_hientai'] >= $data_thongtin[0]['exp_nextlevel'] )
                    <a href="{{url('tu-luyen/nhan-vat/do-kiep')}}" class="btn btn-warning" rel="tooltip" data-html="true" title="Thành công :{{$thien_kiep->thanh_cong*100}}%<br>Tiểu thương: {{$thien_kiep->tieu_thuong*100}}%<br>Trọng thương: {{$thien_kiep->trong_thuong*100}}%<br>Tử vong: {{$thien_kiep->chet*100}}%" onclick="return confirm('Bạn có chắc chắn muốn độ không?')">Độ kiếp</a>
                @endif

                @if($data_thongtin[0]['tu_luyen'] == 4)
                    <a href="{{url('tu-luyen/nhan-vat/len-cap')}}" class="btn btn-success">Lên cấp</a>
                @endif

                @if( isset($data_congphap[0]))
                    <a href="#!" class="btn btn-primary" data-toggle="modal" data-target="#da_dung">Kỹ năng</a>
                    <!-- Modal -->
                    <div class="modal fade"  id="da_dung" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Kỹ năng</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive py-4">
                                        <table class="table table-flush" id="list_skill">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">Loại</th>
                                                    <th scope="col">Tên</th>
                                                    <th scope="col">Exp</th>
                                                    <th scope="col">Exp thêm</th>
                                                    <th scope="col">Buff</th>
                                                    <th scope="col">Level</th>
                                                    <th scope="col">Level max</th>
                                                    <th scope="col">Cài đặt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if( isset($data_congphap[0]))
                                                <?php
                                                    if($data_congphap[0]['buff'] == 0){
                                                        $exp_them = $data_thongtin[0]['hut_exp']*$data_congphap[0]['buff_exp']/100;
                                                        $buff = "Cộng ".$data_congphap[0]['buff_exp']."% tốc độ tu luyện";
                                                    }else{
                                                        $exp_them = $data_thongtin[0]['hut_exp']*$data_congphap[0]['buff_exp'];
                                                        $buff = "Nhân ".$data_congphap[0]['buff_exp']." lần tốc độ tu luyện";
                                                    }
                                                ?>
                                                    <tr>
                                                        <td>Công pháp</td>
                                                        <td rel="tooltip" data-html="true" data-title="{!! $data_congphap[0]['gioi_thieu'] !!}">{{ $data_congphap[0]['ten'] }}</td>
                                                        <td>{{$data_congphap[0]['exp_hentai']}}/{{$data_congphap[0]['exp_next']}}</td>
                                                        <td>{{ number_format($exp_them) }}</td>
                                                        <td>{{$buff}}</td>
                                                        <td>{{$data_congphap[0]['level']}}</td>
                                                        <td>{{$data_congphap[0]['level_max']}}</td>
                                                        <td><a href="#!" class="btn btn-danger" data-toggle="modal" data-target="#da_dung_cp">Cài đặt</a></td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="da_dung_cp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">{{$data_congphap[0]['ten']}}</h5>
                                                                    <button type="button" class="close" onclick="close_model_cp()" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form enctype='multipart/form-data' method="POST" id="cong_phap_form">
                                                                        @csrf
                                                                        <div class="form-row">
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Mã cấp 2</label>
                                                                                <input type="password" class="form-control" name="ma_c2">
                                                                            </div>
                                                                            <div class="form-group col-md-6">
                                                                                <label for="">Tên</label>
                                                                                <input type="text" maxlength="55" class="form-control" name="ten" value="{{$data_congphap[0]['ten']}}">
                                                                            </div>
                                                                        </div>
                                                                        @if( $data_thongtin[0]['exp_dubi_hientai'] > 0 && $data_congphap[0]['level'] < $data_congphap[0]['level_max'])
                                                                            <div class="form-group">
                                                                                <span style="color:red;">Cần {{ number_format($data_congphap[0]['exp_next'] - $data_congphap[0]['exp_hentai']) }} để lên cấp</span><br>
                                                                                <span>Exp đa dụng hiện có : {{number_format($data_thongtin[0]['exp_dubi_hientai'])}}</span><br>
                                                                                <label for="">Nhập exp đa dụng : </label>
                                                                                <input type="number" min="1" max="{{$data_thongtin[0]['exp_dubi_hientai']}}" class="form-control" name="exp" value="1">
                                                                            </div>
                                                                        @endif
                                                                        <div class="form-group">
                                                                            <label for="">Giới thiệu</label>
                                                                            <textarea class="form-control" maxlength="255" name="gioi_thieu" id="cong_phap_gt">{!!$data_congphap[0]['gioi_thieu']!!}</textarea>
                                                                        </div>
                                                                        @if( $data_thongtin[0]['exp_dubi_hientai'] > 0 && $data_congphap[0]['level'] < $data_congphap[0]['level_max'])
                                                                            <button type="button" class="btn btn-primary" onclick="them_exp()">Thêm exp</button>
                                                                        @endif
                                                                        <button type="button" class="btn btn-info"onclick="sua_cp()">Sửa thông tin</button>
                                                                        <button type="button" class="btn btn-danger"onclick="tan_cong()">Tán công</button>
                                                                        <button type="button" class="btn btn-secondary" onclick="close_model_cp()">Đóng</button>
                                                                    </form>
                                                                    {{--  end công pháp --}}
                                                                    <script>
                                                                        var cp_id = document.getElementById("cong_phap_form");
                                                                        function them_exp(){
                                                                            if( confirm("Bạn chắc chắn muốn thêm exp không?") == true ){
                                                                                cp_id.action = "{{url('ky-nang/cong-phap/them-exp')}}";
                                                                                cp_id.submit();
                                                                            }
                                                                        }
                                                                        function tan_cong(){
                                                                            if( confirm("Bạn chắc chắn muốn dùng không?") == true ){
                                                                                cp_id.action = "{{url('ky-nang/cong-phap/tan-cong')}}";
                                                                                cp_id.submit();
                                                                            }
                                                                        }
                                                                        function sua_cp(){
                                                                            if( confirm("Bạn chắc chắn muốn sửa không?") == true ){
                                                                                cp_id.action = "{{url('ky-nang/cong-phap/sua')}}";
                                                                                cp_id.submit();
                                                                            }
                                                                        }
                                                                    </script>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- chuyển đồ --}}
                    <?php
                        $check_chuyendo = 0;
                        foreach($chuyen_do as $key_chuyendo =>$value_chuyendo){
                            if($value_chuyendo->id_gui == $uid){
                                $check_chuyendo = 1;
                            }
                        }
                    ?>
                    @if($check_chuyendo == 1)
                        <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#chuyen_do">Chờ xác nhận chuyển</a>
                        <div class="modal fade" id="chuyen_do" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Danh sách đồ chờ xác nhận</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive py-4">
                                            <table class="table table-flush" id="rut_do">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Người nhận</th>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">Giá</th>
                                                        <th scope="col">Thời gian hết hạn</th>
                                                        <th scope="col">Cài đặt</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($chuyen_do as $key_chuyendo =>$value_chuyendo)
                                                        @if($value_chuyendo->id_gui == $uid)
                                                            <tr>
                                                                <th scope="row">{{$key_chuyendo++}}</th>
                                                                <td>{{User::find($value_chuyendo->id_nhan)->name." [".$value_chuyendo->id_nhan."]"}}</td>
                                                                <td><?php
                                                                    if(isset($value_chuyendo->nguyenlieu_id)){
                                                                        echo NguyenLieuModel::find($value_chuyendo->nguyenlieu_id)->ten;
                                                                    }elseif(isset($value_chuyendo->vannang_id)){
                                                                        echo VanNangModel::find($value_chuyendo->vannang_id)->ten;
                                                                    }elseif(isset($value_chuyendo->dotpha_id)){
                                                                        echo DotPhaModel::find($value_chuyendo->dotpha_id)->ten;
                                                                    }elseif(isset($value_chuyendo->congphap_id)){
                                                                        echo CongPhapModel::find($value_chuyendo->congphap_id)->ten;
                                                                    }
                                                                ?> / {{$value_chuyendo->so_luong}}</td>
                                                                <td>{{number_format($value_chuyendo->dong_te,2)." đồng tệ, ".number_format($value_chuyendo->ngan_te,2)." ngân tệ, ".number_format($value_chuyendo->kim_te,2)." kim tệ"}}</td>
                                                                <td>{{$value_chuyendo->timeout}}</td>
                                                                <td><a href="{{url('tu-luyen/nhan-vat/rut-do/'.$value_chuyendo->id)}}" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn rút đồ về không?')">Rút về</a></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <?php
                        $nhan_do = 0;
                        foreach($chuyen_do as $key_chuyendo =>$value_chuyendo){
                            if($value_chuyendo->id_nhan == $uid){
                                $nhan_do = 1;
                            }
                        }
                    ?>
                    @if($nhan_do == 1)
                        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#nhan_do">Nhận đồ</a>
                        <div class="modal fade" id="nhan_do" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Danh sách đồ có thể nhận</h5>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive py-4">
                                            <table class="table table-flush" id="nhan_item">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th scope="col">#</th>
                                                        <th scope="col">Người gửi</th>
                                                        <th scope="col">Item</th>
                                                        <th scope="col">Giá</th>
                                                        <th scope="col">Thời gian hết hạn</th>
                                                        <th scope="col">Cài đặt</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($chuyen_do as $key_chuyendo =>$value_chuyendo)
                                                        @if($value_chuyendo->id_nhan == $uid)
                                                            <tr>
                                                                <th scope="row">{{$key_chuyendo++}}</th>
                                                                <td>{{User::find($value_chuyendo->id_gui)->name." [".$value_chuyendo->id_gui."]"}}</td>
                                                                <td><?php
                                                                    if(isset($value_chuyendo->nguyenlieu_id)){
                                                                        echo NguyenLieuModel::find($value_chuyendo->nguyenlieu_id)->ten;
                                                                    }elseif(isset($value_chuyendo->vannang_id)){
                                                                        echo VanNangModel::find($value_chuyendo->vannang_id)->ten;
                                                                    }elseif(isset($value_chuyendo->dotpha_id)){
                                                                        echo DotPhaModel::find($value_chuyendo->dotpha_id)->ten;
                                                                    }elseif(isset($value_chuyendo->congphap_id)){
                                                                        echo CongPhapModel::find($value_chuyendo->congphap_id)->ten;
                                                                    }
                                                                ?> / {{$value_chuyendo->so_luong}}</td>
                                                                <td>{{number_format($value_chuyendo->dong_te,2)." đồng tệ, ".number_format($value_chuyendo->ngan_te,2)." ngân tệ, ".number_format($value_chuyendo->kim_te,2)." kim tệ"}}</td>
                                                                <td>{{$value_chuyendo->timeout}}</td>
                                                                <td><a href="{{url('tu-luyen/nhan-vat/nhan-do/'.$value_chuyendo->id)}}" class="btn btn-success mr-2" onclick="return confirm('Bạn có chắc chắn muốn nhận đồ về không?')">Nhận</a></td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                {{-- end chuyển đồ --}}
            </div>
        </div>
    </div>
@endif
