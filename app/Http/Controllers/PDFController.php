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
        ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE','CA_PROD_IMAGE')
        ->where('CA_RECLN_TBL.CA_LNREC_ID', $id)
        ->get();

        $pdf = Pdf::loadView('main/PDFReport', compact('report'));
        return $pdf->stream('report.pdf');
    }

}
