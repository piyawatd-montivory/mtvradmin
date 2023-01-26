<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admins\DashboardController;
use App\Http\Controllers\Admins\LoginController;
use App\Http\Controllers\WebController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\PartnerController;
use App\Http\Controllers\Admins\PositionController;
use App\Http\Controllers\Admins\SkillInterestController;
use App\Http\Controllers\Admins\ContentController;
use App\Http\Controllers\Admins\MontivoryController;
use App\Http\Controllers\Admins\ContactController;
use App\Http\Controllers\Admins\FileManagerController;
use App\Http\Controllers\Admins\PagecontentController;
use App\Http\Controllers\Admins\ImageController;
use App\Http\Controllers\Admins\CategoryController;
use App\Http\Controllers\Admins\ConfigController;
use App\Http\Controllers\Admins\TagsController;
use App\Http\Middleware\EnsureSignin;

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
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/category/{slug}', [BlogController::class, 'category'])->name('category');
Route::get('/tags/{slug}', [BlogController::class, 'tags'])->name('tags');
Route::get('/search/{search}', [BlogController::class, 'search'])->name('search');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('blogpost');
Route::get('/noresult', [BlogController::class, 'noresult'])->name('noresult');
Route::get('/importblog', [BlogController::class, 'importblog'])->name('importblog');
Route::get('/career', [WebController::class, 'career'])->name('career');
Route::get('/career/{alias}', [WebController::class, 'careerdetail'])->name('careerdetail');
Route::get('/careerfinish', [WebController::class, 'careerfinish'])->name('careerfinish');
Route::get('/cachedata', [ConfigController::class, 'index'])->name('cachedata');
Route::prefix('admins')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->middleware([EnsureSignin::class])->name('dashboard');
    Route::get('/signin', [LoginController::class, 'signin'])->name('signin');
    Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
    Route::post('/signout', [LoginController::class, 'signout'])->name('signout');
    Route::prefix('categories')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('categoryindex');
        Route::get('/new', [CategoryController::class, 'new'])->name('categorynew');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categoryedit');
        Route::post('/create', [CategoryController::class, 'create'])->name('categorycreate');
        Route::post('/checkslug', [CategoryController::class, 'checkslug'])->name('checkslugcategory');
        Route::post('/archived', [CategoryController::class, 'archived'])->name('categoryarchived');
        Route::get('/list', [CategoryController::class, 'list'])->name('categorylist');
    });
    Route::prefix('tags')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [TagsController::class, 'index'])->name('tagsindex');
        Route::get('/new', [TagsController::class, 'new'])->name('tagsnew');
        Route::get('/edit/{id}', [TagsController::class, 'edit'])->name('tagsedit');
        Route::post('/create', [TagsController::class, 'create'])->name('tagscreate');
        Route::post('/checktag', [TagsController::class, 'checkid'])->name('checktag');
        Route::post('/checktagname', [TagsController::class, 'checkname'])->name('checktagname');
        Route::get('/list', [TagsController::class, 'list'])->name('tagslist');
        Route::delete('/delete/{id}', [TagsController::class, 'delete'])->name('tagsdelete');
    });
    Route::prefix('contents')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [ContentController::class, 'index'])->name('contentindex');
        Route::get('/new', [ContentController::class, 'new'])->name('contentnew');
        Route::post('/checkslug', [ContentController::class, 'checkslug'])->name('contentcheckslug');
        Route::get('/edit/{id}', [ContentController::class, 'edit'])->name('contentedit');
        Route::get('/preview/{id}', [ContentController::class, 'preview'])->name('contentpreview');
        Route::get('/gallery/{id}', [ContentController::class, 'gallery'])->name('contentgallery');
        Route::post('/gallery/{id}', [ContentController::class, 'updategallery'])->name('contentgalleryupdate');
        Route::post('/create', [ContentController::class, 'create'])->name('contentcreate');
        Route::delete('/delete/{id}', [ContentController::class, 'delete'])->name('contentdelete');
        Route::get('/list', [ContentController::class, 'list'])->name('contentlist');
        Route::post('/published', [ContentController::class, 'published'])->name('published');
        Route::post('/unpublished', [ContentController::class, 'unpublished'])->name('unpublished');
        Route::post('/archived', [ContentController::class, 'archived'])->name('archived');
        Route::post('/unarchived', [ContentController::class, 'unarchived'])->name('unarchived');
    });
    Route::prefix('pagecontents')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [PagecontentController::class, 'index'])->name('pagecontentindex');
        Route::get('/new', [PagecontentController::class, 'new'])->name('pagecontentnew');
        Route::get('/edit/{id}', [PagecontentController::class, 'edit'])->name('pagecontentedit');
        Route::post('/create', [PagecontentController::class, 'create'])->name('pagecontentcreate');
        Route::delete('/delete/{id}', [PagecontentController::class, 'delete'])->name('pagecontentdelete');
        Route::get('/list', [PagecontentController::class, 'list'])->name('pagecontentlist');
        Route::post('/checkslug', [PagecontentController::class, 'checkslug'])->name('pagecontentcheckslug');
    });
    Route::prefix('users')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('userindex');
        Route::get('/new', [UserController::class, 'new'])->name('usernew');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('useredit');
        Route::post('/update', [UserController::class, 'update'])->name('userupdate');
        Route::post('/updatepenname', [UserController::class, 'updatepenname'])->name('userupdatepenname');
        Route::post('/deletepenname', [UserController::class, 'deletepenname'])->name('userdeletepenname');
        Route::get('/list', [UserController::class, 'list'])->name('userlist');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/checkemail', [UserController::class, 'checkemail'])->name('checkemail');
    });
    Route::prefix('positions')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('positionindex');
        Route::get('/new', [PositionController::class, 'new'])->name('positionnew');
        Route::get('/edit/{id}', [PositionController::class, 'edit'])->name('positionedit');
        Route::post('/create', [PositionController::class, 'create'])->name('positioncreate');
        Route::post('/update/{id}', [PositionController::class, 'update'])->name('positionupdate');
        Route::delete('/delete/{id}', [PositionController::class, 'delete'])->name('positiondelete');
        Route::get('/list', [PositionController::class, 'list'])->name('positionlist');
        Route::post('/checkslug', [PositionController::class, 'checkslug'])->name('positioncheckslug');
    });
    Route::prefix('skills')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [SkillInterestController::class, 'index'])->name('skillindex');
        Route::get('/new', [SkillInterestController::class, 'new'])->name('skillnew');
        Route::get('/edit/{id}', [SkillInterestController::class, 'edit'])->name('skilledit');
        Route::post('/create', [SkillInterestController::class, 'create'])->name('skillcreate');
        Route::delete('/delete/{id}', [SkillInterestController::class, 'delete'])->name('skilldelete');
        Route::get('/list', [SkillInterestController::class, 'list'])->name('skilllist');
    });
    // Route::prefix('montivory')->group(function () {
    //     Route::get('/', [MontivoryController::class, 'index'])->name('montivoryindex');
    //     Route::get('/new', [MontivoryController::class, 'new'])->name('montivorynew');
    //     Route::get('/edit/{id}', [MontivoryController::class, 'edit'])->name('montivoryedit');
    //     Route::post('/create', [MontivoryController::class, 'create'])->name('montivorycreate');
    //     Route::post('/update/{id}', [MontivoryController::class, 'update'])->name('montivoryupdate');
    //     Route::post('/reorder', [MontivoryController::class, 'reorder'])->name('montivoryreorder');
    //     Route::delete('/delete/{id}', [MontivoryController::class, 'delete'])->name('montivorydelete');
    //     Route::get('/list', [MontivoryController::class, 'list'])->name('montivorylist');
    // });
    Route::prefix('contacts')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contactindex');
        Route::get('/view/{id}', [ContactController::class, 'view'])->name('contactview');
        Route::get('/list', [ContactController::class, 'list'])->name('contactlist');
    });
    Route::prefix('images')->middleware([EnsureSignin::class])->group(function () {
        Route::get('/', [ImageController::class, 'index'])->name('imagesindex');
        Route::get('/new', [ImageController::class, 'new'])->name('imagesnew');
        Route::get('/edit/{id}', [ImageController::class, 'edit'])->name('imageedit');
        Route::post('/update', [ImageController::class, 'update'])->name('imageupdate');
        Route::post('/updatenewimage', [ImageController::class, 'updatenewimage'])->name('imageupdatenewimage');
        Route::get('/ck', [ImageController::class, 'ck'])->name('imageck');
        Route::get('/browse', [ImageController::class, 'browseimage'])->name('imagebrowse');
        Route::get('/loadimage', [ImageController::class, 'loadimage'])->name('imageckloadimage');
        Route::get('/list', [ImageController::class, 'list'])->name('imagelist');
        Route::post('/upload', [ImageController::class, 'upload'])->name('imageupload');
        Route::put('/updatestatus/{id}', [ImageController::class, 'updatestatus'])->name('imageupdatestatus');
        Route::post('/uploadprofile', [ImageController::class, 'uploadprofile'])->name('imageuploadprofile');
        Route::post('/delete', [ImageController::class, 'delete'])->name('imagedelete');
        Route::post('/published', [ImageController::class, 'published'])->name('imagepublished');
        Route::post('/unpublished', [ImageController::class, 'unpublished'])->name('imageunpublished');
        Route::post('/archived', [ImageController::class, 'archived'])->name('imagearchived');
        Route::post('/unarchived', [ImageController::class, 'unarchived'])->name('imageunarchived');
    });
    // Route::prefix('filemanager')->group(function () {
    //     Route::get('/images', [FileManagerController::class, 'images'])->name('manageimages');
    //     Route::get('/files', [FileManagerController::class, 'files'])->name('managefiles');
    // });
});

// Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//     \UniSharp\LaravelFilemanager\Lfm::routes();
// });

// require __DIR__.'/auth.php';
