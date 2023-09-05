<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StallsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::post('/users/create',[UserController::class,'create']);
Route::post('/users/login',[UserController::class,'login']);

Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('/stalls', [StallsController::class, 'index']);
    Route::post('/stalls',[StallsController::class, 'store']);
    Route::get('/stalls/{stalls}',[StallsController::class,'show']);
    Route::put('/stalls/{stalls}',[StallsController::class,'update']);
    Route::delete('/stalls/{stalls}',[StallsController::class,'destroy']);
    Route::get('/employees',[EmployeesController::class,'index']);
    Route::post('/employees',[EmployeesController::class,'store']);
    Route::get('/employees/{employees}',[EmployeesController::class,'show']);
    Route::put('/employees/{employees}',[EmployeesController::class,'update']);
    Route::delete('/employees/{employees}',[EmployeesController::class,'destroy']);
    Route::get('/users/logout',[UserController::class,'logout']);
});