@extends('Template/menu')
@section('title', 'หน้าหลัก')
@section('content')
    <div class="container p-2">
        <div class="card">
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
                                    <select name="line_rec" id="line_rec" class="form-select"></select>
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
                                    <select name="won" id="won" class="form-select"></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col col-sm-3">
                                    <label for="lot" id="txt">Lot size:</label>
                                </div>
                                <div class="col col-sm-8 ms-3">
                                    <input type="text" id="lots" name="lots" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </form>
            </div>
        </div>
    </div>



@endsection
@push('script')
    <script>
        $('#firstpage').addClass('active');
    </script>
@endpush
