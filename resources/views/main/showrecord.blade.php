@extends('Template/menu')
@section('title', 'ตรวจสอบข้อมูล')
@section('content')

    <div class="container-fluid p-1">
        <div class="card-show" id="card-show"></div>
    </div>
@endsection

@push('script')
    <script>
        $('#thirdpage').addClass('active');

        $.ajax({
            url: '{{route('show.data')}}',
            type: 'GET',
            success: function(response) {
                console.log(response);
                let card = '';
                let data = response.show_record;
                data.map((res) => {
                    // Create a unique ID using the document ID
                    let uniqueTableId = `table-data-${res.CA_DOCS_ID}`;
                    card += `
                        <div class="card mt-3 mb-3">
                            <div class="card-title p-2">
                                <h5><i class="bi bi-postcard-fill mx-3"></i>หมายเลขเอกสาร (Document Number) : ${res.CA_DOCS_ID}</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered nowrap w-100" id="${uniqueTableId}">
                                    <thead class="table-info">
                                        <tr>
                                            <th scope="col">Issue Date</th>
                                            <th scope="col">Line</th>
                                            <th scope="col">Process</th>
                                            <th scope="col">Model Code</th>
                                            <th scope="col">Work Order</th>
                                            <th scope="col">Lot Size</th>
                                            <th scope="col">Problem Heading</th>
                                            <th scope="col">Rank</th>
                                            <th scope="col">Time Start</th>
                                            <th scope="col">Time End</th>
                                            <th scope="col">Information Person</th>
                                            <th scope="col">QTY</th>
                                            <th scope="col">ACC/LOT</th>
                                            <th scope="col">NG</th>
                                            <th scope="col">RATE (%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${moment(res.CA_ISSUE_DATE).format('DD-MM-YYYY')}</td>
                                            <td>${res.CA_PROD_LINE}</td>
                                            <td>${res.CA_PROD_PROCS}</td>
                                            <td>${res.CA_PROD_MDLCD}</td>
                                            <td>${res.CA_PROD_WON}</td>
                                            <td>${res.CA_PROD_LOTS}</td>
                                            <td>${res.CA_PROD_PROBM}</td>
                                            <td>${res.CA_PROD_RANK}</td>
                                            <td>${res.CA_PROD_TMPBF}</td>
                                            <td>${res.CA_PROD_TMPBL}</td>
                                            <td>${res.CA_PROD_INFMR}</td>
                                            <td>${res.CA_PROD_QTY}</td>
                                            <td>${res.CA_PROD_ACCLOT}</td>
                                            <td>${res.CA_PROD_NG}</td>
                                            <td>${res.CA_PROD_RATE}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="row mt-3">
                                    <p class="col-md-2" id="prbtext">รายละเอียดปัญหา : </p>
                                    <p class="col-md-12 details1"><i class="bi bi-file-text-fill mx-2"></i>${res.CA_PROD_DTPROB}</p>
                                </div>
                                <div class="row mt-3">
                                    <p class="col-md-2" id="casetext">สาเหตุการเกิด : </p>
                                    <p class="col-md-12 details2"><i class="bi bi-file-text-fill mx-2"></i>${res.CA_PROD_CASE}</p>
                                </div>
                                <div class="row mt-3">
                                    <p class="col-md-2" id="acttext">การแก้ไขปัญหา : </p>
                                    <p class="col-md-12 details3"><i class="bi bi-pen-fill mx-2"></i>${res.CA_PROD_ACTIVE}</p>
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <div class="d-flex justify-content-between">
                                    <!-- Buttons on the left -->
                                    <div>
                                        <button type="button" class="btn btnapr" onclick="aprbtn('${res.CA_LNREC_ID}')">
                                            Confirm Data <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btnedit" onclick="editbtn('${res.CA_LNREC_ID}')">
                                            <i class="bi bi-pencil-square mx-2"></i>แก้ไขข้อมูล
                                        </button>
                                        <button type="button" class="btn btnrej" onclick="rejbtn('${res.CA_LNREC_ID}')">
                                            <i class="bi bi-arrow-left-circle-fill mx-2"></i>Reject
                                        </button>
                                    </div>

                                    <!-- Button on the right -->
                                    <div>
                                        <button type="button" class="btn btndel" onclick="delbtn('${res.CA_LNREC_ID}')">
                                            <i class="bi bi-trash3-fill mx-2"></i>Delete
                                        </button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    `;
                });
                $('#card-show').html(card);

                data.map((res) => {
                    let uniqueTableId = `table-data-${res.CA_DOCS_ID}`;
                    // Check if DataTable exists and destroy it before reinitializing
                    if ($.fn.DataTable.isDataTable(`#${uniqueTableId}`)) {
                        $(`#${uniqueTableId}`).DataTable().destroy();
                    }
                    $(`#${uniqueTableId}`).DataTable({
                        paging: false,
                        searching: false,
                        info: false,
                        scrollX: true,
                    });
                });
            }
        });

        aprbtn =(id) =>{
            console.log(id);
        }

    </script>
@endpush
