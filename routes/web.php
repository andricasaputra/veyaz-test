<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('', function(){
	return view('auth.login');
})->name('login');


Route::get('users', [UserController::class, 'index'])->name('users.home');

Route::get('users/create', [UserController::class, 'create'])->name('users.create');

Route::get('users/edit/{id?}', [UserController::class, 'edit'])->name('users.edit');

Route::get('roles', [RoleController::class, 'index'])->name('roles.home');

Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');

Route::get('roles/edit/{id?}', [RoleController::class, 'edit'])->name('roles.edit');
