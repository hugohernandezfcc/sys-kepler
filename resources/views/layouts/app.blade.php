<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

    <link href="{{ asset('inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('inspinia/css/style.css')}}" rel="stylesheet">
</head>


<body>
    <div id="app">
        <div id="wrapper">
            @include('leftmenu')
            <div id="page-wrapper" class="gray-bg dashbard-1">
                @include('topmenu')

                @yield('content')

                @include('footer')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Scripts Menú -->
    <script src="{{ asset('inspinia/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>


    <!-- Flot -->
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/flot/jquery.flot.time.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('inspinia/js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('inspinia/js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('inspinia/js/inspinia.js') }}"></script>
    <script src="{{ asset('inspinia/js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('inspinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{ asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <!-- EayPIE -->
    <script src="{{ asset('inspinia/js/plugins/easypiechart/jquery.easypiechart.js')}}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('inspinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('inspinia/js/demo/sparkline-demo.js')}}"></script>

</body>
</html>
