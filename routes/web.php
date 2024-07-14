<?php

use App\Http\Controllers\CsvController;
use App\Http\Controllers\FieldController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('csv/upload', [CsvController::class, 'uploadForm'])->name('csv.upload');
Route::post('csv/store', [CsvController::class, 'store'])->name('csv.store');

Route::get('fields/', [FieldController::class, 'index'])
    ->name('fields.index');
Route::post('fields/', [FieldController::class, 'update'])->name('fields.update');
Route::post('fields/delete/{id}', [FieldController::class, 'delete'])->name('fields.delete');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
