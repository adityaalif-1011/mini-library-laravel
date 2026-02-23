<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function sertifikat()
    {
        $pdf = Pdf::loadView('pdf.sertifikat')
            ->setPaper('a4', 'landscape');

        return $pdf->download('sertifikat.pdf');
    }

    public function undangan()
    {
        $pdf = Pdf::loadView('pdf.undangan')
            ->setPaper('a4', 'portrait');

        return $pdf->download('undangan.pdf');
    }
}