<?php

use App\Http\Controllers\CsvController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'handler'])->name('handler');
Route::get('csv/upload', [CsvController::class, 'uploadForm'])->name('csv.upload');
Route::post('csv/store', [CsvController::class, 'store'])->name('csv.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', 'App\Http\Controllers\FieldController@dashboard')->name('dashboard');
});

Route::post('fields/', [FieldController::class, 'update'])->name('fields.update');
Route::post('fields/create', [FieldController::class, 'create'])->name('fields.create');
Route::post('fields/delete/{id}', [FieldController::class, 'delete'])->name('fields.delete');
