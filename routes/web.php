<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuratController;


Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('helper');
Route::post('/helper/tambah', [\App\Http\Controllers\DashboardController::class, 'create'])->name('helper.upload');
Route::get('/helper/hapus/{id}', [\App\Http\Controllers\DashboardController::class, 'remove'])->name('helper.remove');


Route::get('/templates', [SuratController::class, 'index'])->name('templates.index');
Route::post('/templates/upload', [SuratController::class, 'upload'])->name('templates.upload');
Route::get('/surat/create/{file}', [SuratController::class, 'create'])->name('surat.create');
Route::get('/surat/hapus/{id}', [SuratController::class, 'remove'])->name('surat.remove');
Route::post('/surat/generate/{file}', [SuratController::class, 'generate'])->name('surat.generate');
