<div class="modal fade" id="rep_{{$key_cmt}}" tabindex="-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Trả lời</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form enctype='multipart/form-data' method="POST" action="{{url('trang-ca-nhan/rep/'.$user->id.'/'.$key_cmt)}}">
                @csrf
                    <div class="form-group ">
                        <label >Nhập nội dung</label>
                        <textarea name="noi_dung" class="form-control" ></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" >Gửi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Huỷ</button>
                </form>
            </div>
        </div>
    </div>
</div>
