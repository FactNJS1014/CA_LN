<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InsertController extends Controller
{
    public function AddTLSLOG(Request $request){
        $form_ins = $request->input('ca_linecall');
        parse_str($form_ins,$rec);

        $YM = date('Ym');
        $CA_ID = '';

        $currentDate = date('Y-m-d H:i:s');

        $findPrevious = DB::table('CA_RECLN_TBL')
        ->select('CA_LNREC_ID')
        ->orderBy('CA_LNREC_ID', 'DESC')
        ->get();

        if(empty($findPrevious[0])){
            $CA_ID = 'LCA-' . $YM . '-000001';
        }else{
            $CA_ID = AutogenerateKey('LCA', $findPrevious[0]->CA_LNREC_ID);
        }

        $ins_ln = [
            'CA_DOCS_ID' => $rec['document_id'],
            'CA_ISSUE_DATE' => $rec['date_record'],
            'CA_PROD_LINE' => $rec['line_rec'],
            'CA_PROD_PROCS' => $rec['prcs_record'],
            'CA_PROD_MDLCD' => $rec['mdlcd'],
            'CA_PROD_WON' => $rec['won'],
            'CA_PROD_LOTS' => $rec['lots'],
            'CA_PROD_PROBM' => $rec['hd_prob'],
            'CA_PROD_RANK' => $rec['rank_rec'],
            'CA_PROD_TMPBF' => $rec['start_time'],
            'CA_PROD_TMPBL' => $rec['end_time'],
            'CA_PROD_INFMR' => $rec['name_info'],
            'CA_PROD_DTPROB' => $rec['desc_prob'],
            'CA_PROD_QTY' => $rec['qty_prod'],
            'CA_PROD_ACCLOT' => $rec['acc_prod'],
            'CA_PROD_NG' => $rec['ng_prod'],
            'CA_PROD_RATE' => $rec['rate_prod'],
            'CA_PROD_RECSTD' => 1,
            'CA_PROD_LSTDT' => $currentDate,
            'CA_PROD_FAXCOMPLETE' => 0,
            'CA_LNREC_ID' => $CA_ID

        ];

        DB::table('CA_RECLN_TBL')->insert($ins_ln);

        return response()->json(['insdb' =>  $ins_ln]);
    }
}
