<?php
    $data_dangdoc = data_dangdoc(Auth::user()->id);
    try{
        $count_dd = count($data_dangdoc);
    }catch(Throwable $e){
        $count_dd = 0;
    }
?>
@if($count_dd > 0)
    <!-- đang đọc -->
    <div class="modal fade" id="dang_doc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Truyện đang đọc</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body data_dd">
                    <script>
                        function data_dd(){
                            var http = new XMLHttpRequest();
                            var url = '{{url("truyen/data-dang-doc/")}}';
                            http.open('GET', url, true);
                            http.send();
                            http.onreadystatechange = function() {
                                if (http.readyState == 4 && http.status == 200) {
                                    $('.data_dd').html(http.responseText);
                                }
                            };
                        }
                        data_dd();
                    </script>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
@endif
