<!DOCTYPE html>
<html lang="en">
@include('front.layouts.head')

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0" nonce="fi6Vgalw"></script>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId            : '3467657916644160',
                autoLogAppEvents : true,
                xfbml            : true,
                version          : 'v9.0'
            });
            // FB.Event.subscribe('customerchat.load', function(){
            //     console.log(1);
            //     $('.fb_dialog_content iframe').hide();
            //     setTimeout(function(){$('.fb_dialog_content iframe').hide();}, 200);
            // });
            // FB.Event.subscribe('customerchat.show', function(){console.log(2);});
        };
    </script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/zh_TW/sdk/xfbml.customerchat.js"></script>

    <!-- <div class = "fb-customerchat mys"
        page_id = "190369774334026"
        theme_color = "#F39700"
        logged_in_greeting="歡迎有任何想法，都可以跟我們聯絡哦~" 
        >
    </div> -->

    <!-- top header -->
    <div class="wrapper">
        @include('front.include.topHeader')
        @yield('content')
    </div>

    @include('front.layouts.footer')
</body>

<style>
    html, body {
        height: 100%;
        margin: 0;
    }
</style>

<script>
    function footerResize(){
        $('.wrapper').css('min-height', $('html').height() - $('footer').height());
    }

    $(window).resize( footerResize );
    footerResize();
</script>

</html>