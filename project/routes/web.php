<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\Logger;
use App\Http\Middleware\UserAuth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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
Route::get('/login/forgotPassword', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/login/forgotPassword', [AuthController::class, 'sendResetEmail']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeUser']);


Route::resource('books', BookController::class)->middleware([UserAuth::class, Logger::class, "verified"]);
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard')->middleware(UserAuth::class);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'endSession']);

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(UserAuth::class)->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('dashboard')->with('success', 'Your email has been verified!');
})->middleware([UserAuth::class, 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware([UserAuth::class, 'throttle:6,1'])->name('verification.send');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');

