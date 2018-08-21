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

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'hotel.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'hotel.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'hotel.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_hotel' ? "style=color:green" : "" }}
                        >
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
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'restaurant.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'restaurant.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'restaurant.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_restaurant' ? "style=color:green" : "" }}
                        >
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
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'offer.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'offer.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'offer.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_offer' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'image.upload' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'image.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'upload_image' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'list_term' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'insert_term' ? "style=color:green" : "" }}

                                {{ Request::route()->getName() == 'edit_term_th' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'edit_term_en' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'edit_term_cn' ? "style=color:green" : "" }}
                        >
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

                    {{--<li class="dropdown">--}}
                    {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"--}}
                    {{--aria-expanded="false">--}}
                    {{--Images <span class="caret"></span>--}}
                    {{--</a>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li>--}}
                    {{--<a href="{{ url('image') }}">Upload Images</a>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                    {{--<a href="{{ url('image/create') }}">List Images</a>--}}
                    {{--</li>--}}
                    {{--</ul>--}}
                    {{--</li>--}}

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'balance.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'balance.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'balance.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_balance' ? "style=color:green" : "" }}
                        > Balance <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('balance/create') }}">List Balance</a>
                            </li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'list_pending' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'report.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'report.list' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'report.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'search_report' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'view_voucher' ? "style=color:green" : "" }}
                        >
                            Report <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ url('booking_pending') }}">List All Booking Pending</a>
                            </li>
                            <li>
                                <a href="{{ url('report') }}">List All Booking Complete</a>
                            </li>
                        </ul>
                    </li>
                    <!----------------------------------------------------------------------------------------------------------------->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                           aria-expanded="false"
                                {{ Request::route()->getName() == 'users.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'users.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'users.edit' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'items.index' ? "style=color:green" : "" }}

                                {{ Request::route()->getName() == 'currency.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'currency.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'currency.edit' ? "style=color:green" : "" }}

                                {{ Request::route()->getName() == 'rate_suffix.index' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'rate_suffix.create' ? "style=color:green" : "" }}
                                {{ Request::route()->getName() == 'rate_suffix.edit' ? "style=color:green" : "" }}

                        >Setting <span class="caret"></span></a>
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
                            <li class="dropdown-submenu">
                                <a class="submenu" tabindex="-1" href="#">Disabled Items Manage<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('setting/item/items') }}">View All Items Disabled</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="submenu" tabindex="-1" href="#">Currency<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('setting/currencies/currency') }}">Add Currency</a></li>
                                    <li><a href="{{ url('setting/currencies/currency/create') }}">List Currency</a></li>
                                </ul>
                            </li>
                            <li class="dropdown-submenu">
                                <a class="submenu" tabindex="-1" href="#">Rate Suffix<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('setting/rate_suffixes/rate_suffix') }}">Add Rate Suffix</a>
                                    </li>
                                    <li><a href="{{ url('setting/rate_suffixes/rate_suffix/create') }}">List Rate
                                            Suffix</a></li>
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