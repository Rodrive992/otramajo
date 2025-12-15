<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogArticuloController;
use App\Http\Controllers\VideosController;
use App\Http\Controllers\OtraMajoAuthController;
use App\Http\Controllers\OtraMajoAdminController;
use App\Http\Controllers\AdminBlogArticuloController;
use App\Http\Controllers\AdminVideoController;
use App\Http\Controllers\BlogComentarioController;

Route::get('/', function () {
    return view('otramajo.index');
})->name('home');

Route::get('Sobre-mi', function () {
    return view('otramajo.sobremi');
})->name('Sobre-mi');

Route::redirect('/Blog', '/blog')->name('Blog');

// ---------------- PUBLIC ----------------

// Blog
Route::get('/blog', [BlogArticuloController::class, 'index'])->name('blog.index');
Route::get('/blog/{articulo}', [BlogArticuloController::class, 'show'])
    ->whereNumber('articulo')
    ->name('blog.show');

Route::post('/blog/{articulo}/comentar', [BlogComentarioController::class, 'store'])
    ->whereNumber('articulo')
    ->name('blog.comentar');

// Videos (public)
// Landing con descripción + botones
Route::get('/videos', [VideosController::class, 'index'])->name('videos');

// Listados por tipo (cards con miniaturas)
Route::get('/videos/ejercicios', [VideosController::class, 'ejercicios'])->name('videos.ejercicios');
Route::get('/videos/viajes', [VideosController::class, 'viajes'])->name('videos.viajes');

// ---------- Auth (solo para OtramaJoAdmin) ----------
Route::get('/otramajoadmin/login', [OtraMajoAuthController::class, 'showLogin'])
    ->middleware('guest')->name('otramajoadmin.login');
Route::post('/otramajoadmin/login', [OtraMajoAuthController::class, 'login'])
    ->middleware('guest')->name('otramajoadmin.login.post');
Route::post('/otramajoadmin/logout', [OtraMajoAuthController::class, 'logout'])
    ->middleware('auth')->name('otramajoadmin.logout');

// ---------- Redirección base ----------
Route::get('/otramajoadmin', function () {
    return auth()->check()
        ? redirect()->route('otramajoadmin.index')
        : redirect()->route('otramajoadmin.login');
});

// ---------- Zona protegida ----------
Route::prefix('otramajoadmin')->middleware('auth')->group(function () {
    Route::get('/index', [OtraMajoAdminController::class, 'index'])->name('otramajoadmin.index');

    // Blog
    Route::get('/blog',         [AdminBlogArticuloController::class, 'index'])->name('otramajoadmin.blog.index');
    Route::get('/blog/crear',   [AdminBlogArticuloController::class, 'create'])->name('otramajoadmin.blog.create');
    Route::post('/blog',        [AdminBlogArticuloController::class, 'store'])->name('otramajoadmin.blog.store');
    Route::get('/blog/{id}/editar', [AdminBlogArticuloController::class, 'edit'])->name('otramajoadmin.blog.edit');
    Route::put('/blog/{id}',    [AdminBlogArticuloController::class, 'update'])->name('otramajoadmin.blog.update');
    Route::delete('/blog/{id}', [AdminBlogArticuloController::class, 'destroy'])->name('otramajoadmin.blog.destroy');
    Route::get('/blog/{id}', function ($id) { return redirect()->route('otramajoadmin.blog.edit', $id); })
        ->name('otramajoadmin.blog.show');

    // Videos (Admin)
    Route::get('/videos',         [AdminVideoController::class, 'index'])->name('otramajoadmin.videos.index');
    Route::get('/videos/crear',   [AdminVideoController::class, 'create'])->name('otramajoadmin.videos.create');
    Route::post('/videos',        [AdminVideoController::class, 'store'])->name('otramajoadmin.videos.store');
    Route::get('/videos/{id}/editar', [AdminVideoController::class, 'edit'])->name('otramajoadmin.videos.edit');
    Route::put('/videos/{id}',    [AdminVideoController::class, 'update'])->name('otramajoadmin.videos.update');
    Route::delete('/videos/{id}', [AdminVideoController::class, 'destroy'])->name('otramajoadmin.videos.destroy');
});