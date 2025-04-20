<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PDFController extends Controller
{
    public function index()
    {
        // return file_get_contents(storage_path('/images/profile_images/profile_images_5_20250213_0805338Uag8Q0.jpeg'));
        // return storage_path('images/profile_images/profile_images_5_20250213_0805338Uag8Q0.jpeg');
        return view('html_to_pdf');
    }

    public function downloadPDF(Request $req)
    {
        $req->validate([
            'html_content' => 'required|string',

            'format'       => 'nullable|string|in:A4,A5,Letter',
            'orientation'  => 'nullable|string|in:P,L',
            'margin_left'  => 'nullable|numeric|min:0',
            'margin_right' => 'nullable|numeric|min:0',
            'margin_top'   => 'nullable|numeric|min:0',
            'margin_bottom' => 'nullable|numeric|min:0',
        ]);

        $html = $req->html_content;

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => $req->format ?? 'A5',
            'orientation' => $req->orientation ?? 'L',
            'margin_left' => $req->margin_lef ?? 5,
            'margin_right' => $req->margin_right ?? 5,
            'margin_top' => $req->margin_top ?? 5,
            'margin_bottom' => $req->margin_bottom ?? 5,
        ]);

        $mpdf->WriteHTML($html);

        return response($mpdf->Output('document.pdf', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="invoice.pdf"'); // to open pdf file in browser instead of downloading
        // ->header('Content-Disposition', 'attachment; filename="document.pdf"');
    }

    public function getDeclarationForm($id)
    {
        try {
            $student = Student::find($id);

            if (!$student) return $this->notFoundResponse();

            $html = view()->make('declaration_form', ['student' => $student])->render();

            $mpdf = new Mpdf([
                'default_font' => 'dejavusans', // Ensures Arabic text is supported
                'mode' => 'utf-8',
                'orientation' => 'p', // Portrait orientation
                'format' => 'A4', // Page size

                'margin_left' => 5,
                'margin_right' => 5,
                'margin_top' => 5,
                'margin_bottom' => 5,
            ]);

            $mpdf->WriteHTML($html);
            $pdfContent = $mpdf->Output('invoice.pdf', 'S');

            return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                // ->header('Content-Disposition', 'inline; filename="invoice.pdf"'); // to open pdf file in browser instead of downloading
                ->header('Content-Disposition', 'attachment; filename="invoice.pdf"');
        } catch (\Exception $e) {
            return $this->logAndSendInternalErrorResponse($e);
        }
    }


    public function bladeToImage()
    {
        if (!class_exists('Imagick')) {
            return 'Imagick class not found. It may not be enabled for CLI PHP.';
        }

        $pdfPath = storage_path('app/public/temp.pdf');
        $imagePath = storage_path('app/public/output.png');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('card', ['name' => 'John Doe']);
        $pdf->save($pdfPath);

        $imagick = new \Imagick();
        $imagick->setResolution(150, 150);
        $imagick->readImage($pdfPath);
        $imagick->setImageFormat('png');
        $imagick->writeImage($imagePath);
        $imagick->clear();
        $imagick->destroy();

        return response()->download($imagePath);
    }
}
