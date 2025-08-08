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

// Action Routes
Route::get('/compensation/{id}/present', [CompensationController::class, 'present'])->name('compensation.present');
Route::post('/compensation/{id}/present', [CompensationController::class, 'storePresent'])->name('compensation.present.store');
Route::get('/compensation/{id}/notice/preview', [CompensationController::class, 'noticePreview'])->name('compensation.notice.preview');
Route::get('/compensation/{id}/notice/pdf', [CompensationController::class, 'generateNoticePdf'])->name('compensation.notice.pdf');
Route::get('/compensation/{id}/analysis', [CompensationController::class, 'analysis'])->name('compensation.analysis');
Route::get('/compensation/{id}/analysis/pdf', [CompensationController::class, 'analysisPdf'])->name('compensation.analysis.pdf');
Route::get('/compensation/{id}/analysis/excel', [CompensationController::class, 'analysisExcel'])->name('compensation.analysis.excel');

// Test route for CSS
Route::get('/test-css', function () {
    return view('test-css');
})->name('test.css');