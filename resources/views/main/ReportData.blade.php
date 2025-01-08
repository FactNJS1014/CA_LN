@extends('Template/menu')
@section('title', 'Report')
@section('content')
    <h3 class="headerReports">Reports (รายงานแสดงข้อมูล)</h3>
    <p class="mt-3 text-primary" style="font-size: 18px; font-weight: 700;">**แสดงข้อมูลการบันทึกในส่วนที่ 1 หน้าแรก**</p>
    <div class="mt-2 card pt-1">
        <div class="card-body">
            <table class="table table-bordered table-striped w-100 nowrap" id="form_Table">
                <thead class="table-warning">
                    <tr>
                        <th style="width: 10px">วันที่กรอก</th>
                        <th style="width: 15px">หมายเลขเอกสาร</th>
                        <th>ผู้บันทึก</th>
                        <th style="width: 10px">Line</th>
                        <th>Process</th>
                        <th>Model Code</th>
                        <th>Work Order</th>
                        <th>Lot size</th>
                        <th>หัวข้อปัญหาที่เกิด</th>
                        <th>ระดับความรุนแรง</th>
                        <th>เวลาที่พบปัญหา</th>
                        <th>ผู้แจ้งปัญหา</th>
                        <th>รายละเอียดปัญหา</th>
                        <th>Q'ty</th>
                        <th>Acc/Lot</th>
                        <th>NG</th>
                        <th>Rate NG</th>

                    </tr>

                </thead>
                <tbody>

                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
    <p class="mt-3 text-primary" style="font-size: 18px; font-weight: 700;">**แสดงข้อมูลแบบเอกสาร PDF**</p>
    <div class="mt-2 card pt-1 mb-4">
        <div class="card-body">
            <table class="table table-bordered table-striped w-100 nowrap" id="reportTable">
                <thead class="table-primary">
                    <tr>
                        <th>Document No.</th>
                        <th>Issue Date</th>
                        <th>Model Code</th>
                        <th>Work Order</th>
                        <th>Time Line Stop</th>
                        <th>Action</th>
                        <th>Upload Document</th>
                        <th>View Document</th>
                        {{-- <th>Export Data</th> --}}
                    </tr>
                </thead>
                <tbody>

                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <p class="mt-3 text-primary" style="font-size: 18px; font-weight: 700;">**แสดงข้อมูล Export to Excel**</p>
    <div class="mt-2 card pt-1 mb-4">
        <div class="card-body">
            <table class="table table-bordered table-striped w-100 nowrap" id="exportTable">
                <thead class="table-su text-center">
                    <tr>
                        <th colspan="25" style="font-size: 22pt; color: red;">Leader Call Records</th>
                    </tr>
                    <tr>

                        <th rowspan="2">วันที่เกิด</th>
                        <th rowspan="2">Line No.</th>
                        <th rowspan="2">จุดที่ทำให้เกิดปัญหา</th>
                        <th rowspan="2">รายละเอียดปัญหา</th>
                        <th rowspan="2">NG Q'ty</th>
                        <th rowspan="2">ประเภทการเกิดของปัญหา เกิดใหม่/เกิดซ้ำ</th>
                        <th rowspan="2">ประเภทที่ต้องเรียก Line Call</th>
                        <th colspan="3">สำหรับแผนกที่รับผิดชอบ</th>
                        <th rowspan="2">จำนวน Case</th>
                        <th rowspan="2">Issue No.</th>
                        <th colspan="10">สำหรับแผนกที่ออกเอกสาร</th>
                        <th colspan="3">ผู้อนุมัติแต่ละแผนกที่รับผิดชอบ</th>
                    </tr>
                    <tr>
                        <th>สาเหตุ</th>
                        <th>การแก้ไขเบื้องต้น</th>
                        <th>การจัดการงานที่ผลิตก่อนหน้า/เหตุผล</th>
                        <th>Model</th>
                        <th>Work Order</th>
                        <th>เวลาที่ไลน์ stop</th>

                        <th>NG Rate</th>

                        <th>ระดับความรุนแรง</th>
                        <th>หัวข้อปัญหา</th>
                        {{-- <th>รูปภาพ</th> --}}
                        <th>ผู้แจ้งปัญหา</th>

                        <th>หมายเหตุ</th>

                        <th>ผู้ทำการตรวจสอบ</th>
                        <th>เวลา</th>
                        <th>แผนก Production CA</th>
                        <th>แผนก PE</th>
                        <th>แผนก QA / QC</th>
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
            url: '{{ route('show.report') }}',
            type: 'GET',
            success: function(response) {
                let show = '';
                response.rep.map((report) => {

                    show += '<tr>';
                    show += '<td style="color: #001F3F;">' + report.CA_DOCS_ID + '</td>';
                    show += '<td style="color: #001F3F;">' + moment(report.CA_ISSUE_DATE).format(
                        'DD-MM-YYYY') + '</td>';
                    show += '<td style="color: #001F3F;">' + report.CA_PROD_MDLCD + '</td>';
                    show += '<td style="color: #001F3F;">' + report.CA_PROD_WON + '</td>';

                    show += '<td style="color: #001F3F;">' + report.CA_PROD_TMPBF + '-' + report
                        .CA_PROD_TMPBL + '</td>';

                    show += '<td><button class="btn btnInclude" onclick=\'btnViewDoc("' + report
                        .CA_LNREC_ID +
                        '")\'><i class="bi bi-file-earmark-richtext-fill mx-2"></i>ดูเอกสาร</button></td>';
                    show += '<td><button class="btn btnExport" onclick=\'btnUpload("' + report
                        .CA_LNREC_ID +
                        '","' + report.CA_DOCS_ID +
                        '")\'><i class="bi bi-cloud-arrow-up-fill mx-2"></i>Upload File</button></td>';
                    if (report.CA_UPLOAD_FILE === '' || report.CA_UPLOAD_FILE === null) {
                        show += '<td>ยังไม่ได้อัพโหลด</td>'
                    } else {
                        show += '<td><button class="btn btnViewDoc" onclick=\'btnViewDocs("' + report
                            .CA_UPLOAD_FILE + '")\'>' + report.CA_UPLOAD_FILE + '</button></td>';
                    }

                    show += '</tr>';

                })

                if ($.fn.DataTable.isDataTable('table#reportTable')) {
                    $('#reportTable').DataTable().destroy();
                    $('#reportTable').empty();
                }

                $('#reportTable tbody').html(show)

                let table = $('#reportTable').DataTable({
                    paging: false,
                    searching: true,
                    info: false,
                    scrollX: false,
                    scrollCollapse: false,
                    scrollY: '30vh',
                    initComplete: function() {
                        var api = this.api();
                        var columns = api.columns();

                        // Create a row for search inputs below the header
                        var searchRow = $('<tr class="search-row"></tr>').appendTo($(api.table()
                            .header()).parent().find('thead'));

                        columns.every(function(colIndex) {
                            var column = this;
                            var title = column.header().textContent;

                            // Create the input element
                            var input = $('<input type="text" placeholder="' + title +
                                '" />');

                            // Append the input to the search row
                            var cell = $('<th></th>').append(input).appendTo(searchRow);

                            // Set the width of the input field to match the header column width
                            var headerCell = $(column.header());
                            cell.css('width', headerCell.width());

                            // Event listener for user input
                            input.on('keyup', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        });
                    }
                })
            }
        })

        $.ajax({
            url: '{{ route('show.form1') }}',
            type: 'GET',
            success: function(response) {
                let dt = '';
                response.data.map((data) => {
                    if (data.CA_PROD_FAXCOMPLETE == 0 && data.CA_CASEREC_STD == 0) {

                        // Find the corresponding MUSR_NAME from response.masterID based on CA_PROD_EMPREC and MUSR_ID
                        let matchingMaster = response.masterID.find(masterID => masterID.MUSR_ID ===
                            data
                            .CA_PROD_EMPREC);
                        let musrName = matchingMaster ? matchingMaster.MUSR_NAME :
                            'N/A'; // Default to 'N/A' if not found

                        // Add the table row with all necessary data
                        dt += '<tr>';
                        dt += '<td style="color: #001F3F;">' + moment(data.CA_ISSUE_DATE).format(
                            'DD-MM-YYYY') + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_DOCS_ID + '</td>';
                        dt += '<td style="color: #001F3F;">' + musrName + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_LINE + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_PROCS + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_MDLCD + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_WON + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_LOTS + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_PROBM + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_RANK + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_TMPBF + '-' + data
                            .CA_PROD_TMPBL + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_INFMR + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_DTPROB + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_QTY + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_ACCLOT + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_NG + '</td>';
                        dt += '<td style="color: #001F3F;">' + data.CA_PROD_RATE + '</td>';
                        // Add MUSR_NAME column

                        dt += '</tr>';
                    }
                });

                // Check if DataTable is initialized and destroy it if so
                if ($.fn.DataTable.isDataTable('table#form_Table')) {
                    $('#form_Table').DataTable().destroy();
                    $('#form_Table').empty();
                }

                // Insert the new rows into the table body
                $('#form_Table tbody').html(dt);

                // Reinitialize the DataTable
                let table = $('#form_Table').DataTable({
                    paging: false,
                    searching: true,
                    info: false,
                    scrollX: true,
                    scrollCollapse: true,
                    scrollY: '50vh',
                    initComplete: function() {
                        var api = this.api();
                        var columns = api.columns();

                        // Create a row for search inputs below the header
                        var searchRow = $('<tr class="search-row"></tr>').appendTo($(api.table()
                            .header()).parent().find('thead'));

                        columns.every(function(colIndex) {
                            var column = this;
                            var title = column.header().textContent;

                            // Create the input element
                            var input = $('<input type="text" placeholder="' + title +
                                '" />');

                            // Append the input to the search row
                            var cell = $('<th></th>').append(input).appendTo(searchRow);

                            // Set the width of the input field to match the header column width
                            var headerCell = $(column.header());
                            cell.css('width', headerCell.width());

                            // Event listener for user input
                            input.on('keyup', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        });
                    }

                });
                table.on('click', 'tbody tr', function() {
                    let data = table.row(this).data();
                    let show = '';
                    show += '<div class="row">'
                    show += '<div class="col-6">'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Date:&nbsp;<span style="font-weight: 500;">' +
                        data[0] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Document Number:&nbsp;<span style="font-weight: 500;">' +
                        data[1] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Line:&nbsp;<span style="font-weight: 500;">' +
                        data[3] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Process:&nbsp;<span style="font-weight: 500;">' +
                        data[4] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Model Code:&nbsp;<span style="font-weight: 500;">' +
                        data[5] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Work Order:&nbsp;<span style="font-weight: 500;">' +
                        data[6] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Lot Size:&nbsp;<span style="font-weight: 500;">' +
                        data[7] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Problem:&nbsp;<span style="font-weight: 500;">' +
                        data[8] + '</span></p>'
                    show += '</div>'
                    show += '<div class="col-6">'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Rank Level:&nbsp;<span style="font-weight: 500;">' +
                        data[9] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">เวลาที่พบปัญหา:&nbsp;<span style="font-weight: 500;">' +
                        data[10] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">ผู้แจ้งปัญหา:&nbsp;<span style="font-weight: 500;">' +
                        data[11] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Details:&nbsp;<span style="font-weight: 500;">' +
                        data[12] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Qty:&nbsp;<span style="font-weight: 500;">' +
                        data[13] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Acc/Lot:&nbsp;<span style="font-weight: 500;">' +
                        data[14] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">NG:&nbsp;<span style="font-weight: 500;">' +
                        data[15] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold;">Rate NG:&nbsp;<span style="font-weight: 500;">' +
                        data[16] + '</span></p>'
                    show +=
                        '<p style="font-size: 18px; font-weight: bold; color: #2c6e49;">ผู้บันทึก:&nbsp;<span style="font-weight: 500;">' +
                        data[2] + '</span></p>'
                    show += '</div>'
                    show += '</div>'

                    Swal.fire({
                        html: '<div style="text-align: left;" >' + show + '</div>',
                        showCancelButton: false,
                        showConfirmButton: false,
                        width: '60%',
                        showCloseButton: false,
                    })
                })
            }
        });


        btnViewDoc = (id) => {
            $.ajax({
                url: '{{ route('generate.pdf') }}',
                type: 'GET',
                data: {
                    id: id
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response) {
                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                    var url = window.URL.createObjectURL(blob);
                    // Open the PDF in a new tab by setting the URL directly
                    var newWindow = window.open(url, '_blank');
                    // Set the new window's URL to include the ID
                    newWindow.history.replaceState(null, '', '/view-pdf/' + id);
                    // Set a generic title for the new tab
                    newWindow.document.title = 'Report PDF';
                },
                error: function(xhr, status, error) {
                    console.error('Error generating PDF:', error);
                }
            });
        }



        $.ajax({
            url: '{{ route('show.report2') }}',
            type: 'GET',
            success: function(response) {
                console.log(response);
                let exp = '';
                let dataForExport = [];
                let arrId = [];
                response.rep2.map((ex, index) => {
                    if (arrId.includes(ex.CA_LNREC_ID) == false) {
                        arrId.push(ex.CA_LNREC_ID);
                        let indexplus_one = index + 1;
                        let indexplus_two = index + 2;
                        // console.log(index)
                        // console.log(indexplus_one)
                        // console.log(indexplus_two)
                        // console.log(response.rep2[indexplus_two])
                        let matchingMaster = response.masterID2.find(masterID2 => masterID2.MUSR_ID ===
                            ex.CA_CASEREC_EMPID);
                        let musrName2 = matchingMaster ? matchingMaster.MUSR_NAME :
                            'N/A';

                        let matchingMaster2 = response.masterID2.find(masterID3 => masterID3.MUSR_ID ===
                            ex.CA_EMPID_APPR);
                        let musrName3 = matchingMaster2 ? matchingMaster2.MUSR_NAME :
                            'N/A';

                        let matchingMaster3 = response.masterID2.find(masterID4 => masterID4.MUSR_ID ===
                            response.rep2[indexplus_one].CA_EMPID_APPR);
                        let musrName4 = matchingMaster3 ? matchingMaster3.MUSR_NAME :
                            'N/A';
                        let matchingMaster4 = response.masterID2.find(masterID5 => masterID5.MUSR_ID ===
                            response.rep2[indexplus_two].CA_EMPID_APPR);
                        let musrName5 = matchingMaster4 ? matchingMaster4.MUSR_NAME :
                            'N/A';
                        let imagePath = `{{ asset('public/images_ca/${ex.CA_PROD_IMAGE}') }}`;
                        exp += '<tr>';
                        exp += '<td>' + moment(ex.CA_ISSUE_DATE).format('DD-MM-YYYY') + '</td>';
                        exp += '<td>' + ex.CA_PROD_LINE + '</td>';
                        if (ex.CA_PROD_POINTPB !== null) {
                            exp += '<td>' + ex.CA_PROD_POINTPB + '</td>';
                        } else {
                            exp += '<td>ไม่มีข้อมูล</td>';
                        }
                        exp += '<td>' + ex.CA_PROD_DTPROB + '</td>';
                        exp += '<td>' + ex.CA_PROD_QTY + '</td>';
                        if (ex.CA_PROD_VCPB !== null) {
                            exp += '<td>' + ex.CA_PROD_VCPB + '</td>';
                        } else {
                            exp += '<td>ไม่มีข้อมูล</td>';
                        }
                        if (ex.CA_PROD_OCCUR !== null) {
                            exp += '<td>' + ex.CA_PROD_OCCUR + '</td>';
                        } else {
                            exp += '<td>ไม่มีข้อมูล</td>';
                        }
                        exp += '<td>' + ex.CA_PROD_CASE + '</td>';
                        exp += '<td>' + ex.CA_PROD_ACTIVE + '</td>';
                        if (ex.CA_PROD_WTHRSN !== null) {
                            exp += '<td>' + ex.CA_PROD_WTHRSN + '</td>';
                        } else {
                            exp += '<td>ไม่มีข้อมูล</td>';
                        }
                        if (ex.CA_PROD_CSNUM !== null) {
                            exp += '<td>' + ex.CA_PROD_CSNUM + '</td>';
                        } else {
                            exp += '<td>ไม่มีข้อมูล</td>';
                        }

                        exp += '<td>' + ex.CA_DOCS_ID + '</td>';
                        exp += '<td>' + ex.CA_PROD_MDLCD + '</td>';
                        exp += '<td>' + ex.CA_PROD_WON + '</td>';
                        exp += '<td>' + ex.CA_PROD_TMPBF + ' - ' + ex.CA_PROD_TMPBL + '</td>';

                        exp += '<td>' + ex.CA_PROD_RATE + '</td>';

                        exp += '<td>' + ex.CA_PROD_RANK + '</td>';
                        exp += '<td>' + ex.CA_PROD_PROBM + '</td>';
                        exp += '<td>' + ex.CA_PROD_INFMR + '</td>';
                        exp += '<td>' + ex.CA_PROD_NOTE + '</td>';
                        exp += '<td>' + musrName2 + '</td>';
                        exp += '<td>' + moment(ex.CA_CASEREC_LSTDT).format('DD-MM-YYYY') + '</td>';
                        exp += '<td>' + musrName3 + '</td>';
                        exp += '<td>' + musrName4 + '</td>';
                        exp += '<td>' + musrName5 + '</td>';
                        exp += '</tr>';
                    }
                });

                $('#exportTable tbody').html(exp);

                $('#exportTable').DataTable({
                    scrollX: true,
                    scrollCollapse: true,
                    responsive: false,
                    fixedHeader: true,
                    scrollY: '50vh',
                    fixedColumns: {
                        leftColumns: 1 // Adjust this to lock columns as needed
                    },
                    dom: 'Bfrtip', // Enables buttons
                    buttons: [{
                        extend: 'excelHtml5',
                        text: 'Excel',
                        className: 'btn-success',
                        exportOptions: {
                            charset: 'UTF-8',
                            bom: true // Byte Order Mark for UTF-8
                        },
                        title: function() {
                            const date = new Date();
                            const formattedDate = date.toISOString().slice(0,
                                10); // Format as YYYY-MM-DD
                            const dateFormat = moment(formattedDate).format('DD-MM-YYYY');
                            return 'Leader Call Records';
                        },
                        filename: function() {
                            const date = new Date();
                            const formattedDate = date.toISOString().slice(0,
                                10); // Format as YYYY-MM-DD
                            return 'Leader Call Records Date: ' + moment(formattedDate)
                                .format(
                                    'DD-MM-YYYY');
                        }
                    }]
                });

            }
        });

        btnUpload = (id, docid) => {
            console.log(id)
            console.log(docid)

            let frm_upload = '';
            frm_upload += '<form  method="post" enctype="multipart/form-data">';
            frm_upload += '@csrf'
            frm_upload += '<input type="file" name="_token" class="form-control" id="up_docs">';
            frm_upload += '</form>'

            Swal.fire({
                title: 'Upload File',
                html: frm_upload,
                showCancelButton: false,
                showConfirmButton: true,
                confirmButtonText: 'Upload',
                preConfirm: () => {
                    let file = $('#up_docs')[0].files[0];
                    if (!file) {
                        Swal.showValidationMessage('Please select a file.');
                        return false;
                    }
                    let formData = new FormData();
                    formData.append('docs', file);
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('id', id);
                    formData.append('doc_id', docid);

                    $.ajax({
                        url: '{{ route('upload.docs') }}',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            Swal.fire({
                                title: 'Success',
                                text: 'File uploaded successfully.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000

                            }).then(() => {
                                location.reload()
                            })
                        },
                        error: function(xhr, status, error) {
                            console.error('Error uploading file:', error);
                            Swal.fire({
                                title: 'Error',
                                text: 'Error uploading file.',
                                icon: 'error',
                                showConfirmButton: false,
                                timer: 1000
                            });
                        }
                    })
                }
            })
        }

        btnViewDocs = (docview) => {
            if (!docview) {
                alert('File name is missing.');
                return;
            }

            $.ajax({
                url: '{{ route('view.upload') }}', // Laravel route สำหรับตรวจสอบไฟล์
                method: 'GET',
                data: {
                    filename: docview,
                },
                success: function(response) {
                    if (response.exists) {
                        // เปิดหน้าต่างใหม่เพื่อดูไฟล์ PDF
                        const url = '../public/document_upload/' + docview;
                        const newWindow = window.open(url, '_blank');
                        if (!newWindow) {
                            alert('Please allow popups for this website.');
                        } else {
                            // เปลี่ยนชื่อ title ของหน้าต่างใหม่
                            newWindow.document.title = 'View Document: ' + docview;
                        }
                    } else {
                        alert('File not found.');
                    }
                },
                error: function() {
                    alert('An error occurred while checking the file.');
                }
            });
        };
    </script>
@endpush
