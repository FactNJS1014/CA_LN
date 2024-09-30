<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== BOX ICONS ===== -->

        <link href='{{asset('public/css/boxicons.css')}}' rel='stylesheet'>

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="{{asset('public/css/style.css')}}">

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
                        <a href="#" class="nav__link active">
                        <i class='bx bx-grid-alt nav__icon' ></i>
                            <span class="nav__name">Dashboard</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-user nav__icon' ></i>
                            <span class="nav__name">Users</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-message-square-detail nav__icon' ></i>
                            <span class="nav__name">Messages</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-bookmark nav__icon' ></i>
                            <span class="nav__name">Favorites</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-folder nav__icon' ></i>
                            <span class="nav__name">Data</span>
                        </a>

                        <a href="#" class="nav__link">
                            <i class='bx bx-bar-chart-alt-2 nav__icon' ></i>
                            <span class="nav__name">Analytics</span>
                        </a>
                    </div>
                </div>


            </nav>
        </div>

        @yield('content')
        <!--===== MAIN JS =====-->
        <script src="{{asset('public/js/app.js')}}"></script>
        <script src="{{asset('public/js/main.js')}}"></script>
    </body>
</html>
