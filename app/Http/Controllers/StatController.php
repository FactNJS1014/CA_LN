<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatController extends Controller
{
    public function clearData(Request $request){
        $id = $request->id;

        $clear = [
            'CA_CLR_STD' => 1
        ];
        
        DB::table('CA_RECLN_TBL')->where('CA_LNREC_ID', $id)->update($clear);

        return response()->json($clear);
    }
}
