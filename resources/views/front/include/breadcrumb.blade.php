<!-- START BREADCRUMB SECTION -->
<div class="section pd_0 breadcrumb_bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb">
                    <a href="{{ $publicPath }}"><i class="fas fa-home"></i>首頁</a>

                    <?php foreach ($breadcrumb as $key => $v) { 
                        $h = $v['title'];
                        if(isset($v['link']) && $v['link']){
                            $h = '<a href="' . $v['link'] . '">' . $h . '</a>';
                        } 
                    ?>

                    <i class="fas fa-angle-double-right"></i>
                    {!! $h !!}

                    <?php } ?>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END BREADCRUMB SECTION -->