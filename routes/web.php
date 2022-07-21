<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureWorksController;
use App\Http\Controllers\UserCommentsController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/id/{X}', [UserCommentsController::class, 'getIDx']);
Route::get('/test', [PictureWorksController::class, 'getTest']);

Route::post('/commentNoneJsnForm', [UserCommentsController::class, 'postNoneJsnForm'])->name('comment_form_nojsn');
Route::post('/commentWithJsnForm', [UserCommentsController::class, 'postWithJsnForm'])->name('comment_form_withjsn');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
