<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GameController as GameController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/companies', [CompanyController::class, 'index']);
Route::group(['middleware' => ['role:admin']], function () {
    Route::post('/companies', [CompanyController::class, 'store']);
    Route::put('/companies/{id}', [CompanyController::class, 'update']);
    Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);
});
Route::get('/companies/{id}', [CompanyController::class, 'show']);

Route::get('/games', [GameController::class, 'index']);
Route::group(['middleware' => ['auth']], function () {
    Route::post('/games', [GameController::class, 'store']);
    Route::put('/games/{game}', [GameController::class, 'update']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);
});
Route::get('/games/{game}', [GameController::class, 'show']);

