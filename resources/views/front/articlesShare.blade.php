@extends('front.layouts.main')

@section('content')

<?php if($data['hasArticlesShare']){ ?>
    @include('front.include.breadcrumb')
<?php } ?>

<!-- END MAIN CONTENT -->
<div class="main_content">
    <?php if(!$data['hasArticlesShare']){ ?>

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
                <div class="col-lg-3 col-sm-12 member-sharing-left">
                    <div class="position-relative">
                        <img src="{{ $publicPath . $data['articlesShareInfo']->content_photo }}" style="width: 100%;">
                        <h2 class="title">文章分享</h2>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-12 member-sharing-right">
                    <div class="mt-20">
                        <h2 class="title">{{ $data['articlesShareInfo']->myTitle }}</h2>
                        <div class="share_content">
                            {!! $data['articlesShareInfo']->share_content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- START SECTION -->

    <?php } ?>
</div>
<!-- END MAIN CONTENT -->

@endsection