<!-- Modal -->
<div class="modal fade" id="truyen_nhung" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nhúng truyện</h5>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{url('truyen/nhung')}}">
                    @csrf
                    <div class="form-group">
                        <label>Nguồn hỗ trợ</label>
                        <br>
                        <a href="https://www.230book.net/" target="_blank" class="btn btn-sm btn-primary">230book</a>
                        <a href="https://trxs.cc/" target="_blank" class="btn btn-sm btn-primary">trxs</a>
                    </div>
                    <div class="form-group mb-3">
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-sound-wave"></i></span>
                            </div>
                            <input class="form-control" placeholder="Nhập url truyện" type="url" name="link" autocomplete="off">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary my-4">Nhúng</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
use App\Models\ThongBaoModel;

$huong_dan = ThongBaoModel::where('tag',1)->first();
?>
<!-- Modal -->
<div class="modal fade" id="huong_dan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn</h5>
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(Auth::check() && Auth::user()->level == 0)
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#tb_tl">Hướng dẫn</button>
                    <!-- Modal -->
                    <div class="modal fade" id="tb_tl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Hướng dẫn</h5>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="close_modal_tul()">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <form enctype='multipart/form-data' method="POST" action="{{url('creator/thong-bao-tu-luyen')}}" autocomplete="off">
                                        @csrf
                                            <div class="form-group">
                                                <label>Giới thiệu</label>
                                                @if(empty($huong_dan))
                                                    <textarea  name="noi_dung" id="gioi_thieu_tl" class="form-control"></textarea>
                                                @else
                                                    <textarea  name="noi_dung" id="gioi_thieu_tl" class="form-control">{!! $huong_dan->noi_dung !!}</textarea>
                                                @endif
                                            </div>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                            <button type="button" class="btn btn-secondary" onclick="close_modal_tul()">Đóng</button>
                                        </form>
                                        @section('script_tl')
                                            <script>
                                                CKEDITOR.replace( 'gioi_thieu_tl' );
                                            </script>
                                        @endsection
                                        <script>
                                            function close_modal_tul() {
                                                $('#tb_tl').modal('hide');
                                            }
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-12 p-5">
                    <div class="table-responsive">
                        @if(empty($huong_dan))
                            Chưa có hướng dẫn
                        @else
                            {!! $huong_dan->noi_dung !!}
                        @endif
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
