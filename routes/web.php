<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;


Route::get('/verify-loginEmail',[PageController::class, 'verifyLoginEmail'])->name('verifyLoginEmail');
Route::get('generate-pdf/{id}', [PageController::class, 'generatePDF'])->name('generate-pdf');

Route::view('/', 'pos.index');

Route::view('/{vue_capture?}', 'pos.index')
    ->where('vue_capture', '^(?!vue_capture).*$')	
    ->name('home');
