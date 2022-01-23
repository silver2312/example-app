<?php
    use App\Models\NapTienModel;
    use App\Models\User;
?>
{{-- nạp tiền --}}
<div class="modal fade" id="tai_san" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tài sản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Tài sản hiện có: {{number_format(Auth::user()->dong_te)}} đồng tệ , {{number_format(Auth::user()->ngan_te)}} ngân tệ , {{number_format(Auth::user()->kim_te)}} kim tệ , {{number_format(Auth::user()->me)}} ME</p>
                <div class="row mb-2">
                    <div class="col-md-4">
                        <div class="row border" style="height:300px;">
                            <div class="col-12">
                                <h2 style="font-weight:900;color:rgb(180, 30, 168);">MOMO</h2>
                                <img src="https://i.imgur.com/gigNxf9.png?1" alt="nhan_tien" style="width:35%;">
                            </div>
                            <div class="col-12">
                                <h3>Số điện thoại : 0337391701</h3>
                            </div>
                            <div class="col-12">
                                <h3>Người nhận: Lê Đức Phú</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row border" style="height:300px;">
                            <div class="col-12">
                                <h2 style="font-weight:900;color:rgb(74, 74, 247)">Paypal</h2>
                                <p>Thanh toán bằng Paypal admin sẽ nhận được trong một thời gian ngắn.</p>
                                <img src="https://i.imgur.com/Ake8sue.png" alt="nhan_tien" style="width:25%;">
                            </div>
                            <div class="col-12">
                                <p>Người nhận: Lê Đức Phú( @phule9912 )</p>
                            </div>
                            <div class="col-12">
                                <a href="https://www.paypal.com/paypalme/phule9912" target="_blank">Nhập vào đây để thanh toán</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row border" style="height:300px;">
                            <div class="col-12">
                                <h2 style="font-weight:900;color:rgb(55, 231, 84)">Ngân hàng</h2>
                                <p>Thanh toán bằng Ngân hàng admin sẽ nhận được trong một thời gian ngắn.</p>
                                <img src="https://i.imgur.com/vvepEZE.png" alt="nhan_tien" style="width:25%;">
                            </div>
                            <div class="col-12">
                                <span><h3>Vietcombank</h3></span>
                                <span><h4>Số tài khoản: 0941000024256</h4></span>
                                <span><h4>Chủ tài khoản: Lê Đức Phú</h4></span>
                            </div>
                        </div>
                    </div>
                </div>
                <form enctype='multipart/form-data' method="POST" action="{{url('nap-tien/them')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label >Phương thức thanh toán</label>
                            <select class="custom-select" name="phuong_thuc">
                                <option value="1">MOMO</option>
                                <option value="2">Paypal</option>
                                <option value="3">Ngân hàng</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Mã giao dịch</label>
                            <input type="text" class="form-control" name="ma_giao_dich" rel="tooltip" data-html="true" data-title="Cú pháp mã giao dịch: Phương thức nạp_mã giao dịch.<br>Ví dụ: momo_123124564.<br> Nếu chuyển khoản bằng ngân hàng thì dùng cú pháp sau: vietcombank_123154654.<br>Nếu không có mã giao dịch vui lòng ghi theo ví dụ MBank: (mb_số tiền_số tài khoản của bạn_thời gian chuyển).">
                        </div>
                        <div class="form-group col-md-4">
                            <label >ID nhận tiền</label>
                            <input type="number" name="id_nhan" class="form-control" value="{{Auth::id()}}">
                            <small style="color:red">Hãy để nguyên nếu bạn nạp cho chính mình.</small>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" >Nạp kim</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- tiêu phí --}}
<?php
    $data_tieuphi = data_tieuphi(Auth::id());
?>
<div class="modal fade" id="tieu_phi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tài sản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a class="btn btn-danger float-right" href="{{url('tu-luyen/nhan-vat/xoa-tieu-phi')}}" onclick="return confirm('Bạn có chắc chắn muốn xoá lịch sử tiêu phí không?')">Xoá lịch sử tiêu phí</a>
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="tbl_tieu_phi">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Thông báo</th>
                                <th scope="col">Số dư</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($data_tieuphi))
                                <?php  $stt = 1;?>
                                    @foreach ($data_tieuphi as $key => $value)
                                        <tr>
                                            <th scope="row">{{$stt}}</th>
                                            <td><?php echo date("Y-m-d H:i:s", $key); ?></td>
                                            <td>{!!$value['text']!!}</td>
                                            <td>{{$value['so_du']}}</td>
                                        </tr>
                                    <?php  $stt++;?>
                                @endforeach
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
{{-- ls nạp tiền --}}
<?php
    $nap_tien = NapTienModel::orderBy('status','asc')->where('uid',Auth::id())->get();
?>
<div class="modal fade" id="nap_tien" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Trạng thái nạp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive py-4">
                    <table class="table table-flush" id="tbl_naptien">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Người nhận</th>
                                <th scope="col">Lời nhắn từ Admin</th>
                                <th scope="col">Phương thức</th>
                                <th scope="col">Mã giao dịch</th>
                                <th scope="col">Số tiền</th>
                                <th scope="col">Khuyến mại</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($nap_tien as $key => $value)
                                <?php
                                    $user = User::find($value->id_nhan);
                                ?>
                                <tr>
                                    <th scope="row">{{$key++}}</th>
                                    <td>@if( isset($user) ) {{ $user->name }} @else Đã bị xoá @endif</td>
                                    <td>{{$value->noi_dung}}</td>
                                    <td>@if($value->phuong_thuc == 1 ) MOMO @elseif($value->phuong_thuc == 2) Paypal @else Ngân hàng @endif</td>
                                    <td>{{$value->ma_giao_dich}}</td>
                                    <td>@if(empty($value->so_tien) ) 0 @else {{number_format($value->so_tien)}} @endif</td>
                                    <td>@if(empty($value->khuyen_mai) ) 0 @else {{number_format($value->khuyen_mai)}} @endif</td>
                                    <td>{{$value->time}}</td>
                                    <td>@if($value->status ==0 ) Chưa duyệt @elseif($value->status == 1) Đã thanh toán @else Bị từ chối @endif</td>
                                </tr>
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

<div class="modal fade" id="doi_tien" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đổi tiền</h5>
                </button>
                </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('doi-tien')}}">
                @csrf
                    <div class="form-group">
                        <p>Hệ thống thu thuế 1%.</p>
                        <label >Chọn loại muốn chuyển</label>
                        <select class="custom-select" name="phuong_thuc">
                            <option value="1">Kim -> Ngân ( 1 : 100)</option>
                            <option value="2">Kim -> Đồng ( 1 : 10,000)</option>
                            <option value="3">Ngân -> Kim ( 100 : 1)</option>
                            <option value="4">Ngân -> Đồng ( 1 : 100)</option>
                            <option value="5">Đồng -> Kim ( 10,000 : 1 )</option>
                            <option value="6">Đồng -> Ngân ( 100 : 1)</option>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label >Nhập số tiền</label>
                            <input class="form-control" name="so_tien" type="number" min="100" rel="tooltip" data-html="true" title="Tối thiểu mà 100 bất kỳ loại tiền.<br>Số dư: {{number_format(Auth::user()->dong_te,2)}} đồng tệ, {{number_format(Auth::user()->ngan_te,2)}} ngân tệ, {{number_format(Auth::user()->kim_te,2)}} kim tệ">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Mã cấp 2</label>
                            <input type="password" class="form-control" name="ma_c2" max="10" autocomplete="on">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn đổi không?')">Đổi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>
