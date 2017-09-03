<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta >

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}  -  @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/autocomplete-styles.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet">

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">



    @yield('styles')
</head>
<body>
    <div id="app">
        <header class="clearfix">
        <nav class="navbar navbar-default navbar-fixed-top"     role="navigation">

            <div class="top-line">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <ul class="info-list">

                                <li>
                                    <i class="fa fa-envelope"></i>
                                    E-mail : <span>inventory@support.com</span>
                                </li>
                                <li>
                                    <i class="fa fa-phone"></i>
                                    Call us:
                                    <span>+256 787 334 3434</span>
                                </li>
                                
                                <li>
                                    <i class="fa fa-clock-o"></i>
                                    working time:
                                    <span>08:00 - 17:00</span>
                                </li>

                            </ul>
                        </div>
                        <div class="col-md-4">
                            <ul class="social-icons">
                                <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a class="google" href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                                <li><a class="dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



            <div class="container main-nav">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('assets/images/logos/invt.png') }}" style="width: 80px; height: 60px">
                        {{ config('app.name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">



                        <li><a href="{{ route("items.index") }}"><i class="fa fa-ticket"></i> Items</a></li>

                        {{--<li class="dropdown">--}}
                            {{--<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">--}}
                                {{--<i class="fa fa-filter"> </i>  Categories <span class="caret"></span>--}}
                            {{--</a>--}}
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li>--}}
                                    {{--<a href="">PHONE</a>--}}

                                {{--</li>--}}

                                {{--<li>--}}
                                    {{--<a href="">CAMERA</a>--}}

                                {{--</li>--}}

                                {{--<li>--}}
                                    {{--<a href="">TABLETS</a>--}}

                                {{--</li>--}}

                                {{--<li>--}}
                                    {{--<a href="">CAMERA</a>--}}

                                {{--</li>--}}




                            {{--</ul>--}}
                        {{--</li>--}}



                        @if (Auth::guest())


                            <li><a href="{{ route('login') }}">Login</a></li>

                            <li><a href="{{ route('register') }}">Sign Up</a></li>

                        @else


                                @if(\App\Utility\Utils::isAdmin())

                                <li><a href="{{ route("assign.list") }}"><i class="fa fa-bookmark-o"></i> Assigned Items</a></li>


                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            <i class="fa fa-user-circle"> </i>  {{ Auth::user()->getName() }} <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ route('users.edit', Auth::user()->slug) }}"><i class="fa fa-user"></i> User Profile</a>

                                            </li>

                                            <li class="divider"></li>

                                            <li>
                                                <a href="{{ url('/admin') }}">
                                                    <i class="fa fa-server"></i>  Dashboard
                                                </a>
                                            </li>

                                            <li class="divider"></li>

                                            <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                    <i class="fa fa-sign-out"></i> Logout
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>


                                        </ul>
                                    </li>


                                @elseif(\App\Utility\Utils::isSimpleUser())
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-user-circle"> </i>  {{ Auth::user()->name() }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('users.edit', Auth::user()->slug) }}"><i class="fa fa-user"></i> User Profile</a>
                                        </li>

                                        <li class="divider"></li>

                                        <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <i class="fa fa-sign-out"></i> Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>


                                    </ul>
                                </li>
                                @endif




                        @endif

                    </ul>
                </div>
            </div>
        </nav>
    </header>

        <div class="all-content">

                <div class="container">
                    @yield('content')
                </div>

                <br>
                <!-- footer
    ================================================== -->
                    <footer>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="contact-info">
                                        <h2><i class="fa fa-location-arrow"></i> Our Address</h2>
                                        <p>Inventory Control 7800 Queen Street,</br>City World, US49 Kampala, UG.</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="contact-info">
                                        <h2><i class="fa fa-envelope-o"></i> Contact Us</h2>
                                        <p>+1 223 334 3434 <br> info@inventorycontrol.com</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="contact-info">
                                        <h2><i class="fa fa-clock-o"></i> Office hours</h2>
                                        <p>Monday to Friday: 8:00 - 17:00 <br> Saturday, Sunday: 9:00 - 14:00</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </footer>
                    <!-- End footer -->
            </div>

        </div>






    <!-- Scripts -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.autocomplete.min.js') }}"></script>
    <script>
        $(document).ready(function () {

            $('#search_auto_complete').autocomplete({
                serviceUrl: '/search_data'
            });
        });

    </script>


    @yield('scripts')


</body>
</html>
