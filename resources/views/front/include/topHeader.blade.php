<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="logo">
                        <a href="{{ $basePath }}">
                            <img src="{{ $webPath }}assets/images/logo.png" alt="生命探索" class="logo-img">
                        </a>
                        <div class="f-right">
                            <ul class="header_list">
                                {{-- <li><a href="login.html"><i class="fas fa-user"></i><span>註冊/登入</span></a></li> --}}
                                <li><a href="https://www.facebook.com/yunroung" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
                                <li><a href="https://www.instagram.com/info_life_explore/" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header">
        <div class="container pos-relative">
            <nav class="navbar navbar-expand-lg">
                <button class="navbar-toggler collapsed" type="button" data-toggle="slide-collapse"
                    data-target="#navbarContent" aria-expanded="false">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav">
                        @foreach ($frontMenu as $key => $item)
                            @if (isset($item['subMenu']) && (is_object($item['subMenu']) || is_array($item['subMenu'])) )
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="nav-link dropdown-toggle" href="#">{{ $item['title'] }}</a>
                                <div class="dropdown-menu">
                                    <ul>
                                        @foreach ($item['subMenu'] as $v)
                                        <li><a class="dropdown-item nav-link nav_item" href="{{ $v->href }}">{{ $v->name }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @endif

                            @if (isset($item['link']))
                            <li>
                                <a class="nav-link nav_item" href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                    {{-- <div class="search-container">
                        <input type="text" class="search-bar">
                        <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                    </div> --}}
                </div>
            </nav>
            <!-- <div class="search-container">
            <input type="text" class="search-bar">
            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
        </div> -->
        </div>
    </div>
</header>
<!-- END HEADER -->