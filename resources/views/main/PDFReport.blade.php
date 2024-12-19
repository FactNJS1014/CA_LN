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
            font-size: 24px;
        }

        .value-cell {
            color: black;
            font-weight: bold;
            width: 100%;
            font-size: 20px;
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
        .text-rotate {
            color: #133E87;
        }
        .text-con{
            font-size: 20px;
            color: red;
            font-weight: bold;
        }

        .text-con2{
            font-size: 20px;
            color: red;
            font-weight: bold;
            margin-top: 69px;
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
                        <td class="label-cell" rowspan="2">Issue No.</td>
                        <td class="value-cell" rowspan="2">{{$item->CA_DOCS_ID}}</td>

                    </tr>
                    <tr>
                        <td class="label-cell">ประวัติ Line:</td>
                        <td class="value-cell">{{$item->CA_PROD_LINE}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell" rowspan="5">สำหรับแผนกที่ออกเอกสาร</td>
                        <td class="value-cell">Model:&nbsp;{{$item->CA_PROD_MDLCD}}</td>
                        <td class="value-cell">Lot size:&nbsp;{{$item->CA_PROD_ACCLOT}}</td>
                        <td class="value-cell">ผู้แจ้งปัญหา:&nbsp;{{$item->CA_PROD_INFMR}}</td>
                    </tr>
                    <tr>
                        <td class="value-cell">Work Order:&nbsp;{{$item->CA_PROD_WON}}</td>
                        <td class="value-cell">หัวข้อปัญหา:&nbsp;{{$item->CA_PROD_PROBM}}</td>
                        <td class="value-cell">ระดับความรุนแรง:&nbsp;{{$item->CA_PROD_RANK}}</td>
                    </tr>
                    <tr>
                        <td class="value-cell">เวลาที่ไลน์ stop:&nbsp;{{$item->CA_PROD_TMPBF}}-{{$item->CA_PROD_TMPBL}}</td>
                        @if (!empty($item->CA_PROD_IMAGE))
                        <td class="value-cell" rowspan="3" colspan="2"><img src="{{ asset('public/images_ca/' . $item->CA_PROD_IMAGE) }}" alt="Document Image" class="img-fluid" style="max-height: 200px; max-width: 100%;" accept="image/png,image/jpg,image/webp" />
                        </td>
                        @else
                        <td class="value-cell" rowspan="3" colspan="2"><img src="{{ asset('public/image/No-image.jpg')}}" alt="Document Image" class="img-fluid" style="max-height: 200px; max-width: 100%;" accept="image/png,image/jpg,image/webp" />
                        </td>
                        @endif
                    </tr>
                    <tr>
                        <td class="value-cell">NG Q'ty / NG Rate :&nbsp;{{$item->CA_PROD_QTY}} / {{$item->CA_PROD_RATE}}</td>
                    </tr>
                    <tr>
                        <td class="value-cell">รายละเอียด:<br>{{$item->CA_PROD_DTPROB}}</td>
                    </tr>
                    <tr>
                        <td class="label-cell" rowspan="2">สำหรับแผนกที่ผู้รับผิดชอบ</td>
                        <td class="value-cell" >สาเหตุการเกิด:<br>{{$item->CA_PROD_CASE}}</td>
                        <td class="value-cell" >การแก้ไขเบื้องต้น:<br>{{$item->CA_PROD_ACTIVE}}</td>
                        <td class="value-cell" rowspan="2" style="font-size: 22px;">PIC Date:&nbsp;{{ date('d-M-Y', strtotime($item->CA_CASEREC_LSTDT)) }}</td>
                    </tr>
                    <tr>
                        <td class="value-cell">หมายเหตุ:<br>{{$item->CA_PROD_NOTE}}</td>
                        @php
                            // Find the user directly
                            $matchedUser = $user->firstWhere('MUSR_ID', $item->CA_CASEREC_EMPID);
                        @endphp
                        @if ($matchedUser)
                            <td class="value-cell">ผู้ทำการตรวจสอบ: {{$matchedUser->MUSR_NAME}}</td>
                        @else
                            <td class="value-cell">ผู้ทำการตรวจสอบ: ไม่พบข้อมูล</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="label-cell" rowspan="2">รายชื่อผู้อนุมัติ</td>
                        <td class="label-cell text-center">Production CA</td>
                        <td class="label-cell text-center">PE</td>
                        <td class="label-cell text-center">QA & QC</td>

                    </tr>
                    <tr>
                        @foreach ($recapp as $app)
                        @php
                            $name_status = false;
                        @endphp
                        @foreach ($user as $name)
                        @if ($app->CA_EMPID_APPR == $name->MUSR_ID)
                            <td class="value-cell" style="text-align: center; color: #347928;">{{$name->MUSR_NAME}}</td>
                            @php
                                $name_status = true;
                            @endphp
                        @endif
                        @endforeach
                        {{-- Check if no name was found --}}
                        @if (!$name_status)
                            <td class="value-cell" style="text-align: center; color: #347928;">ไม่มีชื่อ</td>
                        @endif
                        @endforeach

                    </tr>

                </table>
            </div>

        </div>
        @endforeach
    </div>




    <script src="{{ asset('public/js/app.js') }}"></script>
</body>

</html>
