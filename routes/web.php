<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('otramajo.index');
})->name('home');

Route::get('Sobre-mi', function () {
    return view('otramajo.sobremi');
})->name('Sobre-mi');
