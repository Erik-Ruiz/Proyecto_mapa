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
Route::post("/admin/login",[UsuarioController::class, "login"])->name("login");
//Ruta para ir al perfil
Route::get("/admin/perfil",[UsuarioController::class, "perfil"])->name("perfil");
//Ruta para ir al crud
Route::get("/admin/crud",[UsuarioController::class, "crud"])->name("crud");
//Ruta para recibir la cantidad total de registros del crud
Route::post("/totalData", [UsuarioController::class, "totalData"])->name("totalData");
//Ruta para recibir los datos de la tabla del crud
Route::post("/getData", [UsuarioController::class, "getData"])->name("getData");

//Ruta para registrarte
Route::post("/admin/register",[UsuarioController::class, "register"])->name("register");
Route::get("/user/mapa_main",[UsuarioController::class, "user"]);

//RUTAS PÁGINA PRINCIPAL MAPAS
//Ruta mapa
Route::get('/mapa_principal', [UsuarioController::class, 'pagina_mapa_principal']);


























//Llamadas Mapas
