<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

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
Route::post("/getDataById", [UsuarioController::class, "getDataById"])->name("getDataById");
Route::put("/modPruebaCrud", [UsuarioController::class, "modPruebaCrud"])->name("modPruebaCrud");
Route::put("/modPICrud", [UsuarioController::class, "modPICrud"])->name("modPICrud");



//Ruta para recibir los datos de la tabla del crud
Route::post("/getData", [UsuarioController::class, "getData"])->name("getData");

//Ruta para registrarte
Route::post("/admin/register",[UsuarioController::class, "register"])->name("register");

//RUTAS PÁGINA PRINCIPAL MAPAS
//Ruta mapa
Route::get('/mapa_principal', [UsuarioController::class, 'pagina_mapa_principal']);
//Listar los puntos de interés para el mapa
Route::post("/filtro_mapa_principal",[UsuarioController::class, "filtro_mapa_principal"]);
//Recoger los datos de los popups para mostrar en el modal
Route::post('/recoger_datos_etiqueta', [UsuarioController::class, 'recoger_datos_etiqueta']);
//Dar el favorito a el punto de interés
Route::post('/darFavorito', [UsuarioController::class, 'darFavorito']);

#region RUTAS GINCANA
Route::get("/gincana",[UsuarioController::class, "view_gincana"]);
Route::get("/pagina_gincana",[UsuarioController::class, "pagina_gincana"]);

#endregion























//Llamadas Mapas
