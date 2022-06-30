<?php

use App\Http\Controllers\API\AdminController;
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

Route::group(['prefix'=>'auth'],function(){
    Route::post('login',[LoginController::class,'login']);
});

Route::group(['prefix'=>'administrasi','middleware'=>['loginCheck','superAdminRole']],function(){
    Route::group(['prefix'=>'menu'],function(){
        Route::get('list/',[AdminController::class,'getMenu']);
        Route::put('change/status/{id}',[AdminController::class,'updateStatusMenu']);
    });
});

Route::group(['prefix'=>'crew'],function(){
    Route::group(['prefix'=>'order'],function(){
    Route::get('list',[CrewController::class,'getOrder']);
    Route::put('final/{id}',[CrewController::class,'finalisasi']);
    
    });
    
});
