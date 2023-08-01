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
            <img src="{{ $publicPath . $data['courseInfo']->banner_img }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <h2 class="course-title">{{ $data['courseInfo']->item_title }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div>
                        {!! $data['courseInfo']->item_content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION -->

    <?php } ?>
</div>
<!-- END MAIN CONTENT -->

@endsection