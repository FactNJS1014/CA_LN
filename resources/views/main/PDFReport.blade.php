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
            width: 100%;
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
            font-size: 20px;
        }

        .value-cell {
            color: red;
            font-weight: bold;
            width: 100%;
        }

        .header-container {
            border: 1px solid red;
            border-radius: 9px;

        }
        .docs{
            font-size: 20px;
            font-weight: bold;
            text-align: center;
        }
        span{
            font-size: 20px;
            color: red;
            font-weight: bold;
        }

        .txt-content{
            font-size: 20px;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <div class="container">
        @foreach ($report as $item)

        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <td class="label-cell">วันที่เกิด:</td>
                        <td class="value-cell">{{ date('d-M-Y', strtotime($item->CA_ISSUE_DATE)) }}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">ประวัติ Line:</td>
                        <td class="value-cell">{{$item->CA_PROD_LINE}}</td>
                    </tr>
                    {{-- <tr>
                        <td class="label-cell">Issue No.</td>
                        <td class="value-cell">{{$item->CA_DOCS_ID}}</td>
                    </tr> --}}
                </table>
            </div>
            <div class="col">
                <div class="header-container">
                    <h1 id="header-txt">LINE CALL</h1>
                </div>
                <p class="docs">Document No. &nbsp;<span>{{$item->CA_DOCS_ID}}</span></p>
            </div>
            {{-- <div class="col">
                <table>
                    <tr>
                        <td class="label-cell">Issue No.</td>
                        <td class="value-cell" style="font-size: 16px;">{{$item->CA_DOCS_ID}}</td>
                    </tr>
                </table>
            </div> --}}
        </div>
    </div>
    @endforeach

    <div class="container">
        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <td class="label-cell">Model Code</td>
                        <td class="value-cell">{{$item->CA_PROD_MDLCD}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Work Order</td>
                        <td class="value-cell">{{$item->CA_PROD_WON}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">เวลาที่ไลน์ Stop</td>
                        <td class="value-cell">{{$item->CA_PROD_TMPBF}} - {{$item->CA_PROD_TMPBL}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">NG QTY  <br> NG Rate</td>
                        <td class="value-cell">NG QTY = {{$item->CA_PROD_QTY}} pcs. <br> NG Rate = {{$item->CA_PROD_RATE}} %</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <table>
                    {{-- <tr>
                        <td class="label-cell">ระดับการแจ้งปัญหา</td>
                        <td class="value-cell">ggg</td>
                    </tr> --}}
                    <tr>
                        <td class="label-cell">หัวข้อปัญหาที่เกิด</td>
                        <td class="value-cell">{{$item->CA_PROD_PROBM}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell">ผู้แจ้ง Line Call</td>
                        <td class="value-cell">{{$item->CA_PROD_INFMR}}</td>
                    </tr>


                </table>
                <table style="margin-top: 5px;">
                    <tr>
                        <th class="label-cell" style="text-align: center;">รูปภาพ</th>
                        <td class="value-cell"><img src="{{ asset('public/images_ca/' . $item->CA_PROD_IMAGE) }}" alt="Document Image" class="img-fluid" style="max-height: 200px; max-width: 100%;" /></td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <table class="no-collapse">
                    <tr>
                        <th class="label-cell">สาเหตุการเกิด</th>
                        <td class="value-cell">{{$item->CA_PROD_CASE}}</td>
                    </tr>
                    <tr>
                        <th class="label-cell">การแก้ไขเบื้องต้น</th>
                        <td class="value-cell">{{$item->CA_PROD_ACTIVE}}</td>
                    </tr>
                    <tr>
                        <th class="label-cell">PIC & Action Date</th>
                        <td class="value-cell"></td>
                    </tr>
                    <tr>
                        <th class="label-cell">หมายเหตุ</th>
                        <td class="value-cell">{{$item->CA_PROD_NOTE}}</td>
                    </tr>

                </table>
                {{-- <p class="txt-content">สาเหตุการเกิด:&nbsp;<span>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet facilis reiciendis voluptatem veniam quam pariatur tempora, dolore deserunt saepe aliquid! Ipsam dolore molestias nesciunt aliquid corporis odit culpa dolorum? Sit.</span></p> --}}
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <div class="col">
                <table>
                    <tr>
                        <th class="label-cell" style="text-align: center; padding-top: 2px;">Sub-Leader</th>
                        <th class="label-cell" style="text-align: center; padding-top: 2px;">Supervisor</th>
                        <th class="label-cell" style="text-align: center; padding-top: 2px;">QA</th>
                    </tr>
                    <tr>
                        <td class="value-cell" style="height: 60px; padding-top: 20px;"></td>
                        <td class="value-cell" style="height: 60px; padding-top: 20px;"></td>
                        <td class="value-cell" style="height: 60px; padding-top: 20px;"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
