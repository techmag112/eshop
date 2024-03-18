<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::controller(AuthController::class)->group(function() {
    Route::get('/login', 'index')->name('login');
    Route::post('/login', 'signIn')->name('signIn');
    Route::get('/sign-up', 'signUp')->name('sign-up');
    Route::post('/sign-up', 'store')->name('store');
    Route::delete('/sign-up', 'logout')->name('logout');

    Route::get('/forgot-password', 'forgot')
        ->middleware('guest')->name('password.forgot');
    Route::post('/forgot-password', 'forgotPassword')
        ->middleware('guest')->name('password.email');

    Route::get('/reset-password/{token}', 'reset')
        ->middleware('guest')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')
        ->middleware('guest')->name('password.update');

    Route::get('/auth/socialite/github', 'github')
        ->name('socialite.github');

    Route::get('/auth/socialite/github/callback', 'githubCallback')
        ->name('socialite.github.callback');

});

Route::get('/', HomeController::class)->name('home');


