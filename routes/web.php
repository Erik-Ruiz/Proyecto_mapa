<?php

use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

//Ruta para ir al login
Route::get("/",[UsuarioController::class, "index"])->name("index");
//Ruta para logearte
Route::post("/admin/login",[UsuarioController::class, "login"])->name("login");
//Ruta para ir al perfil
Route::get("/admin/perfil",[UsuarioController::class, "perfil"])->name("perfil")->middleware('logout');
//Ruta para ir al crud
Route::get("/admin/crud",[UsuarioController::class, "crud"])->name("crud")->middleware('logout');
//Ruta para recibir la cantidad total de registros del crud
Route::post("/totalData", [UsuarioController::class, "totalData"])->name("totalData")->middleware('logout');
//Ruta para recibir la cantidad total de registros del crud
Route::delete("/deleteCrud", [UsuarioController::class, "deleteCrud"])->name("deleteCrud")->middleware('logout');
Route::post("/insertPICrud", [UsuarioController::class, "insertPICrud"])->name("insertPICrud")->middleware('logout');
Route::post("/insertPruebaCrud", [UsuarioController::class, "insertPruebaCrud"])->name("insertPruebaCrud")->middleware('logout');
Route::post("/getDataById", [UsuarioController::class, "getDataById"])->name("getDataById")->middleware('logout');
Route::put("/modPruebaCrud", [UsuarioController::class, "modPruebaCrud"])->name("modPruebaCrud")->middleware('logout');
Route::put("/modPICrud", [UsuarioController::class, "modPICrud"])->name("modPICrud")->middleware('logout');

//Logout
Route::get("logout", [UsuarioController::class, 'logout'])->name("logout");

//Ruta para recibir los datos de la tabla del crud
Route::post("/getData", [UsuarioController::class, "getData"])->name("getData")->middleware('logout');

//Ruta para registrarte
Route::post("/admin/register",[UsuarioController::class, "register"])->name("register");

//RUTAS PÁGINA PRINCIPAL MAPAS
//Ruta mapa
Route::get("/mapa_principal", [UsuarioController::class, "pagina_mapa_principal"])->name("pagina_mapa_principal")->middleware('logout');
//Listar los puntos de interés para el mapa
Route::post("/filtro_mapa_principal",[UsuarioController::class, "filtro_mapa_principal"])->middleware('logout');
//Recoger los datos de los popups para mostrar en el modal
Route::post('/recoger_datos_etiqueta', [UsuarioController::class, 'recoger_datos_etiqueta'])->middleware('logout');
//Dar el favorito a el punto de interés
Route::post('/darFavorito', [UsuarioController::class, 'darFavorito'])->middleware('logout');
//Dar la opinion a el punto de interés 
Route::post('/darOpinion', [UsuarioController::class, 'darOpinion'])->middleware('logout');

#region RUTAS GINCANA
Route::get("/gincana",[UsuarioController::class, "view_gincana"])->name("gincana-web")->middleware('logout');
Route::get("/pagina_gincana",[UsuarioController::class, "pagina_gincana"])->middleware('logout');
Route::get("/getStatusGincana", [UsuarioController::class, "getStatusGincana"])->name("getStatusGincana")->middleware('logout');

#endregion

// Route::get('storage-link', function(){
// 	Artisan::call('storage:link');
// });





















//Llamadas Mapas
