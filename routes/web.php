<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\PartnerController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\SkillInterestController;
use App\Http\Controllers\Admins\ContentController;
use App\Http\Controllers\Admins\MontivoryController;
use App\Http\Controllers\Admins\ContactController;
use App\Http\Controllers\Admins\FileManagerController;

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
Route::get('/career/{alias}', [WebController::class, 'careerdetail'])->name('careerdetail');
Route::get('/careerfinish', [WebController::class, 'careerfinish'])->name('careerfinish');
Route::get('/ck', [WebController::class, 'ck'])->name('ck');

Route::prefix('admins')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/login', [LoginController::class, 'index'])->name('samplelogin');
    Route::prefix('tags')->group(function () {

    });
    Route::prefix('contents')->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('contentindex');
        Route::get('/new', [ContentController::class, 'new'])->name('contentnew');
        Route::get('/edit/{id}', [ContentController::class, 'edit'])->name('contentedit');
        Route::get('/gallery/{id}', [ContentController::class, 'gallery'])->name('contentgallery');
        Route::post('/gallery/{id}', [ContentController::class, 'updategallery'])->name('contentgalleryupdate');
        Route::post('/create', [ContentController::class, 'create'])->name('contentcreate');
        Route::post('/update/{id}', [ContentController::class, 'update'])->name('contentupdate');
        Route::delete('/delete/{id}', [ContentController::class, 'delete'])->name('contentdelete');
        Route::get('/list', [ContentController::class, 'list'])->name('contentlist');
    });
    Route::prefix('partners')->group(function () {
        Route::get('/', [PartnerController::class, 'index'])->name('partnerindex');
        Route::get('/new', [PartnerController::class, 'new'])->name('partnernew');
        Route::get('/edit/{id}', [PartnerController::class, 'edit'])->name('partneredit');
        Route::post('/create', [PartnerController::class, 'create'])->name('partnercreate');
        Route::post('/update/{id}', [PartnerController::class, 'update'])->name('partnerupdate');
        Route::post('/reorder', [PartnerController::class, 'reorder'])->name('partnerreorder');
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
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::post('/update', [UserController::class, 'profileupdate'])->name('profileupdate');
    });
    Route::prefix('montivory')->group(function () {
        Route::get('/', [MontivoryController::class, 'index'])->name('montivoryindex');
        Route::get('/new', [MontivoryController::class, 'new'])->name('montivorynew');
        Route::get('/edit/{id}', [MontivoryController::class, 'edit'])->name('montivoryedit');
        Route::post('/create', [MontivoryController::class, 'create'])->name('montivorycreate');
        Route::post('/update/{id}', [MontivoryController::class, 'update'])->name('montivoryupdate');
        Route::post('/reorder', [MontivoryController::class, 'reorder'])->name('montivoryreorder');
        Route::delete('/delete/{id}', [MontivoryController::class, 'delete'])->name('montivorydelete');
        Route::get('/list', [MontivoryController::class, 'list'])->name('montivorylist');
    });
    Route::prefix('contacts')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contactindex');
        Route::get('/view/{id}', [ContactController::class, 'view'])->name('contactview');
        Route::get('/list', [ContactController::class, 'list'])->name('contactlist');
    });
    Route::prefix('filemanager')->group(function () {
        Route::get('/images', [FileManagerController::class, 'images'])->name('manageimages');
        Route::get('/files', [FileManagerController::class, 'files'])->name('managefiles');
    });
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';
