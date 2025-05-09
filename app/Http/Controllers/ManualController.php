<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;


class ManualController extends Controller
{
    //
    public function downloadManual()
    {
        $pdf = Pdf::loadView('manual.manual');
        return $pdf->download('m3th-guide.pdf');
    }

}