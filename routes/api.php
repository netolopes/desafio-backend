<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;

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
Route::get('/convert', [ManagerController::class,'convertData']);

Route::get('/news-today/{dt_today}', [ManagerController::class,'todayNews']);

Route::get('/news-category/{category}', [ManagerController::class,'newsByCategory']);

Route::get('/news-all', [ManagerController::class,'allNews']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


