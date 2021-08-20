<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\LanguageController;
use App\Http\Middleware\LanguageMiddleware;

Route::get('/set-local-lang/{key}', function ($key) {
    session()->put('locale', $key);
    return response()->json([
        'status' => true
    ]);
})->middleware('languageMiddleware');

Route::middleware('languageMiddleware')->group(function ()
{
    Route::get('/lang-{lang}.js', [LanguageController::class, 'show']);
    Route::get('/verify-loginEmail',[PageController::class, 'verifyLoginEmail'])->name('verifyLoginEmail');
    Route::get('generate-pdf/{id}', [PageController::class, 'generatePDF'])->name('generate-pdf');

    Route::view('/', 'pos.index');

    Route::view('/{vue_capture?}', 'pos.index')
        ->where('vue_capture', '^(?!vue_capture).*$')
        ->name('home');
});

