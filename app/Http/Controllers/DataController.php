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
            ->select('TSKH_TBL.TSKH_MCLN',
             'TSKH_TBL.TSKH_WONO',
             'TWON_TBL.TWON_MDLCD',
             'TWON_TBL.TWON_WONQT',
             'TLSLOG_TBL.TLSLOG_TTLMIN',
             'TLSLOG_TBL.TLSLOG_DETAIL',
             'TLSLOG_TBL.TLSLOG_TSKNO',
             'TLSLOG_TBL.TLSLOG_LSNO')
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
             'TLSLOG_TBL.TLSLOG_TTIME',)
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
            $CA = 'LCAD-' . $YM . '-000001';
        }else{
            $CA = AutogenerateKey('LCAD', $findPrevious[0]->CA_DOCS_ID);
        }

        return response()->json(['show'=> $showinput, 'doc'=>$CA]);

    }
}
