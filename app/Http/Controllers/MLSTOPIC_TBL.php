<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MLSTOPIC_TBL;

class MLSTOPIC_TBL extends Controller
{
    //
    public function getData(){
        $data=MLSTOPIC_TBL::all(); 

    }
}
