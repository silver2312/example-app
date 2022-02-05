<!-- Modal -->
<div class="modal fade" id="nghe_nghiep_exp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{$nghe_nghiep->ten}} • {{$chitiet_nghenghiep->ten}}</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <form action="{{ url('tu-luyen/nghe_nghiep/exp') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <span>Exp trận: {{$data_nhanvat[0]['exp_nghenghiep_hientai'].'/'.$data_nhanvat[0]['exp_nghenghiep_max']}} - </span>
                            <span>Exp đa dụng: {{ format_num($data_thongtin[0]['exp_dubi_hientai']) }} - </span>
                            <span>IQ cần: {{ format_num(pow(300 , ($data_nhanvat[0]['level_nghenghiep'] +1))) }}</span>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nhập exp đa dụng</label>
                            <div class="col-md-12">
                                <input type="number" min="1" max="{{ format_num($data_thongtin[0]['exp_dubi_hientai']) }}" class="form-control" name="exp" placeholder="Nhập exp">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn không?')">Thêm</button>
                        <a href="#!" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn không?')">Lên cấp</a>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
