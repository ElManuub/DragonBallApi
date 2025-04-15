<?php

use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\TechniqueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [UserAuthController::class, 'login'])->name('login');
Route::post('/register', [UserAuthController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
    //characters
    Route::resource('/personajes', CharacterController::class);
    //categories
    Route::resource('/categorias', CategoryController::class);
    //techniques
    Route::resource('/tecnicas', TechniqueController::class);
});
