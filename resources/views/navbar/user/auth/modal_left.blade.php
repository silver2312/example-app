<!-- Modal -->
<div class="modal fade" id="truyen_nhung" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nhúng truyện</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
