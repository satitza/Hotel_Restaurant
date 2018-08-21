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

    @if(\Illuminate\Support\Facades\Auth::user()->user_role == 1)
          @include('layouts.navigation')
    @elseif(\Illuminate\Support\Facades\Auth::user()->user_role == 2)
        @include('layouts.nav_editor')
    @elseif(\Illuminate\Support\Facades\Auth::user()->user_role == 3)
        @include('layouts.nav_report')
    @elseif(\Illuminate\Support\Facades\Auth::user()->user_role == 4)
        @include('layouts.nav_user')
    @endif

    @yield('content')

</div>
<script src="{{ asset('js/app.js') }}"></script>
</body>
@include('layouts.footer')
</html>