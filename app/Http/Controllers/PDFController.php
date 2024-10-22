<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{

    public function generatePDF(){
        $a = "hello";
        $b = "world";
        $c = "วันจันทร์";
        $pdf = Pdf::loadView('main/testpdf', compact('a', 'b', 'c'));
        return $pdf->stream();


    }

}
