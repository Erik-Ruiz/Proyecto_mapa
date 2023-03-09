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
//Ruta para recibir la cantidad total de registros del crud
Route::delete("/deleteCrud", [UsuarioController::class, "deleteCrud"])->name("deleteCrud");
Route::post("/insertPICrud", [UsuarioController::class, "insertPICrud"])->name("insertPICrud");
Route::post("/insertPruebaCrud", [UsuarioController::class, "insertPruebaCrud"])->name("insertPruebaCrud");
//Ruta para recibir los datos de la tabla del crud
Route::post("/getData", [UsuarioController::class, "getData"])->name("getData");

//Ruta para registrarte
Route::post("/admin/register",[UsuarioController::class, "register"])->name("register");
Route::get("/user/mapa_main",[UsuarioController::class, "user"]);

//RUTAS PÁGINA PRINCIPAL MAPAS
//Ruta mapa
Route::get('/mapa_principal', [UsuarioController::class, 'pagina_mapa_principal']);
//Listar los puntos de interés para el mapa
Route::post("/filtro_mapa_principal",[UsuarioController::class, "filtro_mapa_principal"]);
//Recoger los datos de los popups para mostrar en el modal 
Route::post('/recoger_datos_etiqueta', [UsuarioController::class, 'recoger_datos_etiqueta']);


























//Llamadas Mapas
