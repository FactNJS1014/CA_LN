<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{

    public function generatePDF(Request $request)
    {
        $id = $request->id;

        $report = DB::table('CA_RECLN_TBL')
            ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID', '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
            ->select('CA_RECLN_TBL.*', 'CA_CASEACTIVE_TBL.CA_PROD_CASE', 'CA_CASEACTIVE_TBL.CA_PROD_ACTIVE', 'CA_CASEACTIVE_TBL.CA_PROD_NOTE', 'CA_PROD_IMAGE', 'CA_CASEACTIVE_TBL.CA_CASEREC_EMPID', 'CA_CASEACTIVE_TBL.CA_CASEREC_LSTDT')
            ->where('CA_RECLN_TBL.CA_LNREC_ID', $id)
            ->get();

        $recapp = DB::table('CA_HRECAPP_TBL')
            ->where('CA_LNREC_ID', $id)
            ->orderby('CA_LNREC_ID', 'ASC')
            ->get();

        $user = DB::connection('third_sqlsrv')->table('MUSR_TBL')->get();


        $customPaper = [0, 0, 800.00, 1000.00];
        $pdf = Pdf::loadView('main/PDFReport', compact('report', 'recapp', 'user'))->setPaper($customPaper, 'landscape');;
        return $pdf->stream('report.pdf');
    }

    public  function ViewDocument($filepdf)
    {
        $path = public_path('document/' . $filepdf);
        if (!file_exists($path)) {
            abort(404);
        }
        return response()->file($path, ['Content-Type' => 'application/pdf']);
    }

    public function UploadPDF(Request $request)
    {
        $id = $request->id;
        $YM = date('Ym');
        $docid = $request->doc_id;

        $docs = $request->file('docs');
        if ($request->hasFile('docs')) {
            $extension = $docs->getClientOriginalExtension();
            $filename = $docid . '.' . $extension;
            $path = 'public/document_upload/';
            $docs->move($path, $filename);

            $upload = [
                'CA_UPLOAD_FILE' => $filename
            ];

            DB::table('CA_RECLN_TBL')
                ->where('CA_LNREC_ID', $id)
                ->update($upload);

            return response()->json($upload);
        }
    }

    public function ViewPDF(Request $request)
    {
        $filename = $request->filename;
        $filePath ='public/document_upload/' . $filename;

        return response()->json(['exists' => file_exists($filePath)]);
    }
}
