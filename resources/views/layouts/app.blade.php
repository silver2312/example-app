<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <meta name="propeller" content="7db7dd4ed88fc56634c8b3c6ca9220c9">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico')}}" type="image/png">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">

    <!-- Styles -->
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/argon.css?v=1.1.0')}}" type="text/css">
    <link href="{{ asset('custom/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('/custom/toastr.min.css') }}" rel="stylesheet">
    <!-- CSS plugin-->
    <!-- Page plugins -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-JLBRQ1EFFM"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-JLBRQ1EFFM');
    </script>
</head>
<body class="g-sidenav-hidden">
    <style>
    .img_custom{
        height:236px;
    }
    @media (max-width: 479px) {
        .img_custom{
            height:140px;
        }
    }
    </style>
    @auth
        @include('navbar.user.auth.left')
    @endauth
    <div class="main-content" id="panel">
            @include('navbar.sitebar')
        @auth
            @include('navbar.user.auth.top')
        @endauth

        @yield('content')
    </div>
    <footer class="mt-5">
        <div class="card text-center ">
            <div class="card-body">
              <h5 class="card-title" id="check_online"></h5>
              <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
              <a href="#"><img src="https://i.imgur.com/nAE9VPf.png" style="width:20%;height:20%;"></a>
            </div>
            <div class="card-footer text-muted">
                <?php
                    echo  "Thời gian server: ";
                ?><span id="ngay">00</span>-<span id="thang">00</span>-<span id="nam">00</span>&nbsp;<span id="gio">00</span>:<span id="phut">00</span>:<span id="giay">00</span>
            </div>
        </div>
    </footer>
    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
    <script src="{{ asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/onscreen/dist/on-screen.umd.min.js')}}"></script>
    <!-- Optional JS -->
    <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/datatables.net-buttons/js/buttons.print.min.js')}}"></script>

    @yield('script')
    <!-- Scripts thêm-->
    <script type="text/javascript" src="{{ asset('/custom/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/custom/vue.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/custom/all.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/custom/jquery.ddslick.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('/custom/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/demo.min.js')}}"></script>
    <script src="{{ asset('assets/js/argon.js?v=1.1.0')}}"></script>
    @include('custom.script')
    @include('custom.error')
</body>
</html>
