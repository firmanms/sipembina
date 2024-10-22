<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('resume/{id}', [App\Http\Controllers\ResumeController::class, 'resume'])->name('resume');
