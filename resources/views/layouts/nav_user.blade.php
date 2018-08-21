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
                {{--<li><a href="{{ route('login') }}">Login</a></li>--}}
                {{--<li><a href="{{ url('password/reset') }}">Forgot Password</a></li>--}}
                <!--Register-->
                <!--li><a href="{{ route('register') }}">Register</a></li-->
                    <!--Loged-->
                @else

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'order.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_order' ? "style=color:green" : "" }}
                        >
                            Order <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('order') }}">Check Order ID</a>
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

                @endguest
            </ul>
        </div>
    </div>
</nav>