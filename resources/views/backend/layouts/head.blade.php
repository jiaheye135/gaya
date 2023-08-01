<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <title>LE BACKSTAGE</title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ $webPath }}assets/images/favicon.png">
    <!-- Custom fonts for this template-->
    <link href="{{ $webPath }}assets/fontawesome/css/all.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ $webPath }}assets/css/style.css??v=1.01" rel="stylesheet">
    <!-- dataTables -->
    <link href="{{ $webPath }}assets/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- fixedColumns -->
    <link href="{{ $webPath }}assets/datatables/fixedColumns.bootstrap4.min.css" rel="stylesheet">

    <!-- my -->
    <link href="{{ $publicPath }}base/css/my.css" rel="stylesheet">

    <!-- js -->
    <script src="{{ $webPath }}assets/js/jquery.min.js?"></script>

    <script>
        var gBasePath   = "{{ $basePath }}";
        var gPublicPath = "{{ $publicPath }}";
    </script>
</head>