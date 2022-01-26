{{-- linh tinh --}}
<script>
    $(document).ready(function(){
        $('[rel="tooltip"]').tooltip();
         toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "61000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
     });

    $("#slick").ddslick({
        width:"100%",
        imagePosition:"left"
    })
    //dark mode
        var element = $(document.body);
        var card_body = $('.card-body');
        var card_header = $('.card-header');
        var card = $('.card');
        var footer = $('.card-footer');
        var model_header = $('.modal-header');
        var model_body = $('.modal-body');
        var modal_footer = $('.modal-footer');
        $(document).ready(function(){
            if(localStorage.getItem('switch_color')!==null){
                const data = localStorage.getItem('switch_color');
                const data_obj = JSON.parse(data);
                element.addClass(data_obj.class_1);
                card.addClass(data_obj.class_1);
                card_body.addClass(data_obj.class_1);
                card_header.addClass(data_obj.class_1);
                model_header.addClass(data_obj.class_2);
                model_body.addClass(data_obj.class_2);
                modal_footer.addClass(data_obj.class_2);
            }
        });
        function dark_mode(){
            element.toggleClass("switch_color");
            card_body.toggleClass("switch_color");
            card_header.toggleClass("switch_color");
            card.toggleClass("switch_color");
            footer.toggleClass("switch_color");
            model_header.toggleClass("switch_color_1");
            model_body.toggleClass("switch_color_1");
            modal_footer.toggleClass("switch_color_1");
            if(document.body.classList.contains("switch_color")){
                var item = {
                    'class_1':'switch_color',
                    'class_2':'switch_color_1',
                    }
                localStorage.setItem('switch_color', JSON.stringify(item));
            }
            else{
                localStorage.removeItem('switch_color');
            }
        }
    //end dark mode
    //đếm giờ
        function Dong_ho() {
            var ngay = document.getElementById("ngay");
            var thang = document.getElementById("thang");
            var nam = document.getElementById("nam");
            var gio = document.getElementById("gio");
            var phut = document.getElementById("phut");
            var giay = document.getElementById("giay");
            var Ngay_hien_tai = new Date().getDate();
            var Thang_hien_tai = new Date().getMonth();
            var Nam_hien_tai = new Date().getFullYear();
            var Gio_hien_tai = new Date().getHours();
            var Phut_hien_tai = new Date().getMinutes();
            var Giay_hien_tai = new Date().getSeconds();
            ngay.innerHTML = Ngay_hien_tai;
            thang.innerHTML = Thang_hien_tai+1;
            nam.innerHTML = Nam_hien_tai;
            gio.innerHTML = Gio_hien_tai;
            phut.innerHTML = Phut_hien_tai;
            giay.innerHTML = Giay_hien_tai;
        }
        var Dem_gio = setInterval(Dong_ho, 1000);
    //end đếm giờ
</script>
{{-- http --}}
<script>
    function check_user() {
        var http = new XMLHttpRequest();
        var url = '{{url("check-user/")}}';
        http.open('GET', url, true);
        http.send();
    }
    check_user();
    var time = setInterval(check_user, 600000);
    //truyện
    function check_truyen() {
        var http = new XMLHttpRequest();
        var url = '{{url("check-truyen/")}}';
        http.open('GET', url, true);
        http.send();
    }
    check_truyen();
    //online
        function online() {
            var http = new XMLHttpRequest();
            http.onreadystatechange = function() {
                if (http.readyState == 4 && http.status == 200) {
                    // Typical action to be performed when the document is ready:
                    document.getElementById("check_online").innerHTML = http.responseText;
                }
            };
            var url = '{{url("online/")}}';
            http.open('GET', url, true);
            http.send();
        }
        online();
    //end online
</script>
{{-- data tabel --}}
<script>
    $(document).ready( function () {
        $('#shop_dotpha').dataTable();
        $('#shop_nguyenlieu').dataTable();
        $('#shop_vannang').dataTable();
        $('#shop_congphap').dataTable();
        $('#list_skill').dataTable();
        $('#rut_do').dataTable();
        $('#nhan_item').dataTable();
        $('#tbl_tieu_phi').dataTable();
        $('#tbl_naptien').dataTable();
     } );
</script>
{{-- check vip --}}
    @if(Auth::check() &&Auth::user()->level == 4)
        <script>
            function check_vip() {
                var http = new XMLHttpRequest();
                var url = '{{url("check-vip")}}';
                http.open('GET', url, true);
                http.send();
                http.onreadystatechange = function() {
                    if (http.readyState == 4 && http.status == 200) {
                        // Typical action to be performed when the document is ready:
                        if(http.responseText.search('over_vip') > 0){
                            location.reload();
                        }
                    }
                };
            }
            check_vip();
            var time = setInterval(check_vip, 600000);
        </script>
    @endif
 {{-- end check vip --}}
{{-- modal close --}}
    <script>
        function close_model_cp() {
            $('#da_dung_cp').modal('hide');
        }
    </script>
{{-- end modal close --}}
@yield('script_ll')
@guest
    @include('custom.ads')
@else
    @if(Auth::user()->level > 4)
        @include('custom.ads')
    @endif
@endguest
