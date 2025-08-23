<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderSheetController;
use App\Http\Controllers\CompensationController;

// The main page will now show the compensation list
Route::get('/', [CompensationController::class, 'index'])->name('home');

// Order Routes
Route::get('/orders', [OrderSheetController::class, 'index'])->name('order.index');

// Routes for creating a new order
Route::get('/create', [OrderSheetController::class, 'create'])->name('order.create');
Route::post('/store', [OrderSheetController::class, 'store'])->name('order.store');

// Routes for viewing, editing, and updating an order
Route::get('/order/{id}/preview', [OrderSheetController::class, 'showPreview'])->name('order.preview'); // New preview route
Route::get('/order/{id}/pdf', [OrderSheetController::class, 'generatePdf'])->name('order.pdf');
Route::get('/order/{id}/edit', [OrderSheetController::class, 'edit'])->name('order.edit');
Route::put('/order/{id}', [OrderSheetController::class, 'update'])->name('order.update');

// Route for deleting an order
Route::delete('/order/{id}', [OrderSheetController::class, 'destroy'])->name('order.destroy');

// Compensation Form Routes <-- NEW
Route::get('/compensations', [CompensationController::class, 'index'])->name('compensation.index');
Route::get('/compensations/register', [CompensationController::class, 'register'])->name('compensation.register');
Route::get('/compensation/create', [CompensationController::class, 'create'])->name('compensation.create');
Route::post('/compensation/store', [CompensationController::class, 'store'])->name('compensation.store');
Route::get('/compensation/{id}/preview', [CompensationController::class, 'preview'])->name('compensation.preview');
Route::get('/compensation/{id}/edit', [CompensationController::class, 'edit'])->name('compensation.edit');
Route::put('/compensation/{id}', [CompensationController::class, 'update'])->name('compensation.update');

// Kanungo Opinion Routes
Route::get('/compensation/{id}/kanungo-opinion', [CompensationController::class, 'getKanungoOpinion'])->name('compensation.kanungo-opinion.get');
Route::put('/compensation/{id}/kanungo-opinion', [CompensationController::class, 'updateKanungoOpinion'])->name('compensation.kanungo-opinion.update');

// Order Routes
Route::get('/compensation/{id}/order', [CompensationController::class, 'getOrder'])->name('compensation.order.get');
Route::put('/compensation/{id}/order', [CompensationController::class, 'updateOrder'])->name('compensation.order.update');

// Final Order Routes
Route::get('/compensation/{id}/final-order', [CompensationController::class, 'getFinalOrder'])->name('compensation.final-order.get');
Route::put('/compensation/{id}/final-order', [CompensationController::class, 'updateFinalOrder'])->name('compensation.final-order.update');
Route::get('/compensation/{id}/final-order/preview', [CompensationController::class, 'finalOrderPreview'])->name('compensation.final-order.preview');
Route::get('/compensation/{id}/final-order/pdf', [CompensationController::class, 'generateFinalOrderPdf'])->name('compensation.final-order.pdf');

// Action Routes
Route::get('/compensation/{id}/present', [CompensationController::class, 'present'])->name('compensation.present');
Route::post('/compensation/{id}/present', [CompensationController::class, 'storePresent'])->name('compensation.present.store');
Route::get('/compensation/{id}/notice/preview', [CompensationController::class, 'noticePreview'])->name('compensation.notice.preview');
Route::get('/compensation/{id}/notice/pdf', [CompensationController::class, 'generateNoticePdf'])->name('compensation.notice.pdf');
Route::get('/compensation/{id}/present/preview', [CompensationController::class, 'presentPreview'])->name('compensation.present.preview');
Route::get('/compensation/{id}/present/pdf', [CompensationController::class, 'generatePresentPdf'])->name('compensation.present.pdf');
Route::get('/compensation/{id}/analysis', [CompensationController::class, 'analysis'])->name('compensation.analysis');
Route::get('/compensation/{id}/analysis/pdf', [CompensationController::class, 'analysisPdf'])->name('compensation.analysis.pdf');
Route::get('/compensation/{id}/analysis/excel', [CompensationController::class, 'analysisExcel'])->name('compensation.analysis.excel');
Route::get('/compensation/{id}/preview/pdf', [CompensationController::class, 'generatePreviewPdf'])->name('compensation.preview.pdf');

// Test route for CSS
Route::get('/test-css', function () {
    return view('test-css');
})->name('test.css');

// Test route for PDF generation
Route::get('/test-pdf', function () {
    return response()->json(\App\Services\PdfGeneratorService::test());
})->name('test.pdf');

// Test route for actual PDF download
Route::get('/test-pdf-download', function () {
    try {
        $html = '
        <!DOCTYPE html>
        <html lang="bn">
        <head>
            <title>PDF Test</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@400;500;600;700&display=swap" rel="stylesheet">
            <style>
                body { 
                    font-family: "Noto Sans Bengali", "Lohit Bengali", "DejaVu Sans", "Liberation Sans", Arial, sans-serif; 
                    margin: 20px; 
                }
                .header { text-align: center; color: #333; }
                .content { margin: 20px 0; }
                .footer { text-align: center; margin-top: 50px; color: #666; }
                .bengali { font-size: 18px; line-height: 1.6; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>PDF Generation Test</h1>
                <h2 class="bengali">পিডিএফ জেনারেশন টেস্ট</h2>
                <p>This is a test PDF generated at: ' . now() . '</p>
                <p class="bengali">এটি একটি বাংলা ফন্ট পরীক্ষা। সংখ্যা: ১২৩৪৫৬৭৮৯০</p>
            </div>
            <div class="content">
                <h2>System Information</h2>
                <ul>
                    <li>PHP Version: ' . PHP_VERSION . '</li>
                    <li>Laravel Version: ' . app()->version() . '</li>
                    <li>Generated: ' . now()->format('Y-m-d H:i:s') . '</li>
                </ul>
            </div>
            <div class="footer">
                <p>PDF generation test successful!</p>
            </div>
        </body>
        </html>';
        
        $pdf = \App\Services\PdfGeneratorService::generateFromHtml($html, ['timeout' => 30]);
            
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="test.pdf"',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'PDF generation failed',
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
})->name('test.pdf.download');

