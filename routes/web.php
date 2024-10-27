<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
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
Route::get('/admin',[AuthController::class,'dashboard'])->name('admin');
Route::get('/admin/login',[AuthController::class,'showLoginForm'])->name('admin.login');
Route::post('/admin/login/do',[AuthController::class,'login'])->name('admin.login.do');

/**
 * Admin
*/
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin',config('jetstream.auth_session')], function(){
  Route::get('/logout',[AuthController::class,'logout'])->name('admin.logout');
  Route::get('/dashboard',[AuthController::class,'dashboard'])->name('admin.dashboard');
  Route::get('/register',[AuthController::class,'register'])->name('admin.register');
  Route::post('/store',[AuthController::class,'store'])->name('admin.store');

  Route::resource('noticia',NoticiaController::class);

});
