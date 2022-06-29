<!doctype html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
    <meta charset="utf-8">
    <meta id="csrf-token" content="{{ csrf_token() }}" />
    
    @section('title')
        <title>{{ config('app.name') }} | Home</title>
    @show
    

    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/common.css') }}">
    @stack('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/frontend/fonts/fonts.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    @routes
    <script type="text/javascript">
        function getDate(days) {
            var monthNames = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");
            var now = new Date();
            now.setDate(now.getDate() + days);
            var nowString = monthNames[now.getMonth()] + " " + now.getDate() + ", " + now.getFullYear();
            document.write(nowString);
        }
    </script>
    <style>
        li.parsley-required {
            color: red;
            font-size: 12px;
            text-align: center;
            margin-left: 16px;
        }
    </style>
    
</head>

<body id="top">

    @yield('content')

    <script type="text/javascript" src="{{ asset('assets/frontend/js/jquery-1.10.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/js/bookmarkscroll.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/frontend/js/jquery.fancybox.js') }}"></script>
    <script>
        $.ajaxSetup({
            headers:{
                "X-CSRF-TOKEN": $('#csrf-token').attr('content')
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
