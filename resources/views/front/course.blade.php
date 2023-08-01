@extends('front.layouts.main')

@section('content')

<?php if($data['hasCourse']){ ?>
    @include('front.include.breadcrumb')
<?php } ?>

<!-- START MAIN CONTENT -->
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
    <div class="section pb_40 course-page">
        <div class="course-header">
            <img src="{{ $publicPath . $data['courseInfo']->detail_banner_img }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <h2 class="course-title">{{ $data['courseInfo']->name }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <h2 class="title pt_40">{{ $data['courseInfo']->detail_text }}</h2>
                    <div class="course-content">
                        {!! $data['courseInfo']->detail_content !!}
                    </div>

                    <?php if($data['courseInfo']->has_experience_meeting == 1) { ?>
                    <div class="course-price">
                        體驗會費用: NT$<span class="price-cma">{{ $data['courseInfo']->experience_meeting_fee }}</span>
                    </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION -->

    @if ( $data['courseInfo']->is_meeting == 1)
        @include('front.include.meetingInfo')
        @if ($data['courseInfo']->start_class == 1) @include('front.include.fixedCoupon') @endif
    @endif
    <?php } ?>
</div>
<!-- END MAIN CONTENT -->

<style>
</style>

@endsection