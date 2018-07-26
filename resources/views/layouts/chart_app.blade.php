<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Compass Hospitality Laravel </title>

    <!-- Styles -->
    {{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">--}}
    <link href="{{ asset('css/bootstrap.3.3.7.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css">

    <!-- Script -->
    <script src="{{ asset('jquery/jquery.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/ckeditor.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.dropdown-submenu a.submenu').on("click", function (e) {
                $(this).next('ul').toggle();
                e.stopPropagation();
                e.preventDefault();
            });
        });
    </script>
</head>
<body>
<div id="app">
    @include('layouts.navigation')
    @yield('content')
</div>

</body>
@include('layouts.footer')
</html>