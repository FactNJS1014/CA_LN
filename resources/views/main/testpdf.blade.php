<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{-- Include app.css --}}
    <link rel="stylesheet" href="{{asset('public/css/app.css')}}">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/fonts.css') }}"> --}}
    @LaravelDompdfThaiFont
    <title>View Document</title>
    <style>

        body {
            font-family: 'THSarabunNew';        }

        #header-txt {
            color: red;
            font-size: 20pt;
            font-weight: bold;
        }



    </style>
</head>

<body>
    <table>
        <tr>
            <th>วันที่เกิด:</th>
            <th></th>
        </tr>
        <tr>
            <th>ประวัติ Line:</th>
            <th></th>
        </tr>
    </table>
    <span>
       LINECALL
    </span>




    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
