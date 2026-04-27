<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Auth\Interfaces\Http\Controllers\AuthController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
  Route::post('login', 'login')->middleware('throttle:login');
  // Todavia no vamos a agregar logout y refresh. el JWT tiene un tiempo de expiracion corto (1 hora)
  // Por lo que el logout se manejara solo desde el front (borrando el token del localStorage)
  // refresh no es necesario ya que si el usuario quiere generar un nuevo token puede simplemente cerrar sesion y volver a iniciar sesion
  //Route::post('logout', 'logout');
  //Route::post('refresh', 'refresh');
  /*
  - Publico
  - modificar este registro para que solo pida: email, password y project_id lo demas debera quedar opcionalmente como null
  */
  Route::post('register', 'register')->middleware('throttle:register');
  Route::get('me', 'me')->middleware(['jwt', 'throttle:api']);
});
