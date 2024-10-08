@extends('Template/menu')
@section('title', 'Input case and active')
@section('content')
    <div class="container-fuild p-2">
        <div class="card">
            <div class="card-header headertxt">
                <h5>เลือกข้อมูลเพื่อกรอกสาเหตุและการแก้ไข</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="lncall_data">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col">วันที่บันทึก</th>
                            <th scope="col">Line</th>
                            <th scope="col">Work Order</th>
                            <th scope="col">รายละเอียดปัญหา</th>
                            <th scope="col">ผู้แจ้ง Linecall</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <form action="" id="form_caseandactive" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="card mt-3">
                <div class="card-header headertxtform">
                    <p id="Document_ID"></p>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="case" class="col-sm-2" id="label-form">สาเหตุการเกิด:</label>
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

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success mt-4"><i
                                class="bi bi-floppy-fill mx-3"></i>บันทึกข้อมูล</button>

                    </div>
                </div>
            </div>
        </form>

    </div>
@endsection

@push('script')
    <script>
        $('#secondpage').addClass('active');

        $.ajax({
            url: '{{ route('get.datarec') }}',
            type: 'GET',
            success: function(response) {
                let data = response.data_form
                let html = '';
                data.map((item) => {

                    html += '<tr>'
                    html += '<td>' + item.CA_ISSUE_DATE + '</td>'
                    html += '<td>' + item.CA_PROD_LINE + '</td>'
                    html += '<td>' + item.CA_PROD_WON + '</td>'
                    html += '<td>' + item.CA_PROD_DTPROB + '</td>'
                    html += '<td>' + item.CA_PROD_INFMR + '</td>'
                    html += '<td><button type="button" class="btn btn-primary" onclick=\'ViewForm("' + item.CA_LNREC_ID + '","' + item.CA_DOCS_ID +'")\'><i class="bi bi-file-earmark-medical-fill mx-2"></i>เรียกฟอร์ม</button></td>'
                    html += '</tr>'


                })
                $("#lncall_data tbody").html(html);
            }
        })

        ViewForm = (id, doc) => {
            //console.log(doc);

            $('#form_caseandactive').show()
            $('#form_caseandactive').trigger("reset")

            $("#Document_ID").text("หมายเลขเอกสาร: " + doc)

            $(document).ready(function() {

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
                            const formCase = new FormData();
                            formCase.append('caseactive', $('#form_caseandactive').serialize());
                            var _token = $('meta[name="csrf-token"]').attr('content');
                            formCase.append('_token', _token);
                            formCase.append('rec_id' , id)

                            $.ajax({
                                url: '{{ route('post.addcase') }}',
                                type: 'POST',
                                data: formCase,
                                processData: false,
                                contentType: false,
                                cache: false,
                                success: function(data) {
                                    console.log(data);
                                    if (data.case_ins) {
                                        Swal.fire({
                                            title: 'บันทึกข้อมูลเสร็จสิ้น',
                                            icon: "success",
                                            showConfirmButton: false,
                                            timer: 1000
                                        }).then(function() {
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
        }
    </script>
@endpush
