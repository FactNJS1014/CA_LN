<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function generatePDF(Request $request){
        $id = $request->id;

        $report = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE','CA_PROD_IMAGE','CA_CASEACTIVE_TBL.CA_CASEREC_EMPID','CA_CASEACTIVE_TBL.CA_CASEREC_LSTDT')
        ->where('CA_RECLN_TBL.CA_LNREC_ID', $id)
        ->get();

        $recapp = DB::table('CA_HRECAPP_TBL')
            ->where('CA_LNREC_ID', $id)
            ->orderby('CA_LNREC_ID', 'ASC')
            ->get();

        $user = DB::connection('third_sqlsrv')->table('MUSR_TBL')->get();



        $pdf = Pdf::loadView('main/PDFReport', compact('report','recapp','user'));
        return $pdf->stream('report.pdf');
    }

    public  function ViewDocument($filepdf){
        $path = public_path('document/'. $filepdf);
        if(!file_exists($path)){
            abort(404);
        }
        return response()->file($path,['Content-Type' => 'application/pdf']);
    }

}
