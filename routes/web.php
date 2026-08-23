<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');

Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');

Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');

Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');