<?php

namespace App\Http\Controllers\Api\LMS;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CertificateController extends Controller
{
    public function download(Request $request)
    {
        try {
            $data = [
                'name' => auth()->user()->name,
                'course' => 'Laravel Advanced',
                'date' => now()->format('d-m-Y'),
            ];

            $pdf = pdf::loadView('certificates.template', $data);
            return $pdf->download('certificate.pdf');
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
