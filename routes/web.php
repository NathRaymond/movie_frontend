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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
});
Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [App\Http\Controllers\UserController::class, 'user_index'])->name('user_home');
        Route::post('/stores', [App\Http\Controllers\UserController::class, 'store'])->name('add_new_user');
        Route::get('/getuser_detail', [App\Http\Controllers\UserController::class, 'getUserInfor'])->name('getuser');
        Route::post('/update', [App\Http\Controllers\UserController::class, 'update_user'])->name('update-users');
        Route::get('/delete', [App\Http\Controllers\UserController::class, 'destroy'])->name('delete_user');
    });

    Route::group(['prefix' => 'contractor'], function () {
        Route::get('/', [App\Http\Controllers\ContractorController::class, 'contractor_index'])->name('contractor_home');
        Route::post('/store-contractor', [App\Http\Controllers\ContractorController::class, 'store_contractor'])->name('store-contractor');
        Route::get('/getcontractor_detail', [App\Http\Controllers\ContractorController::class, 'getcontractorInfor'])->name('getcontractor');
        Route::post('/update-contractor', [App\Http\Controllers\ContractorController::class, 'update_contractor'])->name('update-contractor');
        Route::get('/delete-contractor', [App\Http\Controllers\ContractorController::class, 'destroy_contractor'])->name('delete-contractor');
    });

});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
