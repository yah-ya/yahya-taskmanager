<?php

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

Route::middleware(['auth:api','CheckAuthToken'])->group(function () {
    Route::get('/labels',[\Yahyya\taskmanager\App\Http\Controllers\LabelController::class,'list']);
    Route::post('/label/new',[\Yahyya\taskmanager\App\Http\Controllers\LabelController::class,'store']);

    Route::get('/tasks',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'list']);
    Route::get('/tasks/{task}',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'view']);
    Route::post('/task/new',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'store']);
    Route::post('/tasks/{task}/update',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'update']);
    Route::post('/tasks/{task}/status/toggle',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'toggleStatus']);
    Route::post('/tasks/{task}/labels/add',[\Yahyya\taskmanager\App\Http\Controllers\TaskController::class,'mergeLabel']);
});
