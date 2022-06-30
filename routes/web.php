<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admins\UserController;

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

Route::get('/', [WebController::class, 'index'])->name('home');
Route::get('/career', [WebController::class, 'career'])->name('career');
Route::get('/careerfinish', [WebController::class, 'careerfinish'])->name('careerfinish');
Route::get('/ck', [WebController::class, 'ck'])->name('ck');

Route::prefix('admins')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/login', [LoginController::class, 'index'])->name('samplelogin');
    Route::prefix('tags')->group(function () {

    });
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('userindex');
        Route::get('/new', [UserController::class, 'new'])->name('usernew');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('useredit');
        Route::post('/create', [UserController::class, 'create'])->name('usercreate');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('userupdate');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('userdelete');
        Route::get('/list', [UserController::class, 'list'])->name('userlist');
        Route::post('/checkemail', [UserController::class, 'checkemail'])->name('checkemail');

    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';
