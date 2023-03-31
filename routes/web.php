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

    Route::group(['prefix' => 'stock'], function () {
        Route::get('/', [App\Http\Controllers\StockController::class, 'stock_index'])->name('stock_home');
        Route::post('/store-stock', [App\Http\Controllers\StockController::class, 'store_stock'])->name('store-stock');
        Route::get('/getstock_detail', [App\Http\Controllers\StockController::class, 'getstockInfor'])->name('getstock');
        Route::post('/update-stock', [App\Http\Controllers\StockController::class, 'update_stock'])->name('updatestock');
        Route::get('/delete-stock', [App\Http\Controllers\StockController::class, 'destroy_stock'])->name('delete-stock');
        Route::get('/stock_price', [App\Http\Controllers\StockController::class, 'stockPrice'])->name('get_stock_price');
    });
    Route::group(['prefix' => 'project'], function () {
        Route::get('/', [App\Http\Controllers\ProjectController::class, 'project_index'])->name('project_home');
        Route::get('/add-project', [App\Http\Controllers\ProjectController::class, 'add_project'])->name('add-project');
        Route::post('/store-project', [App\Http\Controllers\ProjectController::class, 'store_project'])->name('store-project');
        Route::get('/getproject_detail', [App\Http\Controllers\ProjectController::class, 'getprojectInfor'])->name('getproject');
        Route::post('/update-project', [App\Http\Controllers\ProjectController::class, 'update_project'])->name('updateproject');
        Route::get('/delete-project', [App\Http\Controllers\ProjectController::class, 'destroy_project'])->name('delete-project');
        Route::get('/edit_project/{id}', [App\Http\Controllers\ProjectController::class, 'projectDetails'])->name('project-details');
        Route::get('/project_approve', [App\Http\Controllers\ProjectController::class, 'project_app_approve'])->name('project_approve');
        Route::get('/project_decline', [App\Http\Controllers\ProjectController::class, 'project_app_decline'])->name('project_decline');
    });
    Route::group(['prefix' => 'requisition'], function () {
        Route::get('/', [App\Http\Controllers\RequisitionController::class, 'requisition_index'])->name('requisition_home');
        Route::get('/get-requisition-pending-order', [App\Http\Controllers\RequisitionController::class, 'customerPendingrequisition'])->name('get-requisition-pending-order');
        Route::get('/get-requisition-by-id', [App\Http\Controllers\RequisitionController::class, 'requistionDeliveryById'])->name('get-requisition-by-id');
    });
});

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
