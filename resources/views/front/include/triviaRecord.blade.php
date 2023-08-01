<!-- START SECTION -->
<div class="section pt_30 pb_30">
    <div class="container">
        <div class="row index-album">
            <div class="col-lg-12 col-sm-12">
                <h2 class="title">花絮紀錄<span class="large-eng">our album</span></h2>
                <div class="sub-title"></div>
            </div>
            <div class="col-lg-12 col-sm-12 index-album">
                <div class="owl-carousel owl-theme">
                    @foreach ($data['photoGalleryInfo'] as $v)
                    <div class="item">
                        <a href="{{ $v->href }}">
                            <img src="{{ $basePath . $v->img }}" class="img-fluid img-show">
                            <span><i class="far fa-file-alt mg_10"></i>{{ $v->name }}</span>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="owl-theme">
                <div class="owl-controls">
                    <div class="custom-nav owl-nav"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION -->

<style>
    .owl-dots{
        margin-top: 0.5em;
    }
    .img-show{
        width: 255px;
        height: 150px;
    }
</style>

<script>
    $(document).ready(function() {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:4
                }
            },
            navContainer: '.custom-nav',
            navText: [
                '<i class="fa fa-angle-left" aria-hidden="true"></i>',
                '<i class="fa fa-angle-right" aria-hidden="true"></i>'
            ],
        });
    });
</script>