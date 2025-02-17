<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [PDFController::class, 'index'])->name('html.form');
Route::post('/download-pdf', [PDFController::class, 'downloadPDF'])->name('download.pdf');
