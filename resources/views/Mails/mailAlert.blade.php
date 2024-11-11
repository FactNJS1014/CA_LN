<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        h3{
            color: #bf0603;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: "Pridi", serif;
            font-style: normal;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
            width: auto;
        }

        th {
            background-color: #f5cac3;
            color: black;

        }
        p{
            font-weight: bold;
            font-size: 18px;
        }

    </style>

</head>
<body>
    @foreach ($data as $item)
    <h3>In CA Production, a Line Call occurs.</h3>
    <p>Details: {{$item->TLSLOG_DETAIL}}</p>

    <table>
        <thead>
            <tr>
                <th>Line</th>
                <th>Time Line Call</th>
                <th>Minutes Line Call</th>
                <th>Work Order</th>
            </tr>
        </thead>
        <tbody>
            <tr>

                <td>{{$item->TSKH_MCLN}}</td>
                <td>{{$item->TLSLOG_FTIME}}</td>
                <td>{{$item->TLSLOG_TTLMIN}}</td>
                <td>{{$item->TSKH_WONO}}</td>
                    {{-- <p>There was a Line Call at (เกิด Line Call):&nbsp;<span>Line {{$item->TSKH_MCLN}}</span></p>
                    <p>Time when Line Call occurred (เวลาที่เกิด Line Call):&nbsp;<span>{{$item->TLSLOG_FTIME}}</span></p>
                    <p>Number of minutes Line Call lasted (จำนวนนาทีที่เกิด):&nbsp;<span>{{$item->TLSLOG_TTLMIN}}</span></p>
                    <p>Work Order:&nbsp;<span>{{$item->TSKH_WONO}}</span></p> --}}
            </tr>
        </tbody>
    </table>
    @endforeach


</body>
</html>
