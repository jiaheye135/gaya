<!-- START SECTION BANNER -->
<div class="banner_section">
    <div id="DesktopBanner" class="carousel slide carousel-fade desktop-only">
        <div class="carousel-inner">
            <?php foreach ($bannerInfo as $i => $v) {
                $href = ($v->link) ? '<a href="' . $v->link . '">': '';
                $active = ($i == 0) ? 'active' : '';?>

                <div class="carousel-item {{ $active }}">{!! $href !!}<img src="{{ $publicPath . $v->img }}"></a></div>
            
            <?php } ?>
        </div>
        <a class="left carousel-control-prev" href="#DesktopBanner" role="button" data-slide="prev">
            <i class="fas fa-chevron-circle-left" aria-hidden="true"></i>
        </a>
        <a class="right carousel-control-next" href="#DesktopBanner" role="button" data-slide="next">
            <i class="fas fa-chevron-circle-right" aria-hidden="true"></i>
        </a>
        <ol class="carousel-indicators  indicators">
            <?php foreach ($bannerInfo as $i => $v) {
                $active = ($i == 0) ? 'active' : '';?>

            <li data-target="#DesktopBanner" data-slide-to="{{ $i }}" class="{{ $active }}"></li>

            <?php } ?>
        </ol>
    </div>
    <div id="MobileBanner" class="carousel slide carousel-fade mobile-only">
        <div class="carousel-inner">
            <?php foreach ($bannerInfo as $i => $v) {
                $href = ($v->link) ? '<a href="' . $v->link . '">': '';
                $active = ($i == 0) ? 'active' : '';?>

            <div class="carousel-item {{ $active }}">{!! $href !!}<img src="{{ $publicPath . $v->img }}"></a></div>

            <?php } ?>
        </div>
        <ol class="carousel-indicators  indicators">
            <?php foreach ($bannerInfo as $i => $v) {
                $active = ($i == 0) ? 'active' : '';?>

            <li data-target="#MobileBanner" data-slide-to="{{ $i }}" class="{{ $active }}"></li>

            <?php } ?>
        </ol>
    </div>
</div>
<!-- END SECTION BANNER -->