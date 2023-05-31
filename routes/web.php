<?php

use Illuminate\Support\Facades\Route;


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


Route::get('/', [App\Http\Controllers\MovieController::class, 'index'])->name('home');
Route::get('/movie', [App\Http\Controllers\MovieController::class, 'movie_index'])->name('movie_home');
Route::post('/store-movie', [App\Http\Controllers\MovieController::class, 'store_movie'])->name('store-movie');
Route::get('/getmovie_detail', [App\Http\Controllers\MovieController::class, 'getmovieInfor'])->name('get_movie');
Route::post('/update-movie', [App\Http\Controllers\MovieController::class, 'update_movie'])->name('updatemovie');
Route::get('/delete_movies', [App\Http\Controllers\MovieController::class, 'destroy_movie'])->name('delete_movies');
Auth::routes();
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    return $exitCode;
});
Route::get('/clear-route', function () {
    $exitCode = Artisan::call('route:clear');
    return $exitCode;
});
Route::get('/optimize-clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return $exitCode;
});

Route::get('/clear-view', function () {
    $exitCode = Artisan::call('view:clear');
    return $exitCode;
});

Route::get('/clear-laravel-log-file', function () {
    exec('rm -f ' . storage_path('logs/*.log'));
    exec('rm -f ' . base_path('*.log'));
    return "Log file deleted";
});
