<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\Logger;
use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableController;
use App\Http\Controllers\BookController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/karen', function () {
    return 'barev dzez';
});

Route::get('/Gago', function () {
    return view("test");
});

Route::get('/table/{number?}', [TableController::class, 'create']);


Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeUser']);

//Route::middleware(UserAuth::class)->group(function() {
//});
    Route::resource('books', BookController::class)->middleware([UserAuth::class, Logger::class]);
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware(UserAuth::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'endSession']);



