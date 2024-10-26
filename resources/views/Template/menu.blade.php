<?php
session_start();

if (!empty($_GET['username'])) {
    $_SESSION['username'] = $_GET['username'];
    $_SESSION['empno'] = $_GET['empno'];
    $_SESSION['department'] = $_GET['department'];
    $_SESSION['USE_PERMISSION'] = $_GET['USE_PERMISSION'];
    $_SESSION['sec'] = $_GET['sec'];
    $_SESSION['MSECT_ID'] = $_GET['MSECT_ID'];
    $per = $_GET['USE_PERMISSION'];
?>
<script>
    window.location.replace("http://web-server/41_calinecall/index.php");
</script>
<?php
}
if (empty($_SESSION['empno'])) {
    header('Location: http://web-server/menu.php');
    exit(0);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        {{-- csrf token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

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


                <span class="nav__name"><?php echo $_SESSION['username']; ?></span>

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
                            <span class="nav__name">Case and Active</span>
                        </a>

                        <a href="{{route('third')}}" class="nav__link" id="thirdpage">
                            <i class='bi bi-3-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Check Sheet Linecall</span>
                        </a>

                        <a href="{{route('four')}}" class="nav__link" id="fourthpage">
                            <i class='bi bi-4-square-fill' style="font-size: 19px;"></i>
                            <span class="nav__name">Reports</span>
                        </a>

                        {{-- <a href="#" class="nav__link">
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
        <script>
            var empno = '<?= $_SESSION['empno'] ?>';
            var username = '<?= $_SESSION['username'] ?>';
            var department = '<?= $_SESSION['department'] ?>';
            var sec = '<?= $_SESSION['sec'] ?>';
            var permission = '<?= $_SESSION['USE_PERMISSION'] ?>';
            var MSECT_ID = '<?= $_SESSION['MSECT_ID'] ?>';
            var server = '<?= $_SERVER['HTTP_HOST'] ?>';
        </script>

        <!--===== MAIN JS =====-->
        <script src="{{asset('public/js/app.js')}}"></script>
        <script src="{{asset('public/js/main.js')}}"></script>
        <script src="{{asset('public/js/moment.js')}}"></script>
        <script src="{{ asset('public/js/datatables.min.js') }}"></script>
        @stack('script')
    </body>
</html>
