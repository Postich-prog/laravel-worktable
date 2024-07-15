<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('csv/upload', [CsvController::class, 'uploadForm'])->name('csv.upload');
Route::post('csv/store', [CsvController::class, 'store'])->name('csv.store');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('fields/', [FieldController::class, 'index'])
    ->name('fields.index');
Route::post('fields/', [FieldController::class, 'update'])->name('fields.update');
Route::post('fields/delete/{id}', [FieldController::class, 'delete'])->name('fields.delete');
