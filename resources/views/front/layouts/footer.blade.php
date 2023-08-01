<style>

</style>
<footer class="">
    <!-- START SECTION -->
    <div class="section pd_40 contactus_bg">
        <div class="container">
            <div class="row">
                <div><img src="{{ $webPath }}assets/images/footer-1@3x.png"></div>
                <div class="col-lg-7 col-sm-12">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="info-icons"><i class="fab fa-facebook-square"></i></div>
                            <div class="info-main-title">粉絲專頁</div>
                            <div class="fb-page" data-href="https://www.facebook.com/yunroung/" data-tabs="timeline" data-width="300" data-height="289" data-hide-cta="true" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/yunroung/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/yunroung/">生命探索 ~回到源頭可以不用繞遠路</a></blockquote></div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="info-icons"><i class="fab fa-instagram"></i></div>
                            <div class="info-main-title">Instagram</div>
                            <div class="ig-posts">
                                <?php foreach ($IGInfo as $post): ?>
                                    <a href="<?= $post['media_url'] ?>"><img src="<?= $post['media_url'] ?>" class="ig-images"></a>
                                <?php endforeach; ?>
                            </div>                      
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 d-flex">
                    <div>
                        <img src="{{ $webPath }}assets/images/footer-2@2x.png">
                    </div>
                    <ul class="info-list">
                        <div class="info-main-title">聯絡資訊</div>
                        <li class="info">
                            <div class="info-icons"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="info-title">位置</div>
                                <div class="info-contect">{{ $pageInfo[1]->value[0]['address'] }}<br />(請先預約)
                                    <a href="http://maps.google.com?q={{ $pageInfo[1]->value[0]['address'] }}" target="_blank">
                                    <img src="{{ $webPath }}assets/images/map-icon1.png" alt="生命探索" class="map-icon">
                                    </a>
                                </div>
                            </div>
                            
                        </li>
                        <li class="info">
                            <div class="info-icons"><i class="fas fa-users"></i></div>
                            <div>
                                <div class="info-title">聯絡人</div>
                                <?php foreach ($pageInfo[2]->value as $i => $v){ 
                                    if(!$v['name']) continue; ?>
                                    <div class="info-contect">
                                        <span>{{ $v['name'] }}</span>
                                        <span>{{ $v['phone'] }}</span>
                                    </div>
                                <?php } ?>
                            </div>
                        </li>
                        
                        <li class="info">
                            <div class="info-icons"><i class="fas fa-envelope-open-text"></i></div>
                            <div>
                                <div class="info-title">email</div>
                                <div class="info-contect"><a href="mailto:{{ $pageInfo[3]->value[0]['email'] }}">{{ $pageInfo[3]->value[0]['email'] }}</a></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION -->

    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3614.282400813954!2d121.52661861537909!3d25.058415843465532!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3442a95dac7b8b93%3A0x8dcb960161b6de67!2zMTA0OTHlj7DljJfluILkuK3lsbHljYDkuK3ljp_ooZc0OOiZnzM!5e0!3m2!1szh-TW!2stw!4v1616635962511!5m2!1szh-TW!2stw" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe> --}}
</footer>

<a href="#" class="scrollup" style="display: none;"><i class="fas fa-angle-up"></i></a>

<!-- my -->
<script src="{{ $publicPath }}base/js/my.js"></script>
<!-- jQuery UI-->
<script src="{{ $webPath }}assets/js/jquery-ui.js"></script>
<!-- Latest compiled and minified Bootstrap -->
<script src="{{ $webPath }}assets/bootstrap/js/bootstrap.min.js"></script>
<!-- owl-carousel min js  -->
<script src="{{ $webPath }}assets/owlcarousel/js/owl.carousel.min.js"></script>
<!-- slick js -->
<script src="{{ $webPath }}assets/js/slick.min.js"></script>
<!-- imageMapResizer js -->
<script src="{{ $webPath }}assets/js/imageMapResizer.js"></script>
<!-- scripts js -->
<script src="{{ $webPath }}assets/js/scripts.js?"></script>
{{-- <script src="{{ $webPath }}assets/js/ekko-lightbox.min.js"></script> --}}
<script src="{{ $webPath }}assets/js/lightbox.min.js"></script>
<script src="{{ $webPath }}assets/js/jo_main.js"></script>
<!-- custom-select js-->
<script src="{{ $webPath }}assets/js/custom-select.js"></script>

