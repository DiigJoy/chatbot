<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API funcionando correctamente']);
});

use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;

// Rutas RESTful
Route::apiResource('knowledges', KnowledgeController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('subcategories', SubcategoryController::class);

Route::middleware('auth:api')
    ->prefix('v1')
    ->group(function () {
        Route::apiResource('knowledges', KnowledgeController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('subcategories', SubcategoryController::class);
    });