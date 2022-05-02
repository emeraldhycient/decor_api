<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/create', [AuthenticationController::class, 'createProject']);
    Route::post('/delete/:slug', [AuthenticationController::class, 'deleteProject']);
});

Route::get('/create-account',[AuthenticationController::class, 'createAccount']);
Route::get('/login',[AuthenticationController::class, 'login']);
Route::post('/projects', [ProjectController::class, 'getProjects']);
Route::post('/projects/:slug', [ProjectController::class, 'getProject']);