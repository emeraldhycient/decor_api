<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\sendEmailController;

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

    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/projects/create', [ProjectsController::class, 'create']);
    Route::post('/projects/update', [ProjectsController::class, 'update']);
    Route::post('/projects/delete/:slug', [ProjectsController::class, 'deleteProject']);
});

Route::post('/create-account',[AuthenticationController::class, 'createAccount']);
Route::post('/login',[AuthenticationController::class, 'login']);
Route::get('/projects', [ProjectsController::class, 'getProjects']);
Route::get('/projects/{status}', [ProjectsController::class, 'getProjectsByStatus']);
Route::get('/project/{slug}', [ProjectsController::class, 'getProject']);


Route::get('/', function () {
    return ["message" => "Welcome to the MPDesign API"];
});