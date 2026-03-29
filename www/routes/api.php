<?php

use App\Http\Controllers\DBI\IndexController as DBIIndexController;
use App\Http\Controllers\Tinfoil\IndexController as TinfoilIndexController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::get('tinfoil', TinfoilIndexController::class)
    ->name('tinfoil');

Route::get('dbi/{path?}', DBIIndexController::class)
    ->where('path', '.*')
    ->name('dbi');
