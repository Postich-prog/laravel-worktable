<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('csv/upload', [CsvController::class, 'uploadForm'])->name('csv.upload');
Route::post('csv/store', [CsvController::class, 'store'])->name('csv.store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/register',[\App\Http\Controllers\RegisterUserController::class,'register'])->name('register');
Route::post('/register',[\App\Http\Controllers\RegisterUserController::class,'store'])->name('register.store');
Route::get('/login',[\App\Http\Controllers\LoginUserController::class,'login'])->name('login');
Route::post('/login',[\App\Http\Controllers\LoginUserController::class,'store'])->name('login.store');
Route::get('/logout',[\App\Http\Controllers\LoginUserController::class,'logout'])->name('logout');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
