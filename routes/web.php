<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
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


Route::get('/',[HomeController::class,'index'])->name('home.home');

//Route::get('/dashboard', function () {
 //  return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

//require __DIR__.'/auth.php';
/***
 * Login
 */
Route::get('/admin',[AuthController::class,'showLoginForm']);
Route::get('/admin/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/admin/login/do',[AuthController::class,'login'])->name('login.do');

/**
 * Admin
*/
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin',config('jetstream.auth_session')], function(){
  Route::get('/logout',[AuthController::class,'logout'])->name('admin.logout');
  Route::get('/register',[AuthController::class,'register'])->name('admin.register');
  Route::post('/store',[AuthController::class,'store'])->name('admin.store');

  
  Route::get('/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard');
  
  Route::resource('noticia',NoticiaController::class);

  Route::resource('upload',  UploadController::class);
  Route::post('/upload-imagem', [UploadController::class, 'store'])->name('uploadImagem');
  Route::post('/upload/tmp-upload', [UploadController::class, 'tmpUpload'])->name('tmpUpload');
  Route::delete('/upload/tmp-delete', [UploadController::class, 'tmpDelete'])->name('tmpDelete');

});
