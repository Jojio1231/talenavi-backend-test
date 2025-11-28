<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

Route::get('/user', function (Request $request) 
{
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/todos', [TodoController::class, 'store']);
Route::get('/todos/export', [TodoController::class, 'export']);
