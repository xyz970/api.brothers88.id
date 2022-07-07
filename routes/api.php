<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\SuperAdminController;
use App\Http\Controllers\API\CrewController;
use App\Http\Controllers\API\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [LoginController::class, 'login']);
    Route::get('logout', [LoginController::class, 'logout'])->middleware('loginCheck');
});

//Admin Route
Route::group(['prefix' => 'admin'], function () {
    Route::prefix('order')->group(function () {
        Route::get('list/', [AdminController::class, 'orderList']);
        Route::prefix('table')->group(function(){
            Route::get('list/{table_id}',[AdminController::class,'tableDetail']);
            Route::get('total/{table_id}',[AdminController::class,'getTotal']);
            Route::post('pay/{table_id}',[AdminController::class,'tablePay']);
        });
    });
});

/**
 * Super Admin Routes ;
 */
Route::group(['prefix' => 'superadmin', 'middleware' => ['loginCheck', 'superAdminRole']], function () {
    Route::get('main',[SuperAdminController::class,'getInformation']);
    Route::group(['prefix' => 'menu'], function () {
        Route::post('insert',[SuperAdminController::class,'insertMenu']);
        Route::get('list/', [SuperAdminController::class, 'getMenu']);
        Route::put('change/status/{id}', [SuperAdminController::class, 'updateStatusMenu']);
        Route::put('update/{id}',[SuperAdminController::class,'updateMenu']);
    });

    Route::prefix('category')->group(function(){
        Route::post('insert',[SuperAdminController::class,'insertCategory']);
        Route::get('list',[SuperAdminController::class,'categoryList']);
    });
});

//Route Crew
Route::group(['prefix' => 'crew', 'middleware' => ['loginCheck']], function () {
    Route::group(['prefix' => 'order'], function () {
        Route::get('list', [CrewController::class, 'getOrder']);
        Route::put('valid/{id}', [CrewController::class, 'validasi']);
        Route::get('detail/{id}', [CrewController::class, 'detail']);
    });
});
