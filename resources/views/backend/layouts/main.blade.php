<!DOCTYPE html>
<html lang="en">
@include('backend.layouts.head')

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="javascript:redirect('index')">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><span style="white-space:nowrap;">Life-Explore</span> Backstage <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            @if (count($backendMenuAuth) > 0)
            <div id="accordionSidebar">
                <li class="nav-item" onclick="menuAction('groupFrontSetMenu')" style="cursor: pointer;">
                    <a id="groupFrontSetMenu" class="nav-link collapsed" data-toggle="collapse">
                        <i class="fas fa-fw fa-chart-area"></i>
                        <span>前台網站設定</span>
                    </a>
                </li>

                <div class="categoryM groupFrontSetMenu" data-key="groupFrontSetMenu">
                    <div>
                        <?php $i = 0; 
                            foreach($backendMenuAuth as $groupTitie => $v){
                                $addClass = '';
                                $header = '<div class="sidebar-heading">' . $groupTitie . '</div>';
                                if( strstr($groupTitie, 'no_show') ){ 
                                    $addClass = 'my-0'; 
                                    $header = '';
                                } ?>

                        <!-- Divider -->
                        <hr class="sidebar-divider {{ $addClass }}">

                        <!-- Heading -->
                        {!! $header !!}

                        <?php   $j = 0;
                                foreach($v as $groupKey => $v1){
                                    if($v1['menuType'] == 1){ // 有子選單
                                        $subMenuId = 'collapse' . $i . $j;
                                        $headingId = 'heading' . $i . $j; ?>

                        <!-- Nav Item - Collapse Menu -->
                        <li id="{{$groupKey}}" class="nav-item menu-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$subMenuId}}"
                                aria-expanded="true" aria-controls="{{$subMenuId}}" onclick="openCM('groupFrontSetMenu')">
                                <i class="fas fa-fw {{$v1['iconClass']}}"></i>
                                <span>{{$v1['title']}}</span>
                            </a>
                            <div id="{{$subMenuId}}" class="collapse {{ ($i + 1) == count($backendMenuAuth) ? 'lastSubMenu' : '' }}" aria-labelledby="{{$headingId}}"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">

                                    <?php foreach($v1['subMenu'] as $collapseHeader => $v2){
                                            $collapseHeader = strstr($collapseHeader, 'no_show') ? '' : '<h6 class="collapse-header">' . $collapseHeader . '</h6>'; ?>

                                    {!! $collapseHeader !!}

                                    <?php   foreach($v2 as $itemKey => $v3){ ?>

                                    <a id="{{ $itemKey }}" class="collapse-item menu-item" href="javascript:redirect('{{ $itemKey }}')">{{ $v3['title'] }}</a>

                                    <?php   }
                                        } ?>
                                </div>
                            </div>
                        </li>
                        
                        <?php       } ?>

                        <?php       if($v1['menuType'] == 2){ // 無子選單 ?>

                        <!-- Nav Item -->
                        <li class="nav-item">
                            <a id="{{ $groupKey }}" class="nav-link" href="javascript:redirect('{{ $groupKey }}')">
                                <i class="fas fa-fw {{ $v1['iconClass'] }}"></i>
                                <span>{{ $v1['title'] }}</span></a>
                        </li>

                        <?php       } ?>
                        <?php       $j++; 
                                } ?>
                        <?php   $i++; 
                            } ?>
                    </div>
                </div>
            </div>
            @endif

            <div id="mainMenu">
                <?php $i = 0; 
                    foreach($backendMainMenuAuth as $groupTitie => $v){
                        $addClass = '';
                        $header = '<div class="sidebar-heading">' . $groupTitie . '</div>';
                        if( strstr($groupTitie, 'no_show') ){ 
                            $addClass = 'my-0'; 
                            $header = '';
                        } ?>

                <!-- Divider -->
                <hr class="sidebar-divider {{ $addClass }}">

                <!-- Heading -->
                {!! $header !!}

                <?php   $j = 0;
                        foreach($v as $groupKey => $v1){
                            if($v1['menuType'] == 1){ // 有子選單
                                $subMenuId = 'main_collapse' . $i . $j;
                                $headingId = 'main_heading' . $i . $j; ?>

                <!-- Nav Item - Collapse Menu -->
                <li id="{{$groupKey}}" class="nav-item menu-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#{{$subMenuId}}"
                        aria-expanded="true" aria-controls="{{$subMenuId}}" onclick="openCM('')">
                        <i class="fas fa-fw {{$v1['iconClass']}}"></i>
                        <span>{{$v1['title']}}</span>
                    </a>
                    <div id="{{$subMenuId}}" class="collapse" aria-labelledby="{{$headingId}}"
                        data-parent="#mainMenu">
                        <div class="bg-white py-2 collapse-inner rounded">

                            <?php foreach($v1['subMenu'] as $collapseHeader => $v2){
                                    $collapseHeader = strstr($collapseHeader, 'no_show') ? '' : '<h6 class="collapse-header">' . $collapseHeader . '</h6>'; ?>

                            {!! $collapseHeader !!}

                            <?php   foreach($v2 as $itemKey => $v3){ ?>

                            <a id="{{ $itemKey }}" class="collapse-item menu-item" href="javascript:redirect('{{ $itemKey }}')">{{ $v3['title'] }}</a>

                            <?php   }
                                } ?>
                        </div>
                    </div>
                </li>
                
                <?php       } ?>

                <?php       if($v1['menuType'] == 2){ // 無子選單 ?>

                <!-- Nav Item -->
                <li class="nav-item">
                    <a id="{{ $groupKey }}" class="nav-link" href="javascript:redirect('{{ $groupKey }}')">
                        <i class="fas fa-fw {{ $v1['iconClass'] }}"></i>
                        <span>{{ $v1['title'] }}</span></a>
                </li>

                <?php       } ?>
                <?php       $j++; 
                        } ?>
                <?php   $i++; 
                    } ?>
            </div>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Session::get('backend.user.data')->name }}</span>
                                <img class="img-profile rounded-circle" src="{{ $webPath }}assets/images/people_icon.png">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?php if($hasAuth){ ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">{{ $pageInfo['title'] }}</h1>
                    @yield('content')
                </div>

                <?php } ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('backend.layouts.footer')
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="javascript:redirect('login')">Logout</a>
                </div>
            </div>
        </div>
    </div>

</body>

<!-- Bootstrap core JavaScript-->
<script src="{{ $webPath }}assets/js/jquery.min.js?"></script>
<script src="{{ $webPath }}assets/bootstrap/js/bootstrap.bundle.min.js"></script>

<!--Drag sort-->
<script type="text/javascript" src="{{ $webPath }}assets/js/jquery-ui.js"></script>

<!-- Core plugin JavaScript-->
<script src="{{ $webPath }}assets/js/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="{{ $webPath }}assets/js/sb-admin-2.min.js"></script>
<!-- dataTables -->
<script src="{{ $webPath }}assets/datatables/jquery.dataTables.min.js"></script>
<script src="{{ $webPath }}assets/datatables/dataTables.bootstrap4.min.js"></script>
<!-- fixedColumns -->
<script src="{{ $webPath }}assets/datatables/dataTables.fixedColumns.min.js"></script>
<!-- editor -->
<script src="{{ $webPath }}assets/ckeditor/ckeditor.js"></script>
<!-- CKFinder --->
<script src="{{ $webPath }}assets/ckfinder/ckfinder.js"></script>

<!-- my -->
<script src="{{ $publicPath }}base/js/my.js?"></script>

<style>
    .groupFrontSetMenu{
        height: 0;
        overflow: hidden;
        background: cornflowerblue;
        border-radius: 28px;
    }
    .animation{
        -webkit-transition: height 0.3s;
        -moz-transition: height 0.3s;
        -o-transition: height 0.3s;
        transition: height 0.3s;
    }
</style>

<script>
    function openCM(menuKey){
        if(menuKey == 'groupFrontSetMenu'){
            var div = $('.' + menuKey);
            div.height('auto');
        } else {
            menuAction('groupFrontSetMenu', 'close');
        }
    }

    function menuAction(menuKey, action){
        var div = $('.' + menuKey), groupH = div.height();
        if(action == 'close' || groupH > 0){    // close
            div.height(div.height());
            div.height(0);

            $('#' + menuKey).addClass('collapsed');
            $('#' + menuKey).css('color', 'rgba(255, 255, 255, 0.8)');
            $('#' + menuKey).css('font-weight', 'unset');
        } else {           // open
            var h = $('.' + menuKey + ' div').height();
            if($('.lastSubMenu').hasClass('show')) h += 16;

            div.height(h);

            $('#' + menuKey).removeClass('collapsed');
            $('#' + menuKey).css('color', '#FFF');
            $('#' + menuKey).css('font-weight', 700);
        }
    }

    function redirect(page) {
        var url = gBasePath + page;

        location.href = page;
    }

    function setMenuActive(route) {
        var navItem = $('#' + route).parents('.nav-item');

        navItem.addClass('active');
        navItem.find('.nav-link').removeClass('collapsed');
        navItem.find('.collapse').addClass('show');

        $('#' + route).addClass('active');
    }

    function categoryMInit(route){
        menuAction( $('#' + route).parents('.categoryM').data('key') );
        setTimeout(function(){ $('.groupFrontSetMenu').addClass('animation'); }, 20);
    }

    $(function () {
        setMenuActive('{{$openMenuKey}}');
        categoryMInit('{{$openMenuKey}}');
    })
</script>

</html>