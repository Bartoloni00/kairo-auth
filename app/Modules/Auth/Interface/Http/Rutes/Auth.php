<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Interface\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
  //Route::post('login', 'login');
  //Route::post('logout', 'logout');
  //Route::post('refresh', 'refresh');
  Route::post('register', 'register');
  //Route::get('me', 'me');
});
