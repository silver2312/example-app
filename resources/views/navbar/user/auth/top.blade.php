<!-- Topnav -->
<nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
    <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @include('layouts.tim_truyen')
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center ml-md-auto">
        <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
            </div>
            </div>
        </li>
        <li class="nav-item d-sm-none">
            <a class="nav-link" href="#!" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
            </a>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="#!" >
                <i id="dark_mode" onclick="dark_mode()" class="fas fa-moon"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
            <!-- Dropdown header -->
            <div class="px-3 py-3">
                <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>
            </div>
            <!-- List group -->
            <div class="list-group list-group-flush">
                <a href="#!" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-auto">
                        <!-- Avatar -->
                        <img alt="Image placeholder" src="https://i.imgur.com/Wqh7gGX.png" class="avatar rounded-circle">
                        </div>
                        <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                            <h4 class="mb-0 text-sm">John Snow</h4>
                            </div>
                            <div class="text-right text-muted">
                            <small>2 hrs ago</small>
                            </div>
                        </div>
                        <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- View all -->
            <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-ungroup"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default dropdown-menu-right">
            <div class="row shortcuts px-4">
                <a href="#!" class="col-4 shortcut-item" data-toggle="modal" data-target="#nap_tien">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                        <i class="ni ni-align-left-2"></i>
                    </span>
                    <small>Lịch sử nạp</small>
                </a>
                <a href="#!" class="col-4 shortcut-item" data-toggle="modal" data-target="#tieu_phi">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                        <i class="ni ni-bullet-list-67"></i>
                    </span>
                    <small>Lịch sử tiêu phí</small>
                </a>
                <a href="#!" class="col-4 shortcut-item" data-toggle="modal" data-target="#tai_san">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                        <i class="ni ni-credit-card"></i>
                    </span>
                    <small>Tài sản</small>
                </a>
                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                        <i class="ni ni-air-baloon"></i>
                    </span>
                    <small>Thông báo</small>
                </a>
                <a href="#!" class="col-4 shortcut-item">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                        <i class="ni ni-support-16"></i>
                    </span>
                    <small>Hỗ trợ</small>
                </a>
                <a href="#!" class="col-4 shortcut-item" data-toggle="modal" data-target="#doi_tien">
                    <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                        <i class="ni ni-basket"></i>
                    </span>
                    <small>Đổi tiền</small>
                </a>
            </div>
            </div>
        </li>
        </ul>
        <ul class="navbar-nav align-items-center ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                        <img src="{{ url(Auth::user()->u_image) }}" style="width:60px;height:60px;border-radius: 50%;" class="img-thumbnail">
                    <div class="media-body ml-2 d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                    </div>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header noti-title">
                <h6 class="text-overflow m-0">Chào mừng!</h6>
            </div>
            <a href="{{ url('trang-ca-nhan/'.Auth::user()->id) }}" class="dropdown-item">
                <i class="ni ni-single-02"></i>
                <span>Trang cá nhân</span>
            </a>
            <a href="#!" class="dropdown-item" rel="tooltip" data-html="true" title="{{number_format(Auth::user()->dong_te)}} đồng tệ , {{number_format(Auth::user()->ngan_te)}} ngân tệ , {{number_format(Auth::user()->kim_te)}} kim tệ , {{number_format(Auth::user()->me)}} ME">
                <i class="ni ni-money-coins"></i>
                <span>Tài sản</span>
            </a>
            <a href="{{ url('trang-ca-nhan/tu-truyen') }}" class="dropdown-item">
                <i class="ni ni-books"></i>
                <span>Tủ truyện</span>
            </a>
            <a href="{{ url('trang-ca-nhan/cai-dat') }}" class="dropdown-item">
                <i class="ni ni-settings-gear-65"></i>
                <span>Cài đặt</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                <i class="ni ni-user-run"></i>
                <span>{{ __('Đăng xuất') }}</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </div>
        </li>
        </ul>
    </div>
    </div>
    @include('navbar.user.auth.modal_top')
</nav>
