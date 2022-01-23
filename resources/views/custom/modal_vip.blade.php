<?php
    use App\Models\Game\HinhAnhModel;
    $data_thongtin= data_thongtin(Auth::id());
?>
@if(isset($data_thongtin[0]))
    <!-- Modal -->
    <div class="modal fade" id="edit_img" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa ảnh</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form enctype='multipart/form-data' method="POST" action="{{url('tu-luyen/nhan-vat/sua-anh')}}">
                        @csrf
                            <div class="form-group ">
                                <label for="">Mã cấp 2</label>
                                <input type="password" class="form-control" name="ma_c2" maxlength="10">
                            </div>
                            <div class="form-group">
                                <select class="form-control" name="link_img" id="slick">
                                    <?php
                                        if(Auth::user()->level <=1){
                                            $hinh_anh = HinhAnhModel::get();
                                        }else{
                                            $hinh_anh = HinhAnhModel::where('gioi_tinh',$data_nhanvat[0]['gioi_tinh'])->get();
                                        }
                                    ?>
                                    @foreach($hinh_anh as $key_ha => $value_ha)
                                        <option value="{{$value_ha->link_img}}" data-imagesrc="{{$value_ha->link_img}}">.</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Sửa</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Modal -->
<div class="modal fade" id="edit_avt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa ảnh đại diện</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/sua-anh')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Mã cấp 2</label>
                            <input type="password" class="form-control" name="ma_c2" maxlength="10">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Tải file ảnh</label>
                            <input type="file" class="form-control-file" name="u_image" accept="image/png, image/gif, image/jpeg">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_name" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đổi tên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/doi-ten')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Mã cấp 2</label>
                            <input type="password" class="form-control" name="ma_c2" maxlength="10">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Nhập tên mới</label>
                            <input type="text" class="form-control" name="name" maxlength="30">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_anh_bia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đổi ảnh bìa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/doi-anh-bia')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="">Mã cấp 2</label>
                            <input type="password" class="form-control" name="ma_c2" maxlength="10">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Nhập Link ảnh bìa</label>
                            <input type="text" class="form-control" name="link_anh" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="edit_nhac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Đổi nhạc nền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/doi-nhac')}}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="">Mã cấp 2</label>
                            <input type="password" class="form-control" name="ma_c2" maxlength="10">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nhập tên nhạc</label>
                            <input type="text" class="form-control" name="ten_nhac" maxlength="80">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Nhập Link nhạc</label>
                            <input type="url" class="form-control" name="link_nhac" >
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Sửa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </form>
            </div>
        </div>
    </div>
</div>

