<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectsController;

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


//@admin1980 ,administrator@mpdesign.com

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/projects/create', [ProjectsController::class, 'createProject']);
    Route::post('/projects/delete/:slug', [ProjectsController::class, 'deleteProject']);
});

Route::post('/create-account',[AuthenticationController::class, 'createAccount']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::get('/projects', [ProjectsController::class, 'getProjects']);
Route::get('/project/{slug}', [ProjectsController::class, 'getProject']);
Route::get('/projects/{status}', [ProjectsController::class, 'getProjectsByStatus']);