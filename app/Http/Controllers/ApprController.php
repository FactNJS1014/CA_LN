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


    public function getAppr(Request $request) {
        $data_id = $request->id;
        $emp_no = $request->empno;

        // Get current tracking level for specific record
        $currentTracking = DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $data_id)
            ->value('CA_PROD_TRACKING');

        // Get approval record for current level
        $currentApproval = DB::table('CA_HRECAPP_TBL')
            ->where('CA_LNREC_ID', $data_id)
            ->where('CA_RECAPP_LV', $currentTracking)
            ->first();

        if (!$currentApproval) {
            return response()->json(['error' => 'Approval record not found'], 404);
        }

        // Increment tracking level
        $tracking_up = $currentTracking + 1;

        // Update approval status
        DB::table('CA_HRECAPP_TBL')
            ->where('CA_LNREC_ID', $data_id)
            ->where('CA_RECAPP_LV', $currentTracking)
            ->update([
                'CA_EMPID_APPR' => $emp_no,
                'CA_RECAPP_STD' => 1
            ]);

        // ถ้า tracking_up เป็น 3 ให้อัพเดทสถานะเป็น 1 และไม่เพิ่ม tracking level
        if ($tracking_up > 3) {
            DB::table('CA_HRECAPP_TBL')
                ->where('CA_LNREC_ID', $data_id)
                ->where('CA_RECAPP_LV', 3)
                ->update([
                    'CA_EMPID_APPR' => $emp_no,
                    'CA_RECAPP_STD' => 1,
                    'CA_PROD_FAXCOMPLETE' => 1
                ]);
        } else {
            // Update tracking level เฉพาะกรณีที่ยังไม่ถึงระดับ 3
            DB::table('CA_RECLN_TBL')
                ->where('CA_LNREC_ID', $data_id)
                ->update(['CA_PROD_TRACKING' => $tracking_up]);
        }

        return response()->json(['appr' => [
            'CA_EMPID_APPR' => $emp_no,
            'CA_RECAPP_STD' => 1
        ]]);
    }

    public function InsertReject(Request $request) {
        $data_id = $request->id;
        $comment = $request->input('reject_form');
        parse_str($comment, $txt);

        // Get tracking levels
        $level1 = DB::table('CA_RECLN_TBL')
            ->select('CA_PROD_TRACKING')
            ->get();

        $level2 = DB::table('CA_HRECAPP_TBL')
            ->select('CA_RECAPP_LV', 'CA_RECAPP_EMPAPP_ID')
            ->get();

        // Find matching level
        $match = null;
        foreach ($level1 as $lv1) {
            foreach ($level2 as $lv2) {
                if ($lv1->CA_PROD_TRACKING == $lv2->CA_RECAPP_LV) {
                    $match = $lv2->CA_RECAPP_LV;
                }
            }
        }

        if ($match === null) {
            return response()->json(['error' => 'No matching level found'], 404);
        }

        $turn_tracking = $match - 1;

        // Update main table with comment and tracking
        $update_comment = [
            'CA_LNRJ_REMARK' => $txt['comment'],
            'CA_LNRJ_STD' => 1,
            'CA_PROD_TRACKING' => $turn_tracking
        ];

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $data_id)
            ->update($update_comment);

        // Update approval status for the previous level
        $update_std_rj = [
            'CA_RECAPP_STD' => 0
        ];

        DB::table('CA_HRECAPP_TBL')
            ->where('CA_RECAPP_LV', $match)
            ->where('CA_LNREC_ID', $data_id)
            ->update($update_std_rj);

        return response()->json(['rejectform' => $update_comment]);
    }
}
