<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\DlrController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    /*
|--------------------------------------------------------------------------
|                       SOURCE  "Black List"  
|--------------------------------------------------------------------------
*/
    Route::get('/source', [SourceController::class, 'listall']);
    Route::post('/createSource', [SourceController::class, 'create']);
    Route::delete('/source/{sender_id}', [SourceController::class, 'destroy']);

    /*
|--------------------------------------------------------------------------
|                            Messages
|--------------------------------------------------------------------------
*/
    Route::post('/message/filter', [MessageController::class, 'filter']);
    Route::post('/message/create', [MessageController::class, 'store']);

    /*
|--------------------------------------------------------------------------
|                            Destinations
|--------------------------------------------------------------------------
*/
    Route::post('/createDestination', [DestinationController::class, 'store']);
    /*
|--------------------------------------------------------------------------
|                            DLR
|--------------------------------------------------------------------------
*/
    Route::post('/vendor/setDlr', [DlrController::class, 'setMessageDlr']);
});
