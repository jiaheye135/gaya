<!-- START SECTION -->
<div class="section ptb_40">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <div class="about-us-img">
                    <img src="{{ $publicPath . $data['indexInfo'][0]->value }}">
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="">
                    <h2 class="title">生命探索介紹<span class="large-eng">about us</span></h2>
                    {!! $data['indexInfo'][1]->value !!}
                    <div class="more-link" style="cursor: pointer;" onclick="javascript:location.href='{{ $basePath }}aboutLE?data=JTdCJTIydGltZSUyMiUzQSUyMjIwMjEtMDItMjQrMTMlM0E1MyUzQTIzJTIyJTJDJTIya2V5JTIyJTNBJTIyYzRjYTQyMzhhMGI5MjM4MjBkY2M1MDlhNmY3NTg0OWIlMjIlN0Q%3D';">more</div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION -->