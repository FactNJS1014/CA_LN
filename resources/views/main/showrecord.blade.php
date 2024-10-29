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
            url: '{{ route('show.data') }}',
            type: 'GET',
            success: function(response) {
                //console.log(response);
                let card = '';
                let data = response.show_record;

                data.map((res) => {
                    const matchdata = String(response.match)
                    const matcharray = matchdata.split(',')
                    console.log(matcharray)
                    if(matcharray.includes(empno)){
                        let uniqueTableId = `table-data-${res.CA_DOCS_ID}`;
                            let imagePath = `{{ asset('public/images_ca/${res.CA_PROD_IMAGE}') }}`;
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
                                <div class="row mt-3">
                                    <p class="col-md-2" id="acttext">หมายเหตุ : </p>
                                    <p class="col-md-12 details3"><i class="bi bi-pen-fill mx-2"></i>${res.CA_PROD_NOTE}</p>
                                </div>

                                <div class="text-center mb-3">
                                     <p class="" id="imgtext">รูปภาพ : </p>
                                    <img src="${imagePath}" alt="Document Image" class="img-fluid" style="max-height: 200px; max-width: 100%;" />
                                </div>
                                ${res.CA_LNRJ_STD == 1 ?  `
                                <div class="row mt-3">
                                    <p class="col-md-3" id="acttext"> Comment จากการถูกส่งกลับ : </p>
                                    <p class="col-md-12 details3"><i class="bi bi-chat-left-text-fill mx-2"></i>${res.CA_LNRJ_REMARK}</p>
                                </div>
                                `: ''}
                            </div>
                            <div class="card-footer p-2">
                                <div class="d-flex justify-content-between">
                                    <!-- Buttons on the left -->
                                    <div>
                                        <button type="button" class="btn btnaprlv" onclick="aprlvbtn('${res.CA_LNREC_ID}')">
                                            อนุมัติ<i class="bi bi-arrow-right-circle-fill ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btnedit" onclick="editbtn('${res.CA_LNREC_ID}','${res.CA_DOCS_ID}','${res.TLSLOG_TSKNO}','${res.TLSLOG_TSKLN}')">
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
                    }else {
                        console.log(
                            "empno not found in matchArray. Card not displayed."
                        ); // Optional: Log for debugging
                    }



                    //Permission ผู้ที่บันทึก

                        if (res.CA_PROD_TRACKING == 0) {
                            // Create a unique ID using the document ID
                            let uniqueTableId = `table-data-${res.CA_DOCS_ID}`;
                            let imagePath = `{{ asset('public/images_ca/${res.CA_PROD_IMAGE}') }}`;
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
                                <div class="row mt-3">
                                    <p class="col-md-2" id="acttext">หมายเหตุ : </p>
                                    <p class="col-md-12 details3"><i class="bi bi-pen-fill mx-2"></i>${res.CA_PROD_NOTE}</p>
                                </div>

                                <div class="text-center mb-3">
                                     <p class="" id="imgtext">รูปภาพ : </p>
                                    <img src="${imagePath}" alt="Document Image" class="img-fluid" style="max-height: 200px; max-width: 100%;" />
                                </div>
                            </div>
                            <div class="card-footer p-2">
                                <div class="d-flex justify-content-between">
                                    <!-- Buttons on the left -->
                                    <div>
                                        <button type="button" class="btn btnaprlv" onclick="aprbtn('${res.CA_LNREC_ID}')">
                                            ส่งตรวจสอบ<i class="bi bi-arrow-right-circle-fill ms-2"></i>
                                        </button>
                                        <button type="button" class="btn btnedit" onclick="editbtn('${res.CA_LNREC_ID}','${res.CA_DOCS_ID}','${res.TLSLOG_TSKNO}','${res.TLSLOG_TSKLN}')">
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

                    }


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

        aprbtn = (id) => {
            //console.log(id);
            //console.log(empno);
            $.ajax({
                url: '{{ route('ins.appr') }}',
                method: 'GET',
                data: {
                    id: id,
                    empno: empno,
                },
                success: function(response) {
                    console.log(response);
                    if (response.capr) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Send Approve Successfully',
                            text: 'ส่งตรวจสอบเสร็จสิ้น',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        })

                    }

                },
            })
        }

        editbtn = (id, doc, tskno, tskln) => {
            console.log(id);
            let form = '';
            form += `
            <form method="POST" id="form_update" enctype="multipart/form-data">

                <input type="hidden" name="recrn_id" value = "${id}" id="rec_id">
                <input type="hidden" name="tskno" id="tsk_no" value="${tskno}">
                <input type="hidden" name="tskln" id="tsk_ln" value="${tskln}">
                <button type="button" class="btn btn-info" onclick="btnshw('${id}')">แสดงข้อมูลเพื่อแก้ไข</button>
                <div class="form-group row mt-3">
                        <div class="col col-sm-2">
                            <label for="document_id" id="txt">หมายเลขเอกสาร:</label>
                        </div>
                        <div class="col col-sm-3">
                            <input type="text" id="document_id" name="document_id" class="form-control" value="${doc}" readonly required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-4">
                                    <label for="date" id="txt">วันที่แก้ไข:</label>
                                </div>
                                <div class="col col-sm-6">
                                    <input type="date" id="date_edit" name="date_edit" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="line Prod." id="txt">Line:</label>
                                </div>
                                <div class="col col-sm-8">
                                    <input type="text" id="line_rec" name="line_rec" class="form-control" readonly required>
                                    {{-- <select name="line_rec" id="line_rec" class="form-select"></select> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="process" id="txt">Process:</label>
                                </div>
                                <div class="col col-sm-8 ms-3">
                                    <input type="text" id="prcs_record" name="prcs_record" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-4">
                                    <label for="model_code" id="txt-sp">Model Code:</label>
                                </div>
                                <div class="col col-sm-6">
                                    <input type="text" id="mdlcd" name="mdlcd" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="won" id="txt">Won#:</label>
                                </div>
                                <div class="col col-sm-8">
                                    <input type="text" id="won" name="won" class="form-control" readonly required>
                                    {{-- <select name="won" id="won" class="form-select"></select> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="lot" id="txt">Lot size:</label>
                                </div>
                                <div class="col col-sm-8 ms-3">
                                    <input type="text" id="lots" name="lots" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="from-group row">
                        <p id="txt" class="col-md-2">หัวข้อปัญหาที่เกิด:</p>
                        <div class="col-md-6 mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hd_prob" id="hd_prob" value="Man" required>
                                <label class="form-check-label" for="inlineRadio1">Man</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hd_prob" id="hd_prob" value="Machine" required>
                                <label class="form-check-label" for="inlineRadio1">Machine</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hd_prob" id="hd_prob" value="Material" required>
                                <label class="form-check-label" for="inlineRadio1">Material</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hd_prob" id="hd_prob" value="Method" required>
                                <label class="form-check-label" for="inlineRadio1">Method</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hd_prob" id="hd_prob" value="Enviroment" required>
                                <label class="form-check-label" for="inlineRadio1">Enviroment</label>
                              </div>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <p id="txt" class="col-md-2">ระดับความรุนแรง:</p>
                        <div class="col-md-6 mt-1">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rank_rec" id="rank_rec" value="A" required>
                                <label class="form-check-label" for="inlineRadio1">Rank A : รุนแรงมาก</label>
                              </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rank_rec" id="rank_rec" value="B" required>
                                <label class="form-check-label" for="inlineRadio1">Rank B : รุนแรงปานกลาง</label>
                              </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="rank_rec" id="rank_rec" value="C" required>
                                <label class="form-check-label" for="inlineRadio1">Rank C : รุนแรงน้อย</label>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">เวลาที่พบปัญหา:</p>
                        <div class="col-md-2 mt-1">
                            <input type="time" name="start_time" id="start_time" class="form-control" placeholder="เวลาเริ่มต้น" required>
                        </div>
                        <p id="txt" class="col-1">ถึง</p>
                        <div class="col-md-2 mt-1">
                            <input type="time" name="end_time" id="end_time" class="form-control" placeholder="เวลาเริ่มต้น" required>
                        </div>
                        <div class="col-md-3 mt-1">
                            <input type="text" name="name_info" id="name_info" class="form-control" placeholder="ชื่อผู้แจ้ง" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">รายละเอียดปัญหา:</p>
                        <div class="col-md-10 mt-1">
                            <textarea name="desc_prob" id="desc_prob" class="form-control" rows="3" placeholder="รายละเอียดปัญหา" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">Q'ty/Day:</p>
                        <div class="col-md-2">
                            <input type="number" name="qty_prod" id="qty_prod" class="form-control" required>
                        </div>
                        <p id="txt" class="col-sm-1 mt-1">pcs.</p>
                    </div>
                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">Acc/Lot:</p>
                        <div class="col-md-2">
                            <input type="number" name="acc_prod" id="acc_prod" class="form-control" oninput="calRateNG()" required>
                        </div>
                        <p id="txt" class="col-sm-1 mt-1">pcs.</p>
                    </div>
                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">NG:</p>
                        <div class="col-md-2">
                            <input type="number" name="ng_prod" id="ng_prod" class="form-control" oninput="calRateNG()" required>
                        </div>
                        <p id="txt" class="col-sm-1 mt-1">pcs.</p>
                    </div>
                    <div class="row mt-3">
                        <p id="txt" class="col-sm-2">Rate NG: </p>
                        <div class="col-sm-2">
                            <input type="number" name="rate_prod" id="rate_prod" class="form-control" required>
                        </div>
                        <p id="txt" class="col-sm-1 mt-1">%</p>
                    </div>

                    <div class="row">
                        <label for="cas e" class="col-sm-2" id="label-form">สาเหตุการเกิด:</label>
                        <div class="col-sm-6">
                            <textarea name="case_prod" id="case_prod" rows="4" class="form-control" required></textarea>
                        </div>
                        {{-- <div class="col-md-4">
                        <button type="submit" class="btn btn-success"><i class="bi bi-floppy-fill"></i>บันทึกข้อมูล</button>
                    </div> --}}
                    </div>

                    <div class="row mt-3">
                        <label for="case" class="col-sm-2" id="label-form">การแก้ไข:</label>
                        <div class="col-sm-6">
                            <textarea name="active_prod" id="active_prod" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <label for="case" class="col-sm-2" id="label-form">Note (หมายเหตุ):</label>
                        <div class="col-sm-6">
                            <textarea name="note_prod" id="note_prod" rows="4" class="form-control" required></textarea>
                        </div>
                    </div>


            </form>
            `;
            Swal.fire({
                title: 'ฟอร์มแก้ไขข้อมูล',
                html: '<div style="text-align: left;" >' + form + '</div>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'แก้ไขข้อมูล',
                width: '100%',
                showCloseButton: true,
                preConfirm: () => {
                    // let form = $('#form_update').serialize();
                    // console.log(form);
                    let form_update = new FormData();
                    form_update.append('update_form', $('#form_update').serialize());
                    form_update.append('id', id);
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    form_update.append('_token', _token);

                    $.ajax({
                        url: '{{ route('update.form') }}',
                        type: 'POST',
                        data: form_update,
                        contentType: false,
                        processData: false,
                        cache: false,
                        beforeSend: function() {
                            // Show a SweetAlert loading spinner
                            Swal.fire({
                                title: 'กำลังแก้ไขข้อมูล',
                                text: 'โปรดรอสักครู่......',
                                icon: 'info',
                                allowOutsideClick: false, // Prevent closing on outside click
                                showConfirmButton: false, // Hide the confirmation button
                                didOpen: () => {
                                    Swal.showLoading(); // Show the loading spinner
                                }
                            });
                        },
                        success: function(data) {
                            Swal.close();
                            console.log(data);
                            if (data.updateform) {
                                Swal.fire({
                                    title: 'แก้ไขข้อมูลสำเร็จ',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    location.reload();
                                })
                            }
                        }
                    })


                }
            })


            $('#date_edit').val(moment().format('YYYY-MM-DD'))
        }

        btnshw = (id) => {
            console.log(id);
            $.ajax({
                url: '{{ route('show.edit') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    data.show_edit.map((data) => {
                        console.log(data);
                        $('#line_rec').val(data.CA_PROD_LINE)
                        $('#prcs_record').val(data.CA_PROD_PROCS)
                        $('#mdlcd').val(data.CA_PROD_MDLCD)
                        $('#won').val(data.CA_PROD_WON)
                        $('#lots').val(data.CA_PROD_LOTS)
                        $('#hd_prob').val(data.CA_PROD_PROBM)
                        $('#rank_rec').val(data.CA_PROD_RANK)
                        $('#start_time').val(data.CA_PROD_TMPBF)
                        $('#end_time').val(data.CA_PROD_TMPBL)
                        $('#name_info').val(data.CA_PROD_INFMR)
                        $('#desc_prob').val(data.CA_PROD_DTPROB)
                        $('#qty_prod').val(data.CA_PROD_QTY)
                        $('#acc_prod').val(data.CA_PROD_ACCLOT)
                        $('#ng_prod').val(data.CA_PROD_NG)
                        $('#rate_prod').val(data.CA_PROD_RATE)
                        $('#case_prod').val(data.CA_PROD_CASE)
                        $('#active_prod ').val(data.CA_PROD_ACTIVE)
                        $('#note_prod ').val(data.CA_PROD_NOTE)

                        // Set the radio button value for rank_rec
                        $('input[name="rank_rec"]').filter('[value="' + data.CA_PROD_RANK + '"]')
                            .prop('checked', true);
                        $('input[name="hd_prob"]').filter('[value="' + data.CA_PROD_PROBM + '"]')
                            .prop('checked', true);

                    })
                }
            })
        }

        function calRateNG() {
            let ng = parseInt($('#ng_prod').val()) || 0;
            let acc = parseInt($('#acc_prod').val()) || 0;
            let rate = acc !== 0 ? (ng / acc) * 100 : 0;
            $('#rate_prod').val(parseInt(rate)); // Convert the rate to integer
        }

        delbtn = (id) => {
            console.log(id)
            $.ajax({
                url: '{{ route('delete.data') }}',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(data) {
                    Swal.fire({
                        title: 'ลบข้อมูลสำเร็จ',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000
                    }).then(() => {
                        location.reload();
                    })
                }
            })
        }

        //click approve to next level
        aprlvbtn = (id) =>{
            console.log(id)
            console.log(empno)
            $.ajax({
                url: '{{ route('approve.next') }}',
                type: 'GET',
                data: {
                    id: id,
                    empno: empno
                },
                success: function(data) {
                    console.log(data);
                    if(data.appr){
                        Swal.fire({
                            title: 'อนุมัติข้อมูลสำเร็จ',
                            icon:'success',
                            showConfirmButton: false,
                            timer: 1000
                        }).then(() => {
                            location.reload();
                        })
                    }
                }

            })
        }

        rejbtn = (id) =>{
            let frm_rj = '';
            frm_rj += '<form method="post" id="form_reject">';
            frm_rj += '@csrf';
            frm_rj += '<input type="text" class="form-control" name="comment" id="comment">';
            frm_rj += '</form>';
            Swal.fire({
                title: 'กรุณากรอกข้อมูลการเหตุผลที่ไม่อนุมัติ',
                html: '<div style="text-align: left;" >' + frm_rj + '</div>',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ส่งกลับ',
                width: '60%',
                showCloseButton: true,
                preConfirm: () => {
                    let form_reject = new FormData();
                    form_reject.append('reject_form', $('#form_reject').serialize());
                    form_reject.append('id', id);
                    var _token = $('meta[name="csrf-token"]').attr('content');
                    form_reject.append('_token', _token);

                    $.ajax({
                        url: '{{ route('reject.data') }}',
                        type: 'POST',
                        data: form_reject,
                        contentType: false,
                        processData: false,
                        cache: false,
                        beforeSend: function() {
                            // Show a SweetAlert loading spinner
                            Swal.fire({
                                title: 'กำลังส่งกลับข้อมูล',
                                text: 'โปรดรอสักครู่......',
                                icon: 'info',
                                allowOutsideClick: false, // Prevent closing on outside click
                                showConfirmButton: false, // Hide the confirmation button
                                didOpen: () => {
                                    Swal.showLoading(); // Show the loading spinner
                                }
                            });
                        },
                        success: function(data) {
                            Swal.close();
                            console.log(data);
                            if (data.rejectform) {
                                Swal.fire({
                                    title: 'ส่งกลับข้อมูลสำเร็จ',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then(() => {
                                    location.reload();
                                })
                            }
                        }
                    })
                }
            })
        }
    </script>
@endpush
