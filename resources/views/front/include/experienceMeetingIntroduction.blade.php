<script>
    var gHas3d = 'WebKitCSSMatrix' in window && 'm11' in new WebKitCSSMatrix(),
    	gTrnOpen = 'translate' + (gHas3d ? '3d(' : '('),
    	gTrnClose = gHas3d ? ',0)' : ')';

    function actionCallback(){
        this.removeEventListener('webkitTransitionEnd', actionCallback);
        this.style.transitionDuration = '0s';
    }

    function icelandIconActive(){
        var parentH = $('#iceland-img').height(),
            moveT = '-' + (parentH / 50) + 'px'; 

        this.addEventListener('webkitTransitionEnd', actionCallback, false);
        this.style.transitionDuration = '0.5s';
        this.style.webkitTransform = gTrnOpen + '0px,' + moveT + gTrnClose;

        $(this).parents('.iceland-item').find('.iceland-shadow').show();
        $(this).parents('.iceland-item').find('.iceband-icon-text').show();
    }

    function icelandIconactiveOut(){        
        this.addEventListener('webkitTransitionEnd', actionCallback, false);
        this.style.transitionDuration = '0.5s';
        this.style.webkitTransform = gTrnOpen + '0px,0px' + gTrnClose;

        $(this).parents('.iceland-item').find('.iceband-icon-text').hide();
        $(this).parents('.iceland-item').find('.iceland-shadow').hide();
    }

    function getIcelandProportion(icon){
        var d = {};
        switch(icon){
            case 'icon-01':
                d.iconWP = 8; d.iconLP = 4.43; d.iconTP = 5.73; d.shadWS = 7; d.shadlS = -3; d.shadTP = 4.68; d.textTP = '20%'; d.textLS = -175;
                break;
            case 'icon-02':
                d.iconWP = 8; d.iconLP = 3.45; d.iconTP = 2.83; d.shadWS = 7; d.shadlS = -3; d.shadTP = 2.38; d.textTP = '42%'; d.textLS = -200;
                break;
            case 'icon-03':
                d.iconWP = 8; d.iconLP = 2.40; d.iconTP = 1.98; d.shadWS = 2; d.shadlS = -3; d.shadTP = 1.88; d.textTP = '52%'; d.textLS = -200;
                break;
            case 'icon-04':
                d.iconWP = 8; d.iconLP = 3.40; d.iconTP = 1.57; d.shadWS = 7; d.shadlS = -3; d.shadTP = 1.39; d.textTP = '72%'; d.textLS = -175;
                break;
            case 'icon-05':
                d.iconWP = 8; d.iconLP = 2.08; d.iconTP = 1.42; d.shadWS = 2; d.shadlS = -3; d.shadTP = 1.28; d.textTP = '78%'; d.textLS = -175;
                break;
            case 'icon-06':
                d.iconWP = 8; d.iconLP = 1.38; d.iconTP = 1.53; d.shadWS = 3; d.shadlS = -3; d.shadTP = 1.45; d.textTP = '69%'; d.textLS = -175;
                break;
            case 'icon-07':
                d.iconWP = 8; d.iconLP = 1.29; d.iconTP = 2.73; d.shadWS = 7; d.shadlS = -3; d.shadTP = 2.48; d.textTP = '39%'; d.textLS = -175;
                break;
        }
        return d;
    }

    function icelandResize(){
        $('.iceland-item').hide();
        $('.iceland-icon').hide();
        var parentW = $('#iceland-img').width();
        var parentH = $('#iceland-img').height();
        $('.iceland-item').each(function(){
            var icon = $(this).find('.iceland-icon').data('icon'), d = getIcelandProportion(icon);
            $(this).find('.iceland-icon').css({
                'width': parentW / d.iconWP,
                'left' : parentW / d.iconLP,
                'top'  : parentH / d.iconTP,
            });
            $(this).find('.iceland-shadow').css({
                'width': (parentW / d.iconWP) + d.shadWS,
                'left' : (parentW / d.iconLP) + d.shadlS,
                'top'  : parentH / d.shadTP,
            });
            $(this).find('.iceband-icon-text').css({
                'left': (parentW / d.iconLP) + d.textLS,
                'top' : d.textTP,
            });
        });
        $('.iceland-item').show();
        $('.iceland-icon').show();
    }

    $(window).resize( icelandResize );

    $(function(){
        $(".iceland-icon").mouseover(icelandIconActive);
        $(".iceland-icon").mouseout(icelandIconactiveOut);
    });
</script>

<!-- START SECTION -->
<div class="section ptb_10">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="thebeiginning">一開始的相遇</div>
                <h2 class="title thebeiginTitle">體驗會介紹<span class="large-eng">experience</span></h2>
                <div class="sub-title"></div>
            </div>
        </div>
    </div>
</div>
<div class="description">
    <div class="text-div container">
        <div>
            <p>這是一個協助我們拿到「愛自己的力量」深度之旅</p>
            <p>生存在這個物質世界中，越來越多人渴望身心靈並重發展，大家都希望「關係和諧」，大家都希望「心想事成」，但是，總覺得缺少了那麼一點點，甚至不斷被外在環境衝擊，想要更多的清晰明白感覺卻感覺永無止境。我們多數人的生活都在重複同一個模式而不自知！我們都在童年時做了一些決定影響未來的模式而不自知！
            </p>
            <div class="more-link" style="cursor: pointer;" onclick="javascript:location.href='{{ $basePath }}course?data=JTdCJTIydGltZSUyMiUzQSUyMjIwMjAtMTItMTUrMTAlM0E1MCUzQTI5JTIyJTJDJTIya2V5JTIyJTNBJTIyOWJmMzFjN2ZmMDYyOTM2YTk2ZDNjOGJkMWY4ZjJmZjMlMjIlN0Q%3D';">more</div>
        </div>
    </div>
</div>
<div class="iceland-div">
    <div class="section pd_0 iceland-top">
        <img src="{{ $webPath }}assets/images/iceland/iceland-top.png" class="desktop-only">
        <img src="{{ $webPath }}assets/images/mobile/iceland-top1.png" class="mobile-only">
        <div class="container centered">
            <div class="row">
                <div class="text-div">
                    <div>
                        <p>這是一個協助我們拿到「愛自己的力量」深度之旅</p>
                        <p>生存在這個物質世界中，越來越多人渴望身心靈並重發展，大家都希望「關係和諧」，大家都希望「心想事成」，但是，總覺得缺少了那麼一點點，甚至不斷被外在環境衝擊，想要更多的清晰明白感覺卻感覺永無止境。我們多數人的生活都在重複同一個模式而不自知！我們都在童年時做了一些決定影響未來的模式而不自知！
                        </p>
                        <div class="more-link" style="cursor: pointer;" onclick="javascript:location.href='{{ $basePath }}course?data=JTdCJTIydGltZSUyMiUzQSUyMjIwMjAtMTItMTUrMTAlM0E1MCUzQTI5JTIyJTJDJTIya2V5JTIyJTNBJTIyOWJmMzFjN2ZmMDYyOTM2YTk2ZDNjOGJkMWY4ZjJmZjMlMjIlN0Q%3D';">more</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section pd_0 iceland-bottom desktop-only iceland-parent">
        <img id="iceland-img" onload="icelandResize()" src="{{ $webPath }}assets/images/iceland/iceland-bottom.png" width="100%">

        <?php foreach ($data['icelandArticleInfo'] as $icelandKey => $d){ ?>
        <div class="iceland-item">
            <?php 
                $shadow = 'shadow.png'; $class = ''; $link = '';
                if ($d->href){ $class = 'cursor-pointer'; $link = 'href=' . $d->href; }
                if ($icelandKey == 'icon-02'){ $shadow = 'shadow1.png'; }
            ?>

            <a {{ $link }}>
                <img src="{{ $basePath . $d->item_img }}" class="iceland-icon {{ $class }}" data-icon="{{ $icelandKey }}">
                <img src="{{ $webPath }}assets/images/iceland/{{ $shadow }}" class="iceland-shadow">
            </a>
            
            <?php if ($d->href){ ?>
            <div class="iceband-icon-text iceland-hide">
                <div>{{ $d->article_type_title }}</div>
                <div>{{ $d->myTitle }}<!-- <div class="numbers">2</div> --></div>
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        
    </div>
    <!-- END SECTION -->
    <div class="section pd_0 mobile-only">
        <img src="{{ $webPath }}assets/images/mobile/iceland-bottom1.png" name="icelandMapMobile" usemap="#icelandMapMobile"
            width="100%">
        <map name="icelandMapMobile">
            @foreach ($data['icelandArticleInfo'] as $icelandKey => $d)
                @if ($d->href)
                <area shape="rect" coords="{{ $d->position }}" alt="" href="{{ $d->href }}" class="iceland-map">
                @endif
            @endforeach
        </map>
    </div>
</div>

<style>
    .iceland-parent{
        position: relative;
    }

    .iceland-shadow{
        position: absolute;
        display: none;
    }

    .iceland-icon{
        position: absolute;
        z-index: 10;
        transition-duration: 0;
        display: none;
    }

    .cursor-pointer{
        cursor: pointer;
    }

    .iceband-icon-text{
        position: absolute;
        z-index: 20;
    }

    .description{
        background-color: #e5f2f9;
        padding-top: 2em;
        display: none;
        position: relative;
        z-index: 10;
    }

    .iceland-div .text-div{
        max-width: 39%;
    }

    @media (max-width: 1150px){
        .iceland-div{
            margin-top: -8em;
        }
        .iceland-div .text-div{
            display: none;
        }
        .description{
            display: block;
        }
    }

    @media (max-width: 991px){
        .iceland-div{
            margin-top: -5.4em;
        }
    }

    @media (max-width: 768px){
        .iceland-div{
            margin-top: 0;
        }
    }
</style>