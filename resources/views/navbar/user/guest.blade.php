<!-- Navabr -->
<nav id="navbar-main" class="navbar navbar-horizontal navbar-main navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="{{url('/')}}">
        <img src="https://i.imgur.com/nXnwDAe.png" style="position:absolute;top:5%;height:100%;">
      </a>
      <button class="navbar-toggler btn btn-sm btn-danger" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-danger"></span>
      </button>
      <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
        <div class="navbar-collapse-header">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="{{url('/')}}">
                <img src="https://i.imgur.com/nAE9VPf.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <hr class="d-lg-none" />
        <ul class="navbar-nav align-items-lg-center ml-lg-auto">
            <li class="nav-item ">
                <a class="nav-link" href="#!" >
                    <i id="dark_mode" onclick="dark_mode()" class="fas fa-moon"></i>
                </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('login') }}" class="nav-link">
                <span class="nav-link-inner--text">Đăng nhập</span>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">
                <span class="nav-link-inner--text">Đăng ký</span>
              </a>
            </li>
        </ul>
      </div>
    </div>
</nav>

<div class="row  justify-content-center mt-2">
    @include('layouts.tim_truyen')
    <span class="d-sm-none">
        <a class="nav-link" href="#!" data-action="search-show" data-target="#navbar-search-main">
            <i class="ni ni-zoom-split-in"></i>
        </a>
    </span>
</div>
