<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\WebController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/ckeditor', function () {
    return view('ckeditor');
});
Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/career', [WebController::class, 'career'])->name('career');
Route::get('/careerfinish', [WebController::class, 'careerfinish'])->name('careerfinish');

Route::prefix('admins')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/login', [LoginController::class, 'index'])->name('samplelogin');
    Route::prefix('products')->group(function () {

    });
});

require __DIR__.'/auth.php';
