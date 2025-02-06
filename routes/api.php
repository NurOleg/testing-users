<?php

declare(strict_types=1);

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/user', [UserController::class, 'create'])->name('user.create');
Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
Route::get('/user', [UserController::class, 'list'])->name('user.list');
