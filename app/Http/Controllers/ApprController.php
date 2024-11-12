<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\LinkToAppr;
class ApprController extends Controller
{
    public function InsertAppr(Request $request)
    {
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

            $record = [
                'CA_RECAPP_ID' => $capr,
                'CA_LNREC_ID' => $data_id,
                'CA_RECAPP_LV' => $i,
                'CA_RECAPP_SEC' => $this->getSectionForLevel($i),
                'CA_RECAPP_EMPAPP_ID' => $this->getEmpAppIdForLevel($i),
                'CA_RECAPP_LSTDT' => $currentDate
            ];

            // Check if record exists
            $existingRecord = DB::table('CA_HRECAPP_TBL')
                ->where('CA_LNREC_ID', $data_id)
                ->where('CA_RECAPP_LV', $i)
                ->first();

            if ($existingRecord) {
                // Update existing record
                DB::table('CA_HRECAPP_TBL')
                    ->where('CA_LNREC_ID', $data_id)
                    ->where('CA_RECAPP_LV', $i)
                    ->update($record);
            } else {
                // Insert new record
                $ins_appr[] = $record;
            }
        }

        // Insert any new records into the table
        if (!empty($ins_appr)) {
            DB::table('CA_HRECAPP_TBL')->insert($ins_appr);
        }

        $tracking = [
            'CA_PROD_TRACKING' => 1
        ];

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $data_id)
            ->update($tracking);

        return response()->json(['capr' => $ins_appr[0]['CA_RECAPP_ID'] ?? $capr]);
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
        $tlskno = $request->tkno;
        $tlskln = $request->tkln;

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

                ]);

        } else {
            // Update tracking level เฉพาะกรณีที่ยังไม่ถึงระดับ 3
            DB::table('CA_RECLN_TBL')
                ->where('CA_LNREC_ID', $data_id)
                ->update(['CA_PROD_TRACKING' => $tracking_up]);
        }

        $person = DB::table('VUSER_DEPT')
        ->select(
            'MUSR_ID',
            'MUSR_NAME',
            'DEPT_S_NAME',
            'DEPT_SEC',
            'MSECT_ID',
            'USE_PERMISSION'
        )
        ->where('MUSR_ID',$emp_no)
        ->get();

        $empno = $person[0]->MUSR_ID;
        $empname = $person[0]->MUSR_NAME;
        $dept = $person[0]->DEPT_S_NAME;
        $dept_sec = $person[0]->DEPT_SEC;
        $sec_id = $person[0]->MSECT_ID;
        $per = $person[0]->USE_PERMISSION;
        if (isset($empname, $empno, $dept, $per, $dept_sec, $sec_id)) {
            $web_link = url("http://web-server/41_calinecall/index.php/third?username={$empname}&empno={$empno}&department={$dept}&USE_PERMISSION={$per}&sec={$dept_sec}&MSECT_ID={$sec_id}");
        } else {
            // จัดการกรณีที่ค่าตัวแปรไม่ถูกต้อง
            return response()->json(['error' => 'Missing required parameters'], 400);
        }
        $linktoAppr = [
            'link' => $web_link,
        ];

        Switch($tracking_up){
            case "1":
                //return response()->json([$empno,$empname,$dept,$dept_sec,$sec_id,$web_link]);
                Mail::to('j-natdanai@alpine-asia.com')->send(new LinkToAppr($linktoAppr));

                break;
            case "2":
                Mail::to('j-natdanai@alpine-asia.com')->send(new LinkToAppr($linktoAppr));
                break;
            case "3":
                Mail::to('j-natdanai@alpine-asia.com')->send(new LinkToAppr($linktoAppr));
                break;
            default:
                DB::table('CA_RECLN_TBL')
                ->where('CA_LNREC_ID', $data_id)
                ->update([
                    'CA_PROD_FAXCOMPLETE' => 1,
                ]);
                DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
                ->where('TLSLOG_TSKNO' , $tlskno)
                ->where('TLSLOG_TSKLN' , $tlskln)
                ->where('TLSLOG_TTLMIN', '>', 10)
                ->update([
                    'TLSLOG_COMPLETE' => 1,

                ]);
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
            //->where('CA_PROD_FAXCOMPLETE', '=', 0)
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
