@extends('Template/menu')
@section('title', 'Report')
@section('content')
    <h3 class="headerReports">Reports (รายงานแสดงข้อมูล)</h3>

    <div class="card pt-1">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="reportTable">
                <thead class="table-primary">
                    <tr>
                        <th>Document No.</th>
                        <th>Issue Date</th>
                        <th>Model Code</th>
                        <th>Work Order</th>
                        <th>Time Line Stop</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('script')
<script>
    $('#fourthpage').addClass('active');

    $.ajax({
        url: '{{route('show.report')}}',
        type: 'GET',
        success: function(response) {
            let show = '';
            response.rep.map((report) => {
                show += '<tr>';
                show += '<td>' + report.CA_DOCS_ID + '</td>';
                show += '<td>' + moment(report.CA_ISSUE_DATE).format('DD-MM-YYYY') + '</td>';
                show += '<td>' + report.CA_PROD_MDLCD + '</td>';
                show += '<td>' + report.CA_PROD_WON + '</td>';
                show += '<td>' + report.CA_PROD_TMPBF + '-' + report.CA_PROD_TMPBL +'</td>';
                show += '<td><button class="btn btnInclude" onclick=\'btnViewDoc("' + report.CA_LNREC_ID + '")\'><i class="bi bi-file-earmark-richtext-fill mx-2"></i>ดูเอกสาร</button></td>';
                show += '</tr>';
            })

            $('#reportTable tbody').html(show)
        }
    })

    btnViewDoc = (id) => {
        $.ajax({
            url: '{{route('generate.pdf')}}',
            type: 'GET',
            data: {id: id},
            xhrFields: {
                responseType: 'blob'
            },
            success: function(response) {
                var blob = new Blob([response], { type: 'application/pdf' });
                var url = window.URL.createObjectURL(blob);
                window.open(url, '_blank');
            },
            error: function(xhr, status, error) {
                console.error('Error generating PDF:', error);
            }
        });
    }


</script>
@endpush