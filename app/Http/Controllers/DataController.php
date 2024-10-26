<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * TODO: Include Models
 */

 use App\Models\DataTLSLOG;
 use App\Models\DataWON;

 use Illuminate\Support\Facades\DB;


class DataController extends Controller
{
    public function FetchTLSLOG(){
        $posts = DataWON::join('TLSLOG_TBL', 'TSKH_TBL.TSKH_TSKNO' , '=' , 'TLSLOG_TBL.TLSLOG_TSKNO')
        ->join('TWON_TBL' , 'TSKH_TBL.TSKH_WONO','=','TWON_TBL.TWON_WONO')
        // ->join('TLSLOG_TBL' ,'MLSTOPIC_TBL.TLSLOG_LSNO','=' ,'TLSLOG_TBL.TLSLOG_LSNO')
        ->select('TSKH_TBL.TSKH_MCLN',
            'TSKH_TBL.TSKH_WONO',
            'TWON_TBL.TWON_MDLCD',
            'TWON_TBL.TWON_WONQT',
            'TLSLOG_TBL.TLSLOG_TTLMIN',
            'TLSLOG_TBL.TLSLOG_DETAIL',
            'TLSLOG_TBL.TLSLOG_TSKNO',
            'TLSLOG_TBL.TLSLOG_LSNO',
            'TLSLOG_TBL.TLSLOG_FTIME',
            'TLSLOG_TBL.TLSLOG_TTIME',
            'TLSLOG_TBL.TLSLOG_TSKLN',)
            // 'MLSTOPIC_TBL.MLSTOPIC_DESC')
        ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>' , '2024-10-01')
        ->where('TLSLOG_TBL.TLSLOG_LSNO', '=' , 'NG001')
        ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>' , 10)
        ->get();

        return response()->json(['data'=> $posts]);

    }

    public function FetchshowTLSLOG(Request $request){

        $getid = $request->id;
        $showinput = DataWON::join('TLSLOG_TBL', 'TSKH_TBL.TSKH_TSKNO' , '=' , 'TLSLOG_TBL.TLSLOG_TSKNO')
            ->join('TWON_TBL' , 'TSKH_TBL.TSKH_WONO','=','TWON_TBL.TWON_WONO')
            ->select('TSKH_TBL.TSKH_MCLN',
                'TSKH_TBL.TSKH_WONO',
                'TWON_TBL.TWON_MDLCD',
                'TWON_TBL.TWON_WONQT',
                'TLSLOG_TBL.TLSLOG_TTLMIN',
                'TLSLOG_TBL.TLSLOG_DETAIL',
                'TLSLOG_TBL.TLSLOG_TSKNO',
                'TLSLOG_TBL.TLSLOG_LSNO',
                'TLSLOG_TBL.TLSLOG_FTIME',
                'TLSLOG_TBL.TLSLOG_TTIME',
                'TLSLOG_TBL.TLSLOG_TSKLN')
            ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>' , '2024-10-01')
            ->where('TLSLOG_TBL.TLSLOG_LSNO', '=' , 'NG001')
            ->where('TLSLOG_TBL.TLSLOG_TSKNO', '=' , $getid)
            ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>' , 10)
            ->get();

        $YM = date('Ym');
        $CA = '';

        $findPrevious = DB::table('CA_RECLN_TBL')
        ->select('CA_DOCS_ID')
        ->orderBy('CA_DOCS_ID', 'DESC')
        ->get();

        if(empty($findPrevious[0])){
            $CA = 'Prod-' . $YM . '-000001';
        }else{
            $CA = AutogenerateKey('Prod', $findPrevious[0]->CA_DOCS_ID);
        }

        return response()->json(['show'=> $showinput, 'doc'=>$CA]);

    }

    public function getDataFormFirst(){
        $data_form = DB::table('CA_RECLN_TBL')
        ->select('CA_LNREC_ID',
            'CA_ISSUE_DATE',
            'CA_PROD_LINE',
            'CA_PROD_WON',
            'CA_PROD_DTPROB',
            'CA_DOCS_ID',
            'CA_PROD_INFMR',
            'CA_CASEREC_STD')
        ->where('CA_CASEREC_STD', '=', 0)
        ->get();
        return response()->json(['data_form'=> $data_form]);
    }

    public function ShowRecord(){
        $show_record = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE','CA_PROD_IMAGE')
        ->get();
        return response()->json(['show_record'=> $show_record]);
    }

    public function ShoweditRecord(Request $request){
        $id = $request->id;

        $show_edit = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE')
        ->where('CA_RECLN_TBL.CA_LNREC_ID', $id)
        ->get();
        return response()->json(['show_edit'=> $show_edit]);
    }

    public function ShowReports(){
        $show_report = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE','CA_PROD_IMAGE')
        ->get();
        return response()->json(['rep'=> $show_report]);
    }
}
