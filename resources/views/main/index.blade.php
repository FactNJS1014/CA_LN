@extends('Template/menu')
@section('title', 'หน้าหลัก')
@section('content')
    <div class="container p-2">
        <div class="card">
            <div class="card-header">
                <p class="text-topic">**เกิดการ Linecall นาทีที่มากกว่า 10**</p>
                <table class="table table-bordered" id="dataln">
                    <thead class="table-info fs-6">
                        <tr>
                            <th>TLSLOG_TSKNO</th>
                            <th>ID LINECALL</th>
                            <th>Line PROD.</th>
                            <th>Minutes of Linecall</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="card-title">
                <p class="text-header-1">CA- Line Call Sheet</p>
            </div>
            <div class="card-body border border-warning">


                <form method="post" class="needs-validation" id="ca_lncall" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="tskln" id="tskln">
                    <input type="hidden" name="tskno" id="tskno">
                    <div class="form-group row">
                        <div class="col col-sm-2">
                            <label for="document_id" id="txt">หมายเลขเอกสาร:</label>
                        </div>
                        <div class="col col-sm-3">
                            <input type="text" id="document_id" name="document_id" class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-4">
                                    <label for="date" id="txt">วันที่:</label>
                                </div>
                                <div class="col col-sm-6">
                                    <input type="date" id="date_record" name="date_record" class="form-control" readonly required>
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

                    <div class="d-flex justify-content-center mt-3">
                        <button type="submit" class="btn btn-success"><i class="bi bi-cloud-download-fill mx-3"></i>บันทึกข้อมูล</button>
                        {{-- <input type="submit" class="btn btn-success" value="บันทึกข้อมูล"> --}}
                    </div>

                </form>
                {{-- <button type="button" onclick="btnfetch()">Show</button> --}}
            </div>
        </div>
    </div>

@endsection
@push('script')
    <script>
        $('#firstpage').addClass('active')

        $.ajax({
            url: '{{ route('get.tlog') }}',
            method: 'GET',
            success: (response) => {
                let html = '';
                response.data.map((res)=>{

                    html +='<tr>';
                    html += '<td>'+ res.TLSLOG_TSKNO +'</td>';
                    html += '<td>'+ res.TLSLOG_LSNO +'</td>';
                    html += '<td>'+ res.TSKH_MCLN +'</td>';
                    html += '<td>'+ res.TLSLOG_TTLMIN +'</td>';
                    html += '<td><button class="btn btnInclude" onclick=\'btnInclude("' + res.TLSLOG_TSKNO + '","'+res.TLSLOG_TSKLN+'")\'><i class="bi bi-eye-fill mx-2"></i>เรียกข้อมูล</button></td>';
                    html += '</tr>'

                })
                $('#dataln tbody').html(html)
            },
            error: (error) => {
                console.error(error);
            }
        })
            //alert('Success')


        btnInclude = (id,lno) => {
            console.log(id)
            let x = $('#tskln').val(lno)
            let y = $('#tskno').val(id)
            console.log(x , y)
            $.ajax({
                url: '{{route('get.showtlog')}}',
                method: 'GET',
                data: {id: id},
                success: (response) => {
                    console.log(response);
                    response.show.map((show)=>{
                        $('#line_rec').val(show.TSKH_MCLN)
                        $('#mdlcd').val(show.TWON_MDLCD)
                        $('#won').val(show.TSKH_WONO)
                        $('#lots').val(show.TWON_WONQT)
                        $('#start_time').val(show.TLSLOG_FTIME)
                        $('#end_time').val(show.TLSLOG_TTIME)
                        $('#desc_prob').val(show.TLSLOG_DETAIL)
                    })

                    $('#document_id').val(response.doc)

                },
                error: (error) => {
                    console.error(error);
                }
            })

        }

        $('#date_record').val(moment().format("YYYY-MM-DD"));

        function calRateNG() {
            let ng = $('#ng_prod').val()
            let acc = $('#acc_prod').val()
            let rate = (ng / acc) * 100
            $('#rate_prod').val(parseInt(rate))
        }

        // saveOfData = () => {
        //     console.log("Ready to save")

        //     let formdata = $('#ca_lncall').serialize();
        //     console.log(formdata);
        // }



        $(document).ready(function(){

            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()

                        Swal.fire({
                            title: "กรุณากรอกข้อมูลให้ครบถ้วน",
                            icon: "error",
                            confirmButtonText: "ตกลง",
                        })
                    } else {
                        event.preventDefault()
                        event.stopPropagation()
                        const formRecord = new FormData();
                        formRecord.append('ca_linecall',$('#ca_lncall').serialize());
                        var _token = $('meta[name="csrf-token"]').attr('content');
                        formRecord.append('_token',_token);

                        $.ajax({
                            url: '{{route('post.addtlog')}}',
                            type: 'POST',
                            data: formRecord,
                            processData: false,
                            contentType: false,
                            cache: false,
                            success: function(data) {
                                console.log(data);
                                if(data.insdb){
                                    Swal.fire({
                                        title: 'บันทึกข้อมูลเสร็จสิ้น',
                                        icon: "success",
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then(function(){
                                        location.reload();
                                    })
                                }
                            },

                        })
                    }


                    form.classList.add('was-validated')
                }, false)
            })

        })

    </script>

@endpush
