@guest
    <div class="row">
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-thumbs-up"></i>&nbsp;{{ format_text($truyen->tong_like) }}</span>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-thumbs-down"></i>&nbsp;{{ format_text($truyen->dislike) }}</span>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-book"></i>&nbsp;{{ format_text($truyen->so_chuong) }}</span>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-star-half"></i>&nbsp;@if($truyen->trang_thai == 0)@else Tạm ngưng @endif</span>
        </div>
        <div class="col-md-2 col-3">
            <span><i class="fas fa-bookmark"></i>&nbsp;{{ format_text($truyen->tu) }} </span>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fa fa-gift"></i>&nbsp;{{ format_text($truyen->gift) }} </span>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-2 col-3">
            <a href="#!" class="btn btn-sm btn-info" onclick="like_truyen()"><i class="fas fa-thumbs-up"></i>&nbsp;{{ format_text($truyen->tong_like) }}</a>
        </div>
        <div class="col-md-2 col-3">
            <a href="#!" class="btn btn-sm btn-danger" onclick="dislike_truyen()"><i class="fas fa-thumbs-down"></i>&nbsp;{{ format_text($truyen->dislike) }}</a>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-book"></i>&nbsp;{{ format_text($truyen->so_chuong) }}</span>
        </div>
        <div class="col-md-2 col-3">
            <span ><i class="fas fa-star-half"></i>&nbsp;@if($truyen->trang_thai == 0)@else Tạm ngưng @endif</span>
        </div>
        <div class="col-md-2 col-3">
            <a href="#!" class="btn btn-sm btn-primary" onclick="them_tu()"><i class="fas fa-bookmark"></i>&nbsp;{{ format_text($truyen->tu) }} </a>
        </div>
        <div class="col-md-2 col-3">
            <a href="#!" class="btn btn-sm btn-success"><i class="fa fa-gift"></i>&nbsp;{{ format_text($truyen->gift) }} </a>
        </div>
    </div>
    <script>
        function them_tu(){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res_txt = this.responseText;
                if(res_txt == 0){
                    toastr.error('Đã có truyện trong tủ rồi!');
                }else{
                    toastr.success('Đã thêm truyện vào tủ!');
                }
            }
            var url = "{{url('truyen/them-tu/'.$truyen->id)}}";
            xhttp.open("GET", url,true);
            xhttp.send();
        }
        function like_truyen(){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res_txt = this.responseText;
                if(res_txt == 0){
                    toastr.error('Đã huỷ thích truyện này!');
                }else if(res_txt == 1){
                    toastr.error('Bạn đang không thích truyện này!');
                }else{
                    toastr.success('Đã thích truyện này!');
                }
            }
            var url = "{{url('truyen/like/'.$truyen->id)}}";
            xhttp.open("GET", url,true);
            xhttp.send();
        }
        function dislike_truyen(){
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                var res_txt = this.responseText;
                if(res_txt == 0){
                    toastr.info('Đã huỷ không thích truyện này!');
                }else if(res_txt == 1){
                    toastr.error('Bạn đang thích truyện này!');
                }else{
                    toastr.success('Đã không thích truyện này!');
                }
            }
            var url = "{{url('truyen/dislike/'.$truyen->id)}}";
            xhttp.open("GET", url,true);
            xhttp.send();
        }
    </script>
@endguest
