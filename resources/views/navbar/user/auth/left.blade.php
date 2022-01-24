<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-dark bg-primary" id="sidenav-main">
    @include('navbar.user.auth.modal_left')
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
            <a class="navbar-brand" href="{{url('/')}}">
                <img src="https://i.imgur.com/nXnwDAe.png"  class="navbar-brand-img" style="max-height:100%;" alt="MyScáthach logo">
            </a>
            <div class="ml-auto">
                <!-- Sidenav toggler -->
                <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                    <i class="sidenav-toggler-line"></i>
                </div>
                </div>
            </div>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{url('/')}}" >
                            <i class="ni ni-shop text-primary"></i>
                            <span class="nav-link-text">Trang chủ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-examples">
                        <i class="ni ni-compass-04 text-orange"></i>
                        <span class="nav-link-text">Tu Luyện</span>
                        </a>
                        <div class="collapse" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="#!" class="nav-link">Login</a>
                            </li>
                        </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-components" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-components">
                            <i class="ni ni-shop text-info"></i>
                            <span class="nav-link-text">Cửa hàng</span>
                        </a>
                        <div class="collapse" id="navbar-components">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#cua_hang_nguyen_lieu">Nguyên liệu</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#cua_hang_dot_pha">Đột phá</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#cua_hang_van_nang">Vạn năng</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#cua_hang_cong_phap">Công pháp</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#navbar-multilevel" class="nav-link" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="navbar-multilevel">Multi level</a>
                                    <div class="collapse show" id="navbar-multilevel" style="">
                                        <ul class="nav nav-sm flex-column">
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">Third level menu</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">Just another link</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#!" class="nav-link ">One last link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#truyen_nav" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
                        <i class="ni ni-books text-green"></i>
                        <span class="nav-link-text">Truyện</span>
                        </a>
                        <div class="collapse" id="truyen_nav">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="#!" class="nav-link" data-toggle="modal" data-target="#truyen_nhung"><i class="ni ni-cloud-download-95"></i>Nhúng</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('truyen/cua-toi') }}" class="nav-link"><i class="ni ni-books"></i>Truyện của tôi</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#navbar-forms" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-forms">
                        <i class="ni ni-chart-bar-32 text-pink"></i>
                        <span class="nav-link-text">Bảng xếp hạng</span>
                        </a>
                        <div class="collapse" id="navbar-forms">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                <a href="{{url('bang-xep-hang-tu-luyen')}}" target="_blank" class="nav-link"><i class="ni ni-compass-04 text-danger"></i>Tu luyện</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
                @if(Auth::user()->level == 0)
                    @include('navbar.user.vip.creator')
                @endif
                @if(Auth::user()->level == 1 || Auth::user()->level == 0)
                    @include('navbar.user.vip.admin')
                @endif
                @if(Auth::user()->level == 2 || Auth::user()->level == 0)
                    @include('navbar.user.vip.mod')
                @endif
            </div>
        </div>
    </div>
</nav>
