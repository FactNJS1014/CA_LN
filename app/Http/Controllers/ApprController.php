<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApprController extends Controller
{
    public function InsertAppr(Request $request){
        $data_id = $request->id;
        $currentDate = date('d-m-Y H:i:s');
        $YM = date('Ym');

        $findPrevious = DB::table('CA_HRECAPP_TBL')
            ->select('CA_RECAPP_ID')
            ->orderBy('CA_RECAPP_ID', 'DESC')
            ->first();

        $baseCapr = empty($findPrevious) ? 'CAPR-' . $YM . '-000000' : $findPrevious->CA_RECAPP_ID;

        $ins_appr = [];
        for ($i = 1; $i <= 3; $i++) {
            $capr = AutogenerateKey('CAPR', $baseCapr);
            $baseCapr = $capr; // Update baseCapr for the next iteration

            $ins_appr[] = [
                'CA_RECAPP_ID' => $capr,
                'CA_LNREC_ID' => $data_id,
                'CA_RECAPP_LV' => $i,
                'CA_RECAPP_SEC'=> $this->getSectionForLevel($i),
                'CA_RECAPP_EMPAPP_ID' => $this->getEmpAppIdForLevel($i),
                'CA_RECAPP_LSTDT' => $currentDate
            ];
        }

        DB::table('CA_HRECAPP_TBL')->insert($ins_appr);

        $tracking = [
            'CA_PROD_TRACKING'=> 1
        ];

        DB::table('CA_RECLN_TBL')
        ->where('CA_LNREC_ID',$data_id)
        ->update($tracking);

        return response()->json(['capr' => $ins_appr[0]['CA_RECAPP_ID']]);


    }

    private function getSectionForLevel($level) {
        $sections = [
            1 => 'AM,CPD',
            2 => 'PE',
            3 => 'QA'
        ];
        return $sections[$level] ?? '';
    }

    private function getEmpAppIdForLevel($level) {
        $empAppIds = [
            1 => '2950044,5190002',
            2 => '5120108,5130015',
            3 => '2040008,2150007'
        ];
        return $empAppIds[$level] ?? '';
    }


    public function getAppr(Request $request){
        $data_id = $request->id;
        $emp_no = $request->empno;

        $db = DB::table('CA_RECLN_TBL')
            ->select('CA_PROD_TRACKING')
            ->get();
        $appr = DB::table('CA_HRECAPP_TBL')
            ->select('CA_RECAPP_LV','CA_RECAPP_EMPAPP_ID')
            ->get();

        $match = [];
        foreach ($db as $item) {
            foreach ($appr as $lv){
                if($item->CA_PROD_TRACKING == $lv->CA_RECAPP_LV){
                    $match = $lv->CA_RECAPP_LV;

                }
            }
        }

        $tracking_up = $match + 1;

        $appr = [
            'CA_EMPID_APPR' => $emp_no,
            'CA_RECAPP_STD' => 1
        ];

        if ($tracking_up >= 3) {
            $trackupdate = [
                'CA_PROD_TRACKING' => $tracking_up,
            ];
        } else {
            $trackupdate = [
                'CA_PROD_TRACKING' => $tracking_up
            ];
        }



        DB::table('CA_HRECAPP_TBL')
            ->where('CA_RECAPP_EMPAPP_ID',$match)
            ->where('CA_LNREC_ID',$data_id)
            ->update($appr);


        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID',$data_id)
            ->update($trackupdate);

        return response()->json(['appr' => $appr]);

    }
}
