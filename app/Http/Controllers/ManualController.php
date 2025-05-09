<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use Illuminate\Support\Facades\App;

class ManualController extends Controller
{
    //
    public function downloadManual(Request $request)
    {

        $locale = $request->get('lang', app()->getLocale());
        App::setLocale($locale);

        $pdf = Pdf::loadView('manual.manual');
        return $pdf->download('m3th-guide.pdf');
    }

}