<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BeneficioController;
use App\Http\Controllers\ConvenioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SocialMediaController;
use App\Http\Controllers\DiretoriaController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\FichaController;
use App\Http\Controllers\SecaoPostController;
use App\Http\Controllers\MapaController;
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

Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.home');
    Route::redirect('/home/admin', '/admin');
    Route::get('/home/{pagina}/{slug?}', [HomeController::class, 'single'])->name('home.single');
    Route::post('/ficha/enviar', [FichaController::class, 'enviar'])->name('ficha.enviar');

    /***
     * Login
     */
    Route::get('/admin', [AuthController::class, 'showLoginForm']);
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login/do', [AuthController::class, 'login'])->name('login.do');
});
/**
 * Admin
 */
Route::group(['middleware' => 'auth:sanctum', 'prefix' => 'admin', config('jetstream.auth_session')], function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/register', [AuthController::class, 'register'])->name('admin.registro');
    Route::post('/store', [AuthController::class, 'store'])->name('admin.store');


    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');

    Route::post('/noticia/atualizar-status', [NoticiaController::class, 'atualizarStatus'])->name('atualizar-status');
    Route::post('/noticia/atualizar-destaque', [NoticiaController::class, 'atualizarDestaque'])->name('atualizar-destaque');
    Route::post('/noticia/removeImageGallery', [NoticiaController::class, 'removeImageGallery'])->name('remove-galery-image');
    Route::resource('noticia', NoticiaController::class);

    Route::post('/video/atualizar-status', [VideoController::class, 'atualizarStatus'])->name('atualizar-status-video');
    Route::resource('video', VideoController::class);

    Route::post('/banner/atualizar-status', [BannerController::class, 'atualizarStatus'])->name('atualizar-status-banner');
    Route::resource('banner', BannerController::class);

    Route::post('/beneficio/atualizar-status', [BeneficioController::class, 'atualizarStatus'])->name('atualizar-status-beneficio');
    Route::resource('beneficio', BeneficioController::class);

    Route::post('/socialmedia/atualizar-status', [SocialMediaController::class, 'atualizarStatus'])->name('atualizar-status-socialmedia');
    Route::resource('socialmedia', SocialMediaController::class);

    Route::resource('usuario', UsuarioController::class);

    Route::resource('upload', UploadController::class);
    Route::post('/upload-imagem', [UploadController::class, 'store'])->name('uploadImagem');
    Route::post('/upload/tmp-upload', [UploadController::class, 'tmpUpload'])->name('tmpUpload');
    Route::post('/upload/tinymce', [UploadController::class, 'uploadTinyMCE'])->name('uploadTinyMCE');
    Route::delete('/upload/tmp-delete', [UploadController::class, 'tmpDelete'])->name('tmpDelete');

    // Mapeando as secoes para o SecaoPostController
    $secoes_site = [
        'sinpol-animal', 'sinpol-mulher', 'sinpol-permutas', 'classificados-sinpol', 
        'sinpol-fiscaliza', 'sinpol-na-rua', 'sinpol-denuncias', 'sinpol-idoso', 
        'sinpol-esportes', 'sinpol-peritos',
        'diretoria', 'historia', 'fale-conosco', 'como-chegar', 'principais-links',
        'convenio'
    ];
    foreach($secoes_site as $secao) {
        Route::group(['prefix' => $secao, 'as' => $secao.'.'], function() use ($secao) {
            Route::get('/', [SecaoPostController::class, 'index'])->defaults('tipo', $secao)->name('index');
            Route::post('/', [SecaoPostController::class, 'store'])->defaults('tipo', $secao)->name('store');
            Route::post('/atualizar-status', [SecaoPostController::class, 'atualizarStatus'])->defaults('tipo', $secao)->name('atualizar-status');
            Route::put('/{id}', [SecaoPostController::class, 'update'])->defaults('tipo', $secao)->name('update');
            Route::get('/{id}/edit', [SecaoPostController::class, 'edit'])->defaults('tipo', $secao)->name('edit');
            Route::delete('/{id}', [SecaoPostController::class, 'destroy'])->defaults('tipo', $secao)->name('destroy');
        });
    }

    Route::post('/mapas/atualizar-status', [MapaController::class, 'atualizarStatus'])->name('atualizar-status-mapa');
    Route::resource('mapas', MapaController::class);

});
