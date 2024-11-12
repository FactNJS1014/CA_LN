<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
 use App\Mail\TLSLOGAlert;
 use App\Models\DataWON;
class SendMailAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Notification Line Call';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
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
            ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>', '2024-11-11')
            ->where('TLSLOG_TBL.TLSLOG_LSNO', '=', 'NG001')
            ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>', 10)
            //->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '=', now()->toDateString())
            ->where('TLSLOG_TBL.TLSLOG_SNDM' , null)
            // ->where('TLSLOG_TBL.TLSLOG_FTIME' , '>=' , $currentTime)
            ->get();

        if ($posts->isNotEmpty()) {
            Mail::to('j-natdanai@alpine-asia.com')->send(new TLSLOGAlert($posts));
        }

        $ins_std_mail = [
            'TLSLOG_SNDM' => 1
        ];

        DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
        ->where('TLSLOG_LSNO', '=', 'NG001')
        ->where('TLSLOG_TTLMIN', '>', 10)
        ->whereDate('TLSLOG_ISSDT', '=', now()->toDateString())
        ->update($ins_std_mail);

        return response()->json(['send' => $posts,$ins_std_mail]);
    }
}
