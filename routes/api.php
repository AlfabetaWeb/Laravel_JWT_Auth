<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use GuzzleHttp\Middleware;
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
//USER authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(["middleware" => "jwt.auth"], function(){
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
} );

// Route::get('/me', [AuthController::class, 'me'])->middleware('jwt.auth');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('jwt.auth');

//TASKS
Route::group(["middleware" => "jwt.auth"], function(){    
    Route::post('/tasks', [TaskController::class, 'createTask']);
    Route::post('/tasks', [TaskController::class, 'getAllTask']);
    Route::get('/tasks/{id}', [TaskController::class, 'getTaskById']);
} );