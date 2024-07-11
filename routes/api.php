<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/getuserscode', [UserController::class, 'getUsersCode']);

Route::post('/senduser', [UserController::class, 'sendUserData']);