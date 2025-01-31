<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DataTLSLOG;

class InsertController extends Controller
{
    public function AddTLSLOG(Request $request)
    {
        $form_ins = $request->input('ca_linecall');
        parse_str($form_ins, $rec);

        //return response()->json($rec);
        $empno = $request->empno;

        $YM = date('Ym');
        $CA_ID = '';

        $currentDate = date('Y-m-d H:i:s');

        $findPrevious = DB::table('CA_RECLN_TBL')
            ->select('CA_LNREC_ID')
            ->orderBy('CA_LNREC_ID', 'DESC')
            ->get();

        if (empty($findPrevious[0])) {
            $CA_ID = 'LCA-' . $YM . '-000001';
        } else {
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
            'CA_LNREC_ID' => $CA_ID,
            'CA_CASEREC_STD' => 0,
            'CA_PROD_TRACKING' => 0,
            'TLSLOG_TSKNO' => $rec['tskno'],
            'TLSLOG_TSKLN' => $rec['tskln'],
            'CA_PROD_EMPREC' => $empno,
            'CA_PROD_OCCUR' => $rec['occur'],
            'CA_PROD_CSNUM' => $rec['csnum'],
            'CA_PROD_POINTPB' => $rec['pntpb'],
            'CA_PROD_VCPB' => $rec['vcpb'],
            'CA_PROD_WTHRSN' => $rec['noreas'],
            'CA_PROD_MANAGE' => $rec['manage']
        ];

        DB::table('CA_RECLN_TBL')->insert($ins_ln);

        return response()->json(['insdb' =>  $ins_ln]);
    }

    public function AddCaseandActive(Request $request)
    {
        $rec_id = $request->rec_id;
        $empno = $request->empno;

        $ins_case = $request->input('caseactive');
        parse_str($ins_case, $caac);


        $YM = date('Ym');



        $CASE = '';

        $findPrevious = DB::table('CA_CASEACTIVE_TBL')
            ->select('CA_CASE_ID')
            ->orderBy('CA_CASE_ID', 'DESC')
            ->get();

        if (empty($findPrevious[0])) {
            $CASE = 'CAAC-' . $YM . '-000001';
        } else {
            $CASE = AutogenerateKey('CAAC', $findPrevious[0]->CA_CASE_ID);
        }

        $case_ins = [
            'CA_CASE_ID' => $CASE,
            'CA_LNREC_ID' => $rec_id,
            'CA_PROD_CASE' => $caac['case_prod'],
            'CA_PROD_ACTIVE' => $caac['active_prod'],
            'CA_CASEREC_LSTDT' => date('Y-m-d H:i:s'),
            'CA_CASEACTIVE_STD' => 1,
            'CA_PROD_NOTE' => $caac['note_prod'],
            'CA_CASEREC_EMPID' => $empno

        ];

        DB::table('CA_CASEACTIVE_TBL')->insert($case_ins);

        $image_ins = $request->file('image');
        if ($request->hasFile('image')) {
            $extension = $image_ins->getClientOriginalExtension();
            $filename = 'CAPIC-' . $YM . '-' . rand(00000, 99999) . '.' . $extension;
            $location = 'public/images_ca/';
            $image_ins->move($location, $filename);

            $ins_img = [
                'CA_PROD_IMAGE' => $filename
            ];
            DB::table('CA_CASEACTIVE_TBL')
                ->where('CA_LNREC_ID', $rec_id)
                ->update($ins_img);
        }

        $case_std = [
            'CA_CASEREC_STD' => 1,
        ];

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $rec_id)
            ->update($case_std);

        return response()->json(['case_ins' => $case_ins]);
    }

    public function UpdateForm(Request $request)
    {
        $update_id = $request->input('id');
        $form_update = $request->input('update_form');
        parse_str($form_update, $update);

        //return response()->json($update);

        $update1 = [
            'CA_DOCS_ID' => $update['document_id'],
            'CA_PROD_UPDATE' => $update['date_edit'],
            'CA_PROD_LINE' => $update['line_rec'],
            'CA_PROD_PROCS' => $update['prcs_record'],
            'CA_PROD_MDLCD' => $update['mdlcd'],
            'CA_PROD_WON' => $update['won'],
            'CA_PROD_LOTS' => $update['lots'],
            'CA_PROD_PROBM' => $update['hd_prob'],
            'CA_PROD_RANK' => $update['rank_rec'],
            'CA_PROD_TMPBF' => $update['start_time'],
            'CA_PROD_TMPBL' => $update['end_time'],
            'CA_PROD_INFMR' => $update['name_info'],
            'CA_PROD_DTPROB' => $update['desc_prob'],
            'CA_PROD_QTY' => $update['qty_prod'],
            'CA_PROD_ACCLOT' => $update['acc_prod'],
            'CA_PROD_NG' => $update['ng_prod'],
            'CA_PROD_RATE' => $update['rate_prod'],
            'CA_PROD_OCCUR' => $update['occur'],
            'CA_PROD_CSNUM' => $update['csnum'],
            'CA_PROD_POINTPB' => $update['pntpb'],
            'CA_PROD_VCPB' => $update['vcpb'],
            'CA_PROD_WTHRSN' => $update['noreas']

        ];

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $update_id)
            ->update($update1);

        $update2 = [
            'CA_PROD_CASE' => $update['case_prod'],
            'CA_PROD_ACTIVE' => $update['active_prod'],
            'CA_PROD_NOTE' => $update['note_prod'],

        ];



        DB::table('CA_CASEACTIVE_TBL')
            ->where('CA_LNREC_ID', $update_id)
            ->update($update2);

        $update3 = [
            'TLSLOG_DETAIL' => $update['desc_prob']
        ];
        $YM = date('Ym');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $location = 'public/images_ca/';
            $filename = 'CAPIC-' . $YM . '-' . rand(00000, 99999) . '.' . $extension;
            $image->move($location, $filename);



            // อัปเดตชื่อภาพในฐานข้อมูล
            DB::table('CA_CASEACTIVE_TBL')
                ->where('CA_LNREC_ID', $update_id)
                ->update(['CA_PROD_IMAGE' => $filename]);
        }



        DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
            ->where('TLSLOG_TSKNO', $update['tskno'])
            ->where('TLSLOG_TSKLN', $update['tskln'])
            ->where('TLSLOG_TTLMIN', '>', 10)
            ->update($update3);


        return response()->json(['updateform' => $update1]);
    }

    public function DeleteRecord(Request $request)
    {
        $del_id = $request->id;

        DB::table('CA_HRECAPP_TBL')
            ->where('CA_LNREC_ID', $del_id)
            ->delete();

        DB::table('CA_CASEACTIVE_TBL')
            ->where('CA_LNREC_ID', $del_id)
            ->delete();

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $del_id)
            ->delete();
    }

    public function UpdateforReject(Request $request)
    {
        $update_id = $request->input('id');
        $form_update = $request->input('update_form');
        parse_str($form_update, $update);

        //return response()->json($update);

        $update2 = [
            'CA_DOCS_ID' => $update['document_id'],
            'CA_PROD_UPDATE' => $update['date_edit'],
            'CA_PROD_LINE' => $update['line_rec'],
            'CA_PROD_PROCS' => $update['prcs_record'],
            'CA_PROD_MDLCD' => $update['mdlcd'],
            'CA_PROD_WON' => $update['won'],
            'CA_PROD_LOTS' => $update['lots'],
            'CA_PROD_PROBM' => $update['hd_prob'],
            'CA_PROD_RANK' => $update['rank_rec'],
            'CA_PROD_TMPBF' => $update['start_time'],
            'CA_PROD_TMPBL' => $update['end_time'],
            'CA_PROD_INFMR' => $update['name_info'],
            'CA_PROD_DTPROB' => $update['desc_prob'],
            'CA_PROD_QTY' => $update['qty_prod'],
            'CA_PROD_ACCLOT' => $update['acc_prod'],
            'CA_PROD_NG' => $update['ng_prod'],
            'CA_PROD_RATE' => $update['rate_prod'],
            'CA_LNRJ_STD' => 2

        ];

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $update_id)
            ->update($update2);

        $update_rj = [
            'CA_PROD_CASE' => $update['case_prod'],
            'CA_PROD_ACTIVE' => $update['active_prod'],
            'CA_PROD_NOTE' => $update['note_prod'],

        ];



        DB::table('CA_CASEACTIVE_TBL')
            ->where('CA_LNREC_ID', $update_id)
            ->update($update_rj);

        $update3 = [
            'TLSLOG_DETAIL' => $update['desc_prob']
        ];
        $YM = date('Ym');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $location = 'public/images_ca/';
            $filename = 'CAPIC-' . $YM . '-' . rand(00000, 99999) . '.' . $extension;
            $image->move($location, $filename);



            // อัปเดตชื่อภาพในฐานข้อมูล
            DB::table('CA_CASEACTIVE_TBL')
                ->where('CA_LNREC_ID', $update_id)
                ->update(['CA_PROD_IMAGE' => $filename]);
        }



        DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
            ->where('TLSLOG_TSKNO', $update['tskno'])
            ->where('TLSLOG_TSKLN', $update['tskln'])
            ->where('TLSLOG_TTLMIN', '>', 10)
            ->update($update3);


        return response()->json(['updateform' => $update2]);
    }

    public function ByPassData(Request $request)
    {
        $id = $request->id;
        //alert($id)

        DB::table('CA_CASEACTIVE_TBL')
            ->where('CA_LNREC_ID', $id)
            ->delete();

        DB::table('CA_RECLN_TBL')
            ->where('CA_LNREC_ID', $id)
            ->delete();
    }
}
