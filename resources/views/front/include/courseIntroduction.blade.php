<!-- START SECTION -->
<div class="section pd_40">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="">
                    <h2 class="title">課程介紹<span class="large-eng">course introduction</span></h2>
                    <div class="sub-title"></div>
                </div>
            </div>

            <?php foreach ($data['courseInfo'] as $v) { 
                    $href = $v->href;
                    if (!isset($v->htmlStyle) || $v->htmlStyle == 'style1') { ?>

                <!-- (9個)-->
                <div class="col-lg-4 col-sm-6">
                    <div class="course-section">
                        <span class="title"><a href="{{ $href }}">{{ $v->name }}</a></span>
                        <a href="{{ $href }}"><span class="discover-entry content">{!! $v->index_btn_Text !!}</span></a>
                        <a href="{{ $href }}"><img src="{{ $publicPath . $v->img1 }}"></a>
                    </div>
                </div>

                <?php } else { ?>
                    <?php if ($v->htmlStyle == 'style2') { ?>

                        <!-- (8個)-->
                        <div class="col-lg-6 col-sm-6">
                            <div class="course-section desktop-only">
                                <span class="title"><a href="{{ $href }}">{{ $v->name }}</a></span>
                                <a href="{{ $href }}"><span class="relationship-level content content-b">{!! $v->index_btn_Text !!}</span></a>
                                <a href="{{ $href }}"><img src="{{ $publicPath . $v->img2 }}"></a>
                            </div>
                            <div class="course-section mobile-only">
                                <span class="title"><a href="{{ $href }}">{{ $v->name }}</a></span>
                                <a href="{{ $href }}"><span class="cases content">{!! $v->index_btn_Text !!}</span></a>
                                <a href="{{ $href }}"><img src="{{ $publicPath . $v->img2 }}"></a>
                            </div>
                        </div>

                    <?php } ?>
                    <?php if ($v->htmlStyle == 'style3') { ?>

                        <!-- (7個)-->
                        <div class="col-12">
                            <div class="course-section desktop-only">
                                <span class="title"><a href="{{ $href }}">{{ $v->name }}</a></span>
                                <a href="{{ $href }}"><span class="cases content">{!! $v->index_btn_Text !!}</span></a>
                                <a href="{{ $href }}"><img src="{{ $publicPath . $v->img3 }}"></a>
                            </div>
                            <div class="course-section mobile-only">
                                <span class="title"><a href="{{ $href }}">{{ $v->name }}</a></span>
                                <a href="{{ $href }}"><span class="cases content">{!! $v->index_btn_Text !!}</span></a>
                                <a href="{{ $href }}"><img src="{{ $publicPath . $v->img3 }}"></a>
                            </div>
                        </div>

                    <?php } ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>
<!-- END SECTION -->