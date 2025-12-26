<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::get('tinfoil', \App\Http\Controllers\Tinfoil\IndexController::class)
    ->name('tinfoil');

Route::get('dbi/{path?}', \App\Http\Controllers\DBI\IndexController::class)
    ->where('path', '.*')
    ->name('dbi');
