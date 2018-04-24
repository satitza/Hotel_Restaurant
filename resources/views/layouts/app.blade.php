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
<!-- link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" -->
    <link href="{{ asset('css/bootstrap.3.css') }}" rel="stylesheet" type="text/css">
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
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/home') }}">
                <!-- {{ config('app.name', 'Laravel') }} -->
                    <div class="title m-b-md">
                        <img class="d-block w-50" src="{{ asset('/images/banner/logo-compass.png') }}" alt=""
                             width="135px">
                    </div>
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->


                    <!--Never Login-->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <!--Register-->
                    <!--li><a href="{{ route('register') }}">Register</a></li-->


                        <!--Loged-->
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Hotel <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('hotel') }}">Add Hotel</a>
                                </li>
                                <li>
                                    <a href="{{ url('hotel/create') }}">List Hotel</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Restaurant <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('restaurant') }}">Add Restaurant</a>
                                </li>
                                <li>
                                    <a href="{{ url('restaurant/create') }}">List Restaurant</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Offers <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('offer') }}">Add Offer</a>
                                </li>
                                <li>
                                    <a href="{{ url('offer/create') }}">List Offer</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Images <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('image') }}">Upload Images</a>
                                </li>
                                <li>
                                    <a href="{{ url('image/create') }}">List Images</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false"> Balance <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('balance/create') }}">List Balance</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                Report <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('list_request') }}">List All Booking Request</a>
                                </li>
                                <li>
                                    <a href="#">List All Booking Complete</a>
                                </li>
                            </ul>
                        </li>
                        <!----------------------------------------------------------------------------------------------------------------->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">Setting <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-submenu">
                                    <a class="submenu" tabindex="-1" href="#">User Manage<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('setting/users') }}">Add User</a></li>
                                        <li><a href="{{ url('setting/users/create') }}">List User</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="submenu" tabindex="-1" href="#">User Report Manage<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('setting/report/users') }}">Make Report User</a></li>
                                        <li><a href="{{ url('setting/report/users/create') }}">List Report User</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown-submenu">
                                    <a class="submenu" tabindex="-1" href="#">User Editor Manage<span
                                                class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('setting/editor/users') }}">Make Editor User</a></li>
                                        <li><a href="{{ url('setting/editor/users/create') }}">List Editor User</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!------------------------------------------------------------------------------------------------------------------->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <!--li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li-->
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
