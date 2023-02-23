<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [LoginController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('user', function(){
        return request()->user();
    })->name('user');

    Route::post('auth/logout', [LoginController::class, 'logout'])->name('logout');

    Route::apiResource('users', UserController::class)->except(['update', 'show', 'destroy']);

    Route::put('users/{user?}', [UserController::class, 'update'])->name('users.update');

    Route::delete('users/{user?}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::apiResource('roles', RoleController::class)->except(['update', 'show', 'destroy']);

    Route::put('roles/{role?}', [RoleController::class, 'update'])->name('roles.update');

    Route::delete('roles/{role?}', [RoleController::class, 'destroy'])->name('roles.destroy');
    
});
