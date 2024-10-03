@extends('Template/menu')
@section('title', 'หน้าหลัก')
@section('content')
    <div class="container p-2">
        <div class="card">
            <div class="card-header">
                <p class="text-topic">**เกิดการ Linecall นาทีที่มากกว่า 10**</p>
                <table class="table table-bordered" id="dataln">
                    <thead>
                        <tr>
                            <th>TLSLOG_TSKNO</th>
                            <th>ID LINECALL</th>
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


                <form action="">
                    <div class="form-group row">
                        <div class="col col-sm-2">
                            <label for="document_id" id="txt">หมายเลขเอกสาร:</label>
                        </div>
                        <div class="col col-sm-3">
                            <input type="text" id="document_id" name="document_id" class="form-control">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-4">
                                    <label for="date" id="txt">วันที่:</label>
                                </div>
                                <div class="col col-sm-6">
                                    <input type="date" id="date_record" name="date_record" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="line Prod." id="txt">Line:</label>
                                </div>
                                <div class="col col-sm-8">
                                    <input type="text" id="line_rec" name="line_rec" class="form-control">
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
                                    <input type="text" id="prcs_record" name="prcs_record" class="form-control">
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
                                    <input type="text" id="mdlcd" name="mdlcd" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="won" id="txt">Won#:</label>
                                </div>
                                <div class="col col-sm-8">
                                    <input type="text" id="won" name="won" class="form-control">
                                    {{-- <select name="won" id="won" class="form-select"></select> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="lot" id="txt">Lot size:</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </form>
                {{-- <button type="button" onclick="btnfetch()">Show</button> --}}
            </div>
        </div>
    </div>
                    <div class="container p-1">
                        <div class="card">
                            <div class="card-body bo">
                                <p id="txt">หัวข้อปํญหาที่เกิด:</p>
                                <div class="container">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Man</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Machine</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Material</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Method</label>
                                      </div>
                                      <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Enviroment</label>
                                      </div>
                                </div>
                            </div>      
                     <div class="card-body">
                         <p id="txt">ระดับความรุนแรง:</p>
                            {{-- <div class="container"> --}}
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Rank A รุนแรงมาก</label>
                                      </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Rank B รุนแรงปานกลาง</label>
                                      </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
                                        <label class="form-check-label" for="inlineRadio1">Rank C รุนแรงน้อย</label>
                            {{-- </div> --}}
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
                    html += '<td><button class="btn btnInclude" onclick=\'btnInclude("' + res.TLSLOG_TSKNO + '")\'><i class="bi bi-eye-fill mx-2"></i>เรียกข้อมูล</button></td>';
                    html += '</tr>'

                })
                $('#dataln tbody').html(html)
            },
            error: (error) => {
                console.error(error);
            }
        })
            //alert('Success')


        btnInclude = (id) => {
            console.log(id)
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
                    })
                },
                error: (error) => {
                    console.error(error);
                }
            })

        }

        $('#date_record').val(moment().format("YYYY-MM-DD"));

    </script>

@endpush
