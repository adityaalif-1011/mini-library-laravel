<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    // PDF 1 — Sertifikat (Landscape A4)
    public function sertifikat()
    {
        $data = [
            'nama' => 'Aditya Alif Santoso',
            'judul' => 'Peserta Seminar Nasional'
        ];

        $pdf = Pdf::loadView('pdf.sertifikat', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->stream('sertifikat.pdf');
    }

    // PDF 2 — Undangan (Portrait A4 + Header)
    public function undangan()
    {
        $data = [
            'judul' => 'Undangan Rapat Akademik',
            'isi' => 'Sehubungan dengan kegiatan akademik semester genap, kami mengundang seluruh mahasiswa untuk hadir.'
        ];

        $pdf = Pdf::loadView('pdf.undangan', $data)
            ->setPaper('a4', 'portrait');

        return $pdf->stream('undangan.pdf');
    }
}