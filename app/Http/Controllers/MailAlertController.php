<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\MailAlert;

use App\Models\DataWON;
use Illuminate\Support\Facades\Mail;
use App\Mail\TLSLOGAlert;

class MailAlertController extends Controller
{
    public function MailAlert(){
        $posts = DataWON::join('TLSLOG_TBL', 'TSKH_TBL.TSKH_TSKNO', '=', 'TLSLOG_TBL.TLSLOG_TSKNO')
        ->join('TWON_TBL', 'TSKH_TBL.TSKH_WONO', '=', 'TWON_TBL.TWON_WONO')
        ->select(
            'TSKH_TBL.TSKH_MCLN',
            'TSKH_TBL.TSKH_WONO',
            'TWON_TBL.TWON_MDLCD',
            'TWON_TBL.TWON_WONQT',
            'TLSLOG_TBL.TLSLOG_TTLMIN',
            'TLSLOG_TBL.TLSLOG_DETAIL',
            'TLSLOG_TBL.TLSLOG_TSKNO',
            'TLSLOG_TBL.TLSLOG_LSNO',
            'TLSLOG_TBL.TLSLOG_FTIME',
            'TLSLOG_TBL.TLSLOG_TTIME',
            'TLSLOG_TBL.TLSLOG_TSKLN',
        )
        //->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>', '2024-11-06')
        ->where('TLSLOG_TBL.TLSLOG_LSNO', '=', 'NG001')
        ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>', 10)
        ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '=', now()->toDateString())
        //->where('TLSLOG_TBL.TLSLOG_SNDM' , null)
        // ->where('TLSLOG_TBL.TLSLOG_FTIME' , '>=' , $currentTime)
        ->get();

        if ($posts->isNotEmpty()) {
            Mail::to('j-natdanai@alpine-asia.com')->send(new TLSLOGAlert($posts));
        }

        // $ins_std_mail = [
        //     'TLSLOG_SNDM' => 1
        // ];

        // DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
        // ->where('TLSLOG_LSNO', '=', 'NG001')
        // ->where('TLSLOG_TTLMIN', '>', 10)
        // ->whereDate('TLSLOG_ISSDT', '=', now()->toDateString())
        // ->update($ins_std_mail);

        return response()->json(['send' => $posts,]);
    }
}
