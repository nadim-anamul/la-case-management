<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderSheetController;
use App\Http\Controllers\CompensationController;

// The main page will now list all existing orders
Route::get('/', [OrderSheetController::class, 'index'])->name('order.index');

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
Route::get('/compensation/{id}/edit', [CompensationController::class, 'edit'])->name('compensation.edit');
Route::put('/compensation/{id}', [CompensationController::class, 'update'])->name('compensation.update');