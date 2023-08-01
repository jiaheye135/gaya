@extends('front.layouts.main')

@section('content')

<?php if($data['hasCourse']){ ?>
    @include('front.include.breadcrumb')
<?php } ?>

<!-- START SECTION BANNER -->
<?php if($data['hasCourse']){ ?>
<div class="banner_section">
    <img src="{{ $publicPath . $data['courseInfo']->detail_banner_img }}">
</div>
<?php } ?>
<!-- END SECTION BANNER -->

<!-- END MAIN CONTENT -->
<div class="main_content">
    <?php if(!$data['hasCourse']){ ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12" style="margin: 1em; text-align: center;">
                無此課程
            </div>
        </div>
    </div>

    <?php } else { ?>

    <!-- START SECTION -->
    <div class="section ptb_40">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="">
                        <h2 class="title">{{ $data['courseInfo']->name }}</h2>
                        <h2 class="title">{{ $data['courseInfo']->detail_text }}</h2>
                        <div>
                            {!! $data['courseInfo']->detail_content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION -->

    @include('front.include.meetingInfo')

    <!--FIXED COUPON IMAGE-->
    <div class="fixed-img" style="display: none;">
        <img src="{{ $webPath }}assets/images/pages/discount-icon@2x.png" class="discount-icon" style="display: none;">
    </div>

    <?php } ?>

</div>
<!-- END MAIN CONTENT -->

@endsection