<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/position', [ApiController::class, 'position'])->name('apiposition');
Route::post('/cv', [ApiController::class, 'uploadcv'])->name('apiupload');
Route::post('/contact', [ApiController::class, 'contact'])->name('apicontact');
