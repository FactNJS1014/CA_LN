<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * TODO: Include Models
 */

 use App\Models\DataTLSLOG;
 use App\Models\DataWON;

 use Illuminate\Support\Facades\DB;
 use Illuminate\Support\Facades\Mail;
 use App\Mail\TLSLOGAlert;
 use App\Mail\LinkToInput;



class DataController extends Controller
{
    public function FetchTLSLOG()
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
                'TLSLOG_TBL.TLSLOG_ISSDT',
                'TLSLOG_TBL.TLSLOG_LSLN',
            )
            ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>', '2024-11-14')
            ->where('TLSLOG_TBL.TLSLOG_LSNO', '=', 'NG001')
            ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>', 10)
            ->where('TLSLOG_TBL.TLSLOG_COMPLETE' , null)
            ->get();



        return response()->json(['data' => $posts]);


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
            ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>' , '2024-11-14')
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
            'CA_PROD_PROBM',
            'CA_CASEREC_STD',
            'CA_PROD_FAXCOMPLETE',
            'CA_PROD_OCCUR')
        ->where('CA_CASEREC_STD', '=', 0)
        ->get();
        return response()->json(['data_form'=> $data_form]);
    }

    public function ShowRecord(){
        $show_record = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->join('CA_HRECAPP_TBL', 'CA_HRECAPP_TBL.CA_LNREC_ID' , '=', 'CA_RECLN_TBL.CA_LNREC_ID')
        ->select(
            'CA_RECLN_TBL.*',
            'CA_CASEACTIVE_TBL.CA_PROD_CASE',
            'CA_CASEACTIVE_TBL.CA_PROD_ACTIVE',
            'CA_CASEACTIVE_TBL.CA_PROD_NOTE',
            'CA_CASEACTIVE_TBL.CA_PROD_IMAGE',
            'CA_HRECAPP_TBL.CA_RECAPP_ID',
            'CA_HRECAPP_TBL.CA_RECAPP_LV',
            'CA_HRECAPP_TBL.CA_RECAPP_SEC',
            'CA_HRECAPP_TBL.CA_RECAPP_EMPAPP_ID',
            'CA_HRECAPP_TBL.CA_EMPID_APPR',
            'CA_HRECAPP_TBL.CA_RECAPP_STD',

            )
        ->where('CA_RECLN_TBL.CA_PROD_FAXCOMPLETE',0)
        ->get();


        // $level2 = DB::table('CA_RECLN_TBL')
        // ->select('CA_LNREC_ID','CA_PROD_TRACKING','CA_LNRJ_STD')
        // ->where('CA_PROD_FAXCOMPLETE','=',0)
        // ->get();

        $level2 = DB::table('CA_RECLN_TBL')
        ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        ->select(
            'CA_RECLN_TBL.*',
            'CA_CASEACTIVE_TBL.CA_PROD_CASE',
            'CA_CASEACTIVE_TBL.CA_PROD_ACTIVE',
            'CA_CASEACTIVE_TBL.CA_PROD_NOTE',
            'CA_PROD_IMAGE',

            )
        ->where('CA_RECLN_TBL.CA_PROD_FAXCOMPLETE','=',0)
        ->get();

        return response()->json(['show_record'=> $show_record , 'match' => $level2]);
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

    public function ShowReports2(Request $request){
        // $id = $request->id;

        // $show_report2 = DB::table('CA_RECLN_TBL')
        // ->join('CA_CASEACTIVE_TBL', 'CA_RECLN_TBL.CA_LNREC_ID' , '=', 'CA_CASEACTIVE_TBL.CA_LNREC_ID')
        // //->join('CA_HRECAPP_TBL', 'CA_RECLN_TBL.CA_LNREC_ID', '=', 'CA_HRECAPP_TBL.CA_LNREC_ID')
        // ->select('CA_RECLN_TBL.*','CA_CASEACTIVE_TBL.CA_PROD_CASE','CA_CASEACTIVE_TBL.CA_PROD_ACTIVE','CA_CASEACTIVE_TBL.CA_PROD_NOTE','CA_PROD_IMAGE','CA_CASEACTIVE_TBL.CA_CASEREC_EMPID','CA_CASEACTIVE_TBL.CA_CASEREC_LSTDT')
        // // ->where('CA_RECLN_TBL.CA_LNREC_ID', $id)
        // ->get();

        $show_report2 = DB::table('CA_RECLN_TBL as CA_R')
        ->join('CA_CASEACTIVE_TBL as CA_C', 'CA_R.CA_LNREC_ID', '=', 'CA_C.CA_LNREC_ID')
        ->join('CA_HRECAPP_TBL as CA_H', 'CA_R.CA_LNREC_ID', '=', 'CA_H.CA_LNREC_ID')
        ->select(
            'CA_H.CA_RECAPP_LV',
            'CA_H.CA_EMPID_APPR',
            'CA_R.*',
            'CA_C.CA_PROD_CASE',
            'CA_C.CA_PROD_ACTIVE',
            'CA_C.CA_PROD_NOTE',
            'CA_C.CA_PROD_IMAGE',
            'CA_C.CA_CASEREC_EMPID',
            'CA_C.CA_CASEREC_LSTDT'
        )
        ->orderBy('CA_R.CA_LNREC_ID', 'asc')
        ->orderBy('CA_H.CA_RECAPP_LV', 'asc')
        ->get();

        $get_masterID2 = DB::connection('third_sqlsrv')->table('MUSR_TBL')->get();

        // $arrResult = [];
        // Loop through $show_data and match with $get_masterID based on CA_PROD_EMPREC and MUSR_ID
        foreach ($show_report2 as $show2) {
            // Find the corresponding MUSR_NAME from $get_masterID
            $matchingMaster = $get_masterID2->firstWhere('MUSR_ID', $show2->CA_CASEREC_EMPID);
            $matchingMaster2 = $get_masterID2->firstWhere('MUSR_ID', $show2->CA_EMPID_APPR);

            // If a match is found, append MUSR_NAME to the $show data
            if ($matchingMaster) {
                $show2->MUSR_NAME = $matchingMaster->MUSR_NAME;
            } else {
                $show2->MUSR_NAME = null; // If no match is found, set it as null or any default value
            }

            if ($matchingMaster2) {
                $show2->MUSR_NAME = $matchingMaster2->MUSR_NAME;
            } else {
                $show2->MUSR_NAME = null; // If no match is found, set it as null or any default value
            }

            // if(!in_array($show2->CA_LNREC_ID , $arrResult)) {
            //     array_push($arrResult,$show2->CA_LNREC_ID);
            // }
        }
        // return response()->json(['rep2'=> $show_report2, 'masterID2'=> $get_masterID2, 'arrResult'=> $arrResult]);
        return response()->json(['rep2'=> $show_report2, 'masterID2'=> $get_masterID2]);
    }

    public function ShowDataForm1(){
        $show_data = DB::table('CA_RECLN_TBL')->get();
        $get_masterID = DB::connection('third_sqlsrv')->table('MUSR_TBL')->get();

        // Loop through $show_data and match with $get_masterID based on CA_PROD_EMPREC and MUSR_ID
        foreach ($show_data as $show) {
            // Find the corresponding MUSR_NAME from $get_masterID
            $matchingMaster = $get_masterID->firstWhere('MUSR_ID', $show->CA_PROD_EMPREC);

            // If a match is found, append MUSR_NAME to the $show data
            if ($matchingMaster) {
                $show->MUSR_NAME = $matchingMaster->MUSR_NAME;
            } else {
                $show->MUSR_NAME = null; // If no match is found, set it as null or any default value
            }
        }

        return response()->json(['data' => $show_data, 'masterID' => $get_masterID]);

    }
     // // Step 1: Get data from the first database (primary connection)
        // $caReclnData = DB::table('CA_RECLN_TBL')
        //                  ->select('CA_RECLN_TBL.*')
        //                  ->get()
        //                  ->keyBy('TLSLOG_TSKNO'); // Assuming TLSLOG_TSKNO is the join key

        // // Step 2: Get data from the second database (second_sqlsrv connection)
        // $tlslogData = DB::connection('second_sqlsrv')
        //                 ->table('TLSLOG_TBL')
        //                 ->select('TLSLOG_TBL.TLSLOG_TSKNO')
        //                 ->get()
        //                 ->keyBy('TLSLOG_TSKNO'); // Use keyBy for easy lookup

        // // Step 3: Merge the data based on TLSLOG_TSKNO
        // $mergedData = $caReclnData->map(function ($record) use ($tlslogData) {
        //     // Check if the TLSLOG_TSKNO exists in the second dataset
        //     if (isset($tlslogData[$record->TLSLOG_TSKNO])) {
        //         // Add the TLSLOG_TSKNO to the record from the second database
        //         $record->TLSLOG_TSKNO = $tlslogData[$record->TLSLOG_TSKNO]->TLSLOG_TSKNO;
        //     } else {
        //         // If no match found, set TLSLOG_TSKNO to null or handle as needed
        //         $record->TLSLOG_TSKNO = null;
        //     }
        //     return $record;
        // });

    public function ShowData()
    {

        // Step 1: Get data from the first database (primary connection)
        $caReclnData = DB::table('CA_RECLN_TBL')
                         ->select('CA_RECLN_TBL.*')
                         ->get()
                         ->keyBy('TLSLOG_TSKNO','TLSLOG_TSKLN'); // Assuming TLSLOG_TSKNO is the join key

        // Step 2: Get data from the second database (second_sqlsrv connection)
        $tlslogData = DB::connection('second_sqlsrv')
                        ->table('TLSLOG_TBL')
                        ->select('TLSLOG_TBL.TLSLOG_TSKNO')
                        ->get()
                        ->keyBy('TLSLOG_TSKNO','TLSLOG_TSKLN'); // Use keyBy for easy lookup

        // Step 3: Merge the data based on TLSLOG_TSKNO
        $mergedData = $caReclnData->map(function ($record) use ($tlslogData) {
            // Check if the TLSLOG_TSKNO exists in the second dataset
            if (isset($tlslogData[$record->TLSLOG_TSKNO])&& isset($tlslogData[$record->TLSLOG_TSKLN])) {
                // Add the TLSLOG_TSKNO to the record from the second database
                $record->TLSLOG_TSKNO = $tlslogData[$record->TLSLOG_TSKNO]->TLSLOG_TSKNO;
                $record->TLSLOG_TSKLN = $tlslogData[$record->TLSLOG_TSKLN]->TLSLOG_TSKLN;
            } else {
                // If no match found, set TLSLOG_TSKNO to null or handle as needed
                $record->TLSLOG_TSKNO = null;
                $record->TLSLOG_TSKLN = null;
            }
            return $record;
        });


        return response()->json($mergedData); // Return the merged data as JSON
    }

    public function SendEmail(){
        $currentTime = Carbon::now();

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

    public function SendMailToInput(Request $request){
        // $send_data = DB::table('CA_RECLN_TBL')
        // ->select( 'CA_PROD_RECSTD','CA_LNREC_ID')
        // ->where('CA_PROD_RECSTD', 1)
        // ->get();
        //$emp_id = $request->empno;
        $id_user = ['5120154,5210002,5210007,5240006','5240007','5120057'];

        $_empid = explode(',', $id_user[0]);

        $result = [];// เตรียม array เก็บผลลัพธ์
        //$_link = []; //link email
        for ($i = 0; $i < sizeof($_empid); $i++) {
            $result[] = $_empid[$i]; // เพิ่มค่าลง array
            $person = DB::table('VUSER_DEPT')
            ->select(
                'MUSR_ID',
                'MUSR_NAME',
                'DEPT_S_NAME',
                'DEPT_SEC',
                'MSECT_ID',
                'USE_PERMISSION',
                'MUSR_COMPANY_EMAIL'
            )
            ->where('MUSR_ID',$_empid[$i])
            ->get();
            $empno = $person[0]->MUSR_ID;
            $empname = $person[0]->MUSR_NAME;
            $dept = $person[0]->DEPT_S_NAME;
            $dept_sec = $person[0]->DEPT_SEC;
            $sec_id = $person[0]->MSECT_ID;
            $per = $person[0]->USE_PERMISSION;
            $email_empno = $person[0]->MUSR_COMPANY_EMAIL;
            if (isset($empname, $empno, $dept, $per, $dept_sec, $sec_id)) {
                $web_link = url("http://web-server/41_calinecall/index.php/third?username={$empname}&empno={$empno}&department={$dept}&USE_PERMISSION={$per}&sec={$dept_sec}&MSECT_ID={$sec_id}");
                //$_link[] = $web_link;
                $linktoInput = [
                    'link' => $web_link,
                ];
                Mail::to([ $email_empno])->send(new LinkToInput($linktoInput));

            }

        }

        return response()->json($linktoInput);



    }

    public function Testdata(){
        $posts = DataWON::join('TLSLOG_TBL', 'TSKH_TBL.TSKH_TSKNO', '=', 'TLSLOG_TBL.TLSLOG_TSKNO')
            ->join('TWON_TBL', 'TSKH_TBL.TSKH_WONO', '=', 'TWON_TBL.TWON_WONO')
            ->join('MLSTOPIC_TBL','TLSLOG_TBL.TLSLOG_LSNO','=','MLSTOPIC_TBL.MLSTOPIC_LSNO')
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
                'MLSTOPIC_TBL.MLSTOPIC_LSNO',
                'MLSTOPIC_TBL.MLSTOPIC_DESC',
            )
            ->whereDate('TLSLOG_TBL.TLSLOG_ISSDT', '>', '2024-11-14')
            ->where('TLSLOG_TBL.TLSLOG_LSNO', '=', 'NG001')
            ->where('TLSLOG_TBL.TLSLOG_TTLMIN', '>', 10)
            ->where('TLSLOG_TBL.TLSLOG_COMPLETE' , null)
            ->get();



        return response()->json(['data' => $posts]);
    }


    public function UserInput()
    {
        $table = DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
            ->join('CA_RECLN_TBL', 'TLSLOG_TBL.TLSLOG_TSKNO', '=', 'CA_RECLN_TBL.TLSLOG_TSKNO')
            ->select('TLSLOG_TBL.TLSLOG_TSKNO', 'CA_RECLN_TBL.TLSLOG_TSKNO')
            ->get();

        return response()->json(['data' => $table]);
    }


    public function ByPass(Request $request){
        //$byp = DB::connection('second_sqlsrv')->table('TLSLOG_TBL')->get();
        $empno = $request->empno;
        $tskno = $request->id;
        $tskln = $request->lno;
        $lsln = $request->lsln;

        $byp_data = $request->bypass_f;
        parse_str( $byp_data,$fbyp);
        $data_byp = [
            'TLSLOG_COMPLETE' => 1,
            'TLSLOG_EMPNO_BYPASS' => $empno,
            'TLSLOG_DETAIL' => $fbyp['bypass'],
        ];

        DB::connection('second_sqlsrv')->table('TLSLOG_TBL')
        ->where('TLSLOG_TSKNO',$tskno)
        ->where('TLSLOG_TSKLN',$tskln)
        ->where('TLSLOG_LSLN',$lsln)
        ->update($data_byp);

        $data_02 = [
            'CA_PROD_FAXCOMPLETE' => 1,
        ];

        DB::table('CA_RECLN_TBL')
        ->where('TLSLOG_TSKNO',$tskno)
        ->where('TLSLOG_TSKLN',$tskln)
        ->update($data_02);

        return response()->json(['byp' => $data_byp]);
    }



}
