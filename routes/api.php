<?php

use App\Http\Controllers\auth\UserAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\TechniqueController;
use Illuminate\Support\Facades\Route;

//authentication
Route::post('/login', [UserAuthController::class, 'login'])->name('login');
Route::post('/register', [UserAuthController::class, 'register'])->name('register');

Route::middleware(['auth:api'])->group(function () {
    //characters
    Route::resource('/personajes', CharacterController::class);
    //categories
    Route::resource('/categorias', CategoryController::class);
    //techniques
    Route::resource('/tecnicas', TechniqueController::class);

    //logout
    Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
});
