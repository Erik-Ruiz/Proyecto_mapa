<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Ruta para ir al login
Route::get("/",[UsuarioController::class, "index"])->name("index");
//Ruta para logearte
Route::post("/login",[UsuarioController::class, "login"])->name("login");
//Ruta para ir al perfil
Route::get("/perfil",[UsuarioController::class, "perfil"])->name("perfil");
//Ruta para ir al crud
Route::get("/crud",[UsuarioController::class, "crud"])->name("crud");

//RUTAS PÁGINA PRINCIPAL MAPAS
//Ruta mapa
Route::get('/mapa_principal', [UsuarioController::class, 'pagina_mapa_principal']);


























//Llamadas Mapas
