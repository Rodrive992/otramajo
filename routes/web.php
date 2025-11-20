<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogArticuloController;
use App\Http\Controllers\OtraMajoAuthController;
use App\Http\Controllers\OtraMajoAdminController;
use App\Http\Controllers\AdminBlogArticuloController;
use App\Http\Controllers\BlogComentarioController;

Route::get('/', function () {
    return view('otramajo.index');
})->name('home');

Route::get('Sobre-mi', function () {
    return view('otramajo.sobremi');
})->name('Sobre-mi');

Route::redirect('/Blog', '/blog')->name('Blog');

// Listado público
Route::get('/blog', [BlogArticuloController::class, 'index'])->name('blog.index');

// Detalle público (por id). Si luego le agregamos slug, lo cambiamos.
Route::get('/blog/{articulo}', [BlogArticuloController::class, 'show'])
    ->whereNumber('articulo')
    ->name('blog.show');

// Guardar comentario
Route::post('/blog/{articulo}/comentar', [BlogComentarioController::class, 'store'])
    ->whereNumber('articulo')
    ->name('blog.comentar');

// ---------- Auth (solo para OtramaJoAdmin) ----------
Route::get('/otramajoadmin/login', [OtramaJoAuthController::class, 'showLogin'])
    ->middleware('guest')->name('otramajoadmin.login');
Route::post('/otramajoadmin/login', [OtramaJoAuthController::class, 'login'])
    ->middleware('guest')->name('otramajoadmin.login.post');
Route::post('/otramajoadmin/logout', [OtramaJoAuthController::class, 'logout'])
    ->middleware('auth')->name('otramajoadmin.logout');

// ---------- Redirección base ----------
Route::get('/otramajoadmin', function () {
    return auth()->check()
        ? redirect()->route('otramajoadmin.index')
        : redirect()->route('otramajoadmin.login');
});

// ---------- Zona protegida ----------
Route::prefix('otramajoadmin')->middleware('auth')->group(function () {
    Route::get('/index', [OtramaJoAdminController::class, 'index'])->name('otramajoadmin.index');

    // Secciones (solo Blog funcional, resto a #)
    Route::get('/blog',         [AdminBlogArticuloController::class, 'index'])->name('otramajoadmin.blog.index');
    Route::get('/blog/crear',   [AdminBlogArticuloController::class, 'create'])->name('otramajoadmin.blog.create');
    Route::post('/blog',        [AdminBlogArticuloController::class, 'store'])->name('otramajoadmin.blog.store');
    Route::get('/blog/{id}/editar', [AdminBlogArticuloController::class, 'edit'])->name('otramajoadmin.blog.edit');
    Route::put('/blog/{id}',    [AdminBlogArticuloController::class, 'update'])->name('otramajoadmin.blog.update');
    Route::delete('/blog/{id}', [AdminBlogArticuloController::class, 'destroy'])->name('otramajoadmin.blog.destroy');
    Route::get('/blog/{id}', function ($id) { return redirect()->route('otramajoadmin.blog.edit', $id);
    })->name('otramajoadmin.blog.show');
});