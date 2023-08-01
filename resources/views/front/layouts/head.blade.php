<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="生命探索">
    <meta name="keywords" content="生命探索">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <!-- SITE TITLE -->
    <title>{{ $webTitle }}</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ $webPath }}assets/images/favicon.png">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ $webPath }}assets/bootstrap/css/bootstrap.min.css?">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ $webPath }}assets/css/all.min.css">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ $webPath }}assets/owlcarousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ $webPath }}assets/owlcarousel/css/owl.theme.css">
    <link rel="stylesheet" href="{{ $webPath }}assets/owlcarousel/css/owl.theme.default.min.css">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ $webPath }}assets/css/slick.css">
    <link rel="stylesheet" href="{{ $webPath }}assets/css/slick-theme.css">
    <!--Light Box CSS-->
    <link rel="stylesheet" href="{{ $webPath }}assets/css/lightbox.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ $webPath }}assets/css/ekko-lightbox.css">
    <link rel="stylesheet" href="{{ $webPath }}assets/css/jo_style.css?v=1.21">

    <!-- jQuery -->
    <script src="{{ $webPath }}assets/js/jquery-3.5.1.min.js"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-WH0XCESKEV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-WH0XCESKEV');
    </script>

    <!-- Hotjar Tracking Code for life-explore.com.tw/ -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:2274675,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
</head>