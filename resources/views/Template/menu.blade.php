<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">


        {{-- Include app.css --}}
        <link rel="stylesheet" href="{{asset('public/css/app.css')}}">

        <!-- ===== BOX ICONS ===== -->
        <link href='{{asset('public/css/boxicons.css')}}' rel='stylesheet'>

        {{-- Bootstrap-icons --}}
        <link href='{{asset('public/css/icon.css')}}' rel='stylesheet'>

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
        <link rel="shortcut icon" href="{{asset('public/icons/15916.jpg')}}" type="image/x-icon">
        <title>@yield('title')</title>
    </head>
    <body id="body-pd">
        <header class="header" id="header">
            <div class="header__toggle">
                <i class='bx bx-menu' id="header-toggle"></i>
            </div>


                <span class="nav__name">Natdanai Jansomboon</span>

        </header>

        <div class="l-navbar" id="nav-bar">
            <nav class="nav">
                <div>


                    <div class="nav__list">
                        <a href="{{route('main')}}" class="nav__link" id="firstpage">
                        <i class='bi bi-1-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Sheet Record</span>
                        </a>

                        <a href="{{route('second')}}" class="nav__link" id="secondpage">
                            <i class='bi bi-2-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Check Line Call</span>
                        </a>

                        {{-- <a href="#" class="nav__link" id="">
                            <i class='bi bi-3-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Messages</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bi bi-4-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Favorites</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bi bi-5-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Data</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bi bi-6-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Analytics</span>
                        </a> --}}
                    </div>
                </div>


            </nav>
        </div>


        @yield('content')


        <!--===== MAIN JS =====-->
        <script src="{{asset('public/js/app.js')}}"></script>
        <script src="{{asset('public/js/main.js')}}"></script>
        @stack('script')
    </body>
</html>
