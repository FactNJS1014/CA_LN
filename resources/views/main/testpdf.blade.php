<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- Include app.css --}}
    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('public/css/fonts.css') }}"> --}}
    @LaravelDompdfThaiFont
    <title>View Document</title>
    <style>
        body {
            font-family: 'THSarabunNew';
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .row {
            display: table;
            width: 100%;
        }

        .col {
            display: table-cell;
            width: 50%;
            padding: 10px;
        }

        #header-txt {
            color: red;
            font-size: 24pt;
            font-weight: bold;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;

        }
        td{
            font-size: 20px;
        }

        .label-cell {
            font-weight: bold;
            background-color: #f2f2f2;
            width: 50%;
        }

        .value-cell {
            color: red;
            font-weight: bold;

        }

        .header-container {
            border: 1px solid red;
            border-radius: 9px;

        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <td class="label-cell">วันที่เกิด:</td>
                        <td class="value-cell">03-Oct-24</td>
                    </tr>
                    <tr>
                        <td class="label-cell">ประวัติ Line:</td>
                        <td class="value-cell">GDA</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <div class="header-container">
                    <h1 id="header-txt">LINE CALL</h1>
                </div>
            </div>
            <div class="col">
                <table>
                    <tr>
                        <td class="label-cell">Issue No.</td>
                        <td class="value-cell">xxxxxxxxxxx</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="container">

    </div>

    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
