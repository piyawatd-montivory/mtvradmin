<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\PartnerController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\SkillInterestController;
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
    Route::prefix('partners')->group(function () {
        Route::get('/', [PartnerController::class, 'index'])->name('partnerindex');
        Route::get('/new', [PartnerController::class, 'new'])->name('partnernew');
        Route::get('/edit/{id}', [PartnerController::class, 'edit'])->name('partneredit');
        Route::post('/create', [PartnerController::class, 'create'])->name('partnercreate');
        Route::post('/update/{id}', [PartnerController::class, 'update'])->name('partnerupdate');
        Route::delete('/delete/{id}', [PartnerController::class, 'delete'])->name('partnerdelete');
        Route::get('/list', [PartnerController::class, 'list'])->name('partnerlist');
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
    Route::prefix('positions')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('positionindex');
        Route::get('/new', [PositionController::class, 'new'])->name('positionnew');
        Route::get('/edit/{id}', [PositionController::class, 'edit'])->name('positionedit');
        Route::post('/create', [PositionController::class, 'create'])->name('positioncreate');
        Route::post('/update/{id}', [PositionController::class, 'update'])->name('positionupdate');
        Route::delete('/delete/{id}', [PositionController::class, 'delete'])->name('positiondelete');
        Route::get('/list', [PositionController::class, 'list'])->name('positionlist');
    });
    Route::prefix('skills')->group(function () {
        Route::get('/', [SkillInterestController::class, 'index'])->name('skillindex');
        Route::get('/new', [SkillInterestController::class, 'new'])->name('skillnew');
        Route::get('/edit/{id}', [SkillInterestController::class, 'edit'])->name('skilledit');
        Route::post('/create', [SkillInterestController::class, 'create'])->name('skillcreate');
        Route::post('/update/{id}', [SkillInterestController::class, 'update'])->name('skillupdate');
        Route::delete('/delete/{id}', [SkillInterestController::class, 'delete'])->name('skilldelete');
        Route::get('/list', [SkillInterestController::class, 'list'])->name('skilllist');
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';
