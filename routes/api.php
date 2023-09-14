<?php

use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiTokenMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/auth/login",[UserController::class,"login"]);

Route::middleware(ApiTokenMiddleware::class)->group(function(){
    Route::post("/auth/logout",[UserController::class,"logout"]);

    // consultations
    Route::get("/consultations",[ConsultationController::class,"show"]);
    Route::post("/consultations",[ConsultationController::class,"store"]);
});