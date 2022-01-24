<!-- Search form -->
<form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main" method="GET" action="{{ url('truyen/tim-kiem') }}" autocomplete="off">
    <div class="form-group mb-0">
        <div class="input-group input-group-alternative input-group-merge">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
            </div>
            <input class="form-control" placeholder="Tên truyện,tác giả,giới thiệu,.." type="search" name="tu_khoa">
        </div>
    </div>
    <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</form>
