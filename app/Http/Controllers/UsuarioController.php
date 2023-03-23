<?php

namespace App\Http\Controllers;
use App\Models\etiqueta;
use App\Models\favorito;
use App\Models\prueba;
use App\Models\punto;
use App\Models\punto_etiqueta;
use App\Models\registro;
use App\Models\usuario;
use App\Models\lugare;
use App\Models\usuario_prueba;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller{

    /*------*/
    /* Mapa */
    /*------*/

    public function pagina_mapa_principal(Request $request){
        $id = Usuario::find(session()->get('id'));
        $personales = etiqueta::all()->where('usuario', '=', $request->session()->get('id'));
        $etiquetas = etiqueta::all()->where('usuario', '=', null);
        return view('user.mapa_principal',compact('etiquetas','personales'));
    }

    public function filtro_mapa_principal(Request $request){
        $vacio = empty($request->get('filtro_nombre'));
        $no = $request->get('filtro_etiqueta') == 'NO';
        $noP = $request->get('filtro_opinion') == 'NO';
        $fav = $request->get('filtro_favorito');


        if($vacio && $no && $fav==0 && $noP){
            $query = punto::all();
            return json_encode($query);
        }elseif(!$vacio && $no && $noP && $fav==0){
            $query = punto::where('nombre','LIKE','%'.$request->get('filtro_nombre').'%')->get();
            return json_encode($query);
        }elseif(!$vacio && !$no && $noP && $fav==0){
            $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud')
            ->join('punto_etiquetas','punto_etiquetas.punto','=','puntos.id')
            ->where('puntos.nombre','LIKE','%'.$request->get('filtro_nombre').'%')
            ->where('punto_etiquetas.etiqueta','=',$request->get('filtro_etiqueta'))->get();
            return json_encode($query);
        }elseif($fav == 1 && $vacio && $no && $noP){
            $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud', 'favoritos.punto')
            ->join('favoritos','puntos.id','=','favoritos.punto')
            ->where('favoritos.usuario','=', $request->session()->get('id'))->get();
            return json_encode($query);
        }elseif($fav == 1 && $vacio && !$no && $noP){
            $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud', 'favoritos.punto')
            ->join('favoritos','puntos.id','=','favoritos.punto')
            ->join('punto_etiquetas','punto_etiquetas.punto','=','puntos.id')
            ->where('punto_etiquetas.etiqueta','=',$request->get('filtro_etiqueta'))
            ->where('favoritos.usuario','=', $request->session()->get('id'))->get();
            return json_encode($query);
        }elseif(!$noP){
            $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud','etiquetas.color')
            ->join('punto_etiquetas','punto_etiquetas.punto','=','puntos.id')
            ->join('etiquetas','punto_etiquetas.etiqueta','=','etiquetas.id')
            ->where('etiquetas.id','=',$request->get('filtro_opinion'))
            ->where('punto_etiquetas.usuario','=', $request->session()->get('id'))->get(    );
            return json_encode($query);
        }
        else{
            $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud','etiquetas.color')
            ->join('punto_etiquetas','punto_etiquetas.punto','=','puntos.id')
            ->join('etiquetas','punto_etiquetas.etiqueta','=','etiquetas.id')
            ->where('punto_etiquetas.etiqueta','=',$request->get('filtro_etiqueta'))->get();
            return json_encode($query);
        }

    }

    //Hacemos una consulta para recoger los datos del punto al que han clickado
    public function recoger_datos_etiqueta(Request $request){
        $request->except("_token");

        //Saber si tiene favorito
        $punto = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud', 'favoritos.punto')
                    ->join('favoritos','puntos.id','=','favoritos.punto')
                    ->where('favoritos.punto','=', $request->get('id'))->count();
        
        //Saber si tiene una etiqueta personalizada
        // $opinado = punto_etiqueta::select('punto_etiquetas.etiqueta')
        // ->where("usuario", "=", $request->session()->get('id'))->where("punto","=",$request->get("id"))->where("personal","=",1)->get();
        // dd($opinado[0]['etiqueta']);

        if($punto==1){
            $datos = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud', 'favoritos.punto')
            ->join('favoritos','puntos.id','=','favoritos.punto')
            ->where('favoritos.usuario','=', $request->session()->get('id'))->get();
            return json_encode($datos[0]);

        // }else if(count($opinado) != 0){
        
        //     $datos = etiqueta::select('nombre')->where('id','=',$opinado[0]['etiqueta'])->get();
        //     dd($datos[0]['nombre']);

        
        }else{
            $datos = punto::where('id', $request->get("id"))->first();
            return json_encode($datos);
        }
    }

    public function logout(Request $request){
        $request->session()->forget("id");
        return redirect("/");
    }

    public function darFavorito(Request $req){

        $id_user = $req->session()->get('id');
        $id_punto=$req["id_punt"];

        // return response()->json(['ID del punto' => $id_punto, 'ID del user' => $id_user]);

        if($req->session()->has('id')){

            try{
                $liked = favorito::where("usuario", "=", $id_user)->where("punto","=",$id_punto)->count();
                if ($liked == 1){
                    favorito::where("usuario", "=", $id_user)->where("punto","=",$id_punto)->delete();
                    return "delete";
                }else{

                    $Visita = new favorito();
                    $Visita->usuario = $id_user;
                    $Visita->punto = $id_punto;
                    $Visita->save();
                    return "saved";

                }


            }catch(\Exception $e){
                return $e;
            }
        }{
            return route('login');
        }
    }

    public function darOpinion(Request $req){

        $id_user = $req->session()->get('id');
        $id_punto=$req["id_punt"];
        $opinion = $req->get('opinion');

        // return response()->json(['ID del punto' => $id_punto, 'ID del user' => $id_user, 'Opinion' => $opinion]);
        
        if($req->session()->has('id')){

                // $opinado = punto_etiqueta::where("usuario", "=", $id_user)->where("punto","=",$id_punto)->where("personal","=",1)->count();
                $opinado = punto_etiqueta::select('punto_etiquetas.etiqueta')
                ->where("usuario", "=", $id_user)->where("punto","=",$id_punto)->where("personal","=",1)->get();
                
                if (count($opinado) != 0){

    
                    etiqueta::where("id", "=", $opinado[0]['etiqueta'])->update(["nombre" => $opinion]);


                    return $opinado[0]['etiqueta'];
                    
                }else{
                    
                    try{
                        DB::beginTransaction();

                        $etiqueta = new etiqueta();
                        $etiqueta->nombre = $opinion;
                        $etiqueta->color = 'Orange';
                        $etiqueta->personal = 1;
                        $etiqueta->usuario = $id_user;
                        $etiqueta->save();

                        $id_etiqueta = DB::getPdo()->lastInsertId();


                        $punto_etiqueta = new punto_etiqueta();
                        $punto_etiqueta->etiqueta = $id_etiqueta;
                        $punto_etiqueta->punto = $id_punto;
                        $punto_etiqueta->personal = 1;
                        $punto_etiqueta->usuario = $id_user;
                        $punto_etiqueta->save();

                        DB::commit();
                        return "OK";
                    }catch(Exception $e){
                        DB::rollBack();
                        return $e->getMessage();
                    }




                    
                    return "saved";

                }



        }else{
            return route('login');
        }
    }
    //Función para devolver la vista del login
    public function index(){
        return view("index");
    }
    public function index2(){
        return view("/register");
    }

    //Función para logearte
    public function login(Request $request){
        //Recogemos el usuario del formulario
        $user = $request->except("_token");
        //Recogemos el usuario de la base de datos( si existe )
        $userDB = usuario::where("username","=",$user["username"])->where("password","=",sha1($user["password"]))->get();
        //Comprobamos si existe un usuario con esos datos
        if(count($userDB) == 0){
            //Si no existe lo redirigimos al login
            return redirect()->route("index", ['mensaje' => 'usunoexsiste']);

        }else{
            //Si existe comprobamos si es admin
            $admin = $userDB[0]["admin"];
            $request->session()->put("id",$userDB[0]["id"]);
            if($admin == 1){
                //Si lo es lo redirigimos al crud
                return redirect("admin/crud");
            }else{
                //Si no lo es redirigimos a la pagina principal
                return redirect("admin/perfil");
            }
        }
    }




    /*--------*/
    /* Perfil */
    /*--------*/

    public function perfil(Request $request){
        //Comprobamos si existe la sesion para redirigirlo a la página
        if($request->session()->has("id")){
            $id = session()->get("id");
            $usuario = usuario::where('id','=',$id)->get();
/*             $favoritos2 = favorito::select('favoritos.punto')
            ->join('puntos','puntos.id','=','favoritos.punto')
            ->where('usuario','=',$id); */
            $favoritos = punto::select('puntos.nombre')
            ->join('favoritos','favoritos.punto','=','puntos.id')
            ->where('favoritos.usuario','=',$id);
            return json_encode($favoritos);

            return view("admin/perfil",compact('usuario','favoritos'));
        }
        else{
            return redirect("/");
        }   
    }

    // $query = punto::select('puntos.id','puntos.nombre','puntos.descripcion','puntos.latitud','puntos.longitud')
    // ->join('punto_etiquetas','punto_etiquetas.punto','=','puntos.id')
    // ->where('puntos.nombre','LIKE','%'.$request->get('filtro_nombre').'%')
    // ->where('punto_etiquetas.etiqueta','=',$request->get('filtro_etiqueta'))->get();
    // return json_encode($query);



    /*------------*/
    /* Registrar */
    /*-----------*/

    public function register(Request $request) {
        //Filtro para que no envie campos vacios
        if (!empty(
            $request['username']) && !empty($request['nombre']) && !empty($request['apellidos']) && !empty($request['correo']) && !empty($request['password']) && !empty($request['passwordrepetida'])) {
            //Suprimir campos en blanco
            $request['username'] = str_replace(' ', '', $request['username']);
            $request['nombre'] = str_replace(' ', '', $request['username']);
            $request['password'] = str_replace(' ', '', $request['password']);
            $request['passwordrepetida'] = str_replace(' ', '', $request['passwordrepetida']);
            //Filtro para que no envie nada vacio                
            if (!empty(trim($request['username'])) && !empty(trim($request['nombre'])) && !empty(trim($request['correo'])) && !empty(trim($request['password'])) && !empty(trim($request['passwordrepetida']))) {
                // Validar la dirección de correo electrónico
                if (filter_var(trim($request['correo']), FILTER_VALIDATE_EMAIL)) {
                    if($request['password'] == $request['passwordrepetida']){
                        // Comprobar si el usuario ya existe en la base de datos
                        $userDB = usuario::where("username", "=", $request["username"])->orWhere("correo", "=", $request["correo"])->count();
                        // Insertar el usuario en la base de datos si no existe
                        if ($userDB == 0) {
                            $insertaruser = new usuario();
                            $insertaruser->username = $request["username"];
                            $insertaruser->nombre = $request["nombre"];
                            $insertaruser->apellidos = $request["apellidos"];
                            $insertaruser->correo = $request["correo"];
                            $insertaruser->grupo = $request["grupo"];
                            $insertaruser->password = sha1($request["password"]);
                            $insertaruser->admin = false;
                            $insertaruser->save();

                            $request->session()->put('id', $insertaruser['id']);
                            return redirect()->route("pagina_mapa_principal", ['mensaje' => 'usuariointroducido']);
                        } else {
                            return redirect()->route("index", ['mensaje' => 'repenombre']);
                        }
                    }else{
                        return redirect()->route("index", ['mensaje' => 'contranoval']);
                    }
                } else {
                    // Redirigir al usuario a una página de error o mostrar un mensaje de error en la misma página
                    return redirect()->route("index", ['mensaje' => 'correoinval']);
                }
            }
        } else {
            return redirect()->route("index", ['mensaje' => 'rellenacampos']);
        }
    }



    /*---------------------*/
    /* Funcionamiento Crud */
    /*---------------------*/

    //Funcion para devolver el crud
    public function crud(Request $request){
        //Comprobamos si existe la sesion para redirigirlo a la página
        if($request->session()->has("id")){
            //Recogemos la id de la sesion
            $id = $request->session()->get("id");
            //Recogemos el usuario de la bd
            $checkAdmin = usuario::where("id","=",$id)->get();
            //Comprobamos si es admin, si lo es, lo redirigimos al crud, sino a la página donde estaba
            if($checkAdmin[0]["admin"] == 1){
                $user = $checkAdmin[0]['correo'];
                return view("admin/crud",['user' => $user]);
            }
            else
                return redirect()->back();
        }
        else
            return redirect("/");
    }

    public function totalData(Request $request){
        if($request->session()->has('id')){
            $id = $request->session()->get("id");
            $user = usuario::where("id","=",$id)->get();
            if($user[0]["admin"]==0){
                return "NOT AUTORIZED";
            }
            $data = $request->except('_token');
            if($data["crudData"] == 1){
                $registerData = usuario::where("username","like","%".$data["buscar"]."%")->where("id","!=",$id)->count();
            }elseif($data["crudData"] == 2){
                $registerData = punto::where("personal","=",0)->count();
            }elseif($data["crudData"] == 3){
                $registerData = prueba::count();
            }else{
                return -1;
            }
            return $registerData;
        }else{
            return "NOT AUTORIZED";
        }
    }

    public function modPICrud(Request $request){
        if(empty($request["nombre"]) || empty($request["latitud"]) || empty($request["longitud"]) || empty($request["id"])){
            return "errorNotSet";
        }else{
            if($request["latitud"] > 90 || $request["latitud"] < -90 || $request["longitud"] > 180 || $request["longitud"] < -180){
                return "errorCoordenas";
            }
            try{
                DB::beginTransaction();
                punto::where("id","=",$request['id'])->update(["nombre" => $request["nombre"], "descripcion" => $request["descripcion"], "latitud" => $request["latitud"], "longitud" => $request["longitud"], "personal" => 0]);
                if(count($request->file()) == 1)
                    $request->file('imagen')->storeAs('/public/img', $request["id"].'.jpg');
                DB::commit();
                return "OK";
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        }
    }

    public function modPruebaCrud(Request $request){
        if(empty($request["nombre"]) || empty($request["pregunta"]) || empty($request["pista"]) || empty($request["respuesta"]) || empty($request["latitud"]) || empty($request["longitud"])){
            return "errorNotSet";
        }else{
            if($request["latitud"] > 90 || $request["latitud"] < -90 || $request["longitud"] > 180 || $request["longitud"] < -180){
                return "errorCoordenas";
            }
            try{
                prueba::where("id","=",$request['id'])->update(["nombre" => $request["nombre"], "texto_pregunta" => $request["pregunta"], "respuesta" => $request["respuesta"], "latitud" => $request["latitud"], "longitud" => $request["longitud"], "texto_pista" => $request["pista"]]);
                return "OK";
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }

    public function getData(Request $request){
        if($request->session()->has('id')){
            $numRegistros = 5;
            $id = $request->session()->get("id");
            $pagActual = $request["pagAct"];
            $user = usuario::where("id","=",$id)->get();
            if($user[0]["admin"]==0){
                return "NOT AUTORIZED";
            }
            $data = $request->except('_token');
            if($data["crudData"] == 1){
                $registerData = usuario::select('usuarios.id','usuarios.username','usuarios.nombre',DB::raw('(CASE WHEN usuarios.apellidos IS NOT NULL THEN usuarios.apellidos  ELSE "" END) as apellidos'),'usuarios.correo','grupos.nombre as grupo')->join("grupos", 'grupos.id', '=', 'usuarios.grupo')->where("usuarios.username","like","%".$data["buscar"]."%")->where("usuarios.id","!=",$id)->skip($pagActual*$numRegistros)->take($numRegistros)->get();
            }elseif($data["crudData"] == 2){
                $registerData = punto::select('puntos.id',DB::raw('(CASE WHEN puntos.usuario > 0 THEN usuarios.username  ELSE "AYUJE" END) as username'),'puntos.nombre',DB::raw('(CASE WHEN puntos.descripcion IS NOT NULL THEN puntos.descripcion  ELSE "" END) as descripcion'),'puntos.latitud','puntos.longitud')->leftjoin("usuarios", 'usuarios.id', '=', 'puntos.usuario')->where("puntos.nombre","like","%".$data["buscar"]."%")->where("puntos.personal","=",0)->skip($pagActual*$numRegistros)->take($numRegistros)->get();
            }elseif($data["crudData"] == 3){
                $registerData = prueba::where("nombre","like","%".$data["buscar"]."%")->skip($pagActual*$numRegistros)->take($numRegistros)->get();
            }else{
                return "";
            }
            return json_encode($registerData);
        }else{
            return "NOT AUTORIZED";
        }
    }

    public function deleteCrud(Request $request){
        $id = $request->input('id');
        $crudValue = $request->input('crudData');
        try{
            DB::beginTransaction();
            if($crudValue == 1){
                registro::where("usuario","=",$id)->delete();
                usuario_prueba::where("usuario","=",$id)->delete();
                favorito::where("usuario","=",$id)->delete();
                punto_etiqueta::where("usuario","=",$id)->delete();
                etiqueta::where("usuario","=",$id)->delete();
                usuario::where("id","=",$id)->delete();
            }elseif($crudValue == 2){
                punto_etiqueta::where("punto","=",$id)->delete();
                punto::where("id","=",$id)->delete();
                unlink("../storage/app/public/img/".$id.".jpg");
            }else{
                usuario_prueba::where("prueba","=",$id)->delete();
                prueba::where("id","=",$id)->delete();
            }
            DB::commit();
            return 'OK';
        }catch(Exception $e){
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function getDataById(Request $request){
        $id = $request->input('id');
        $crudValue = $request->input('crudData');
        if($crudValue == 2){
            return punto::where("id","=",$id)->get();
        }else{
            return prueba::where("id","=",$id)->get();
        }
    }

    public function insertPICrud(Request $request){
        if(empty($request["nombre"]) || empty($request["latitud"]) || empty($request["longitud"]) || count($request->file()) == 0){
            return "errorNotSet";
        }else{
            if($request["latitud"] > 90 || $request["latitud"] < -90 || $request["longitud"] > 180 || $request["longitud"] < -180){
                return "errorCoordenas";
            }
            try{
                DB::beginTransaction();
                $punto = new punto();
                $punto->nombre = $request["nombre"];
                $punto->descripcion = $request["descripcion"];
                $punto->latitud = $request["latitud"];
                $punto->longitud = $request["longitud"];
                $punto->personal = 0;
                $punto->save();
                $request->file('imagen')->storeAs('/public/img', $punto->id.'.jpg');
                DB::commit();
                return "OK";
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        }
    }

    public function insertPruebaCrud(Request $request){
        if(empty($request["nombre"]) || empty($request["pregunta"]) || empty($request["pista"]) || empty($request["respuesta"]) || empty($request["latitud"]) || empty($request["longitud"])){
            return "errorNotSet";
        }else{
            if($request["latitud"] > 90 || $request["latitud"] < -90 || $request["longitud"] > 180 || $request["longitud"] < -180){
                return "errorCoordenas";
            }
            try{
                $prueba = new prueba();
                $prueba->nombre = $request["nombre"];
                $prueba->texto_pregunta = $request["pregunta"];
                $prueba->texto_pista = $request["pista"];
                $prueba->respuesta = $request["respuesta"];
                $prueba->latitud = $request["latitud"];
                $prueba->longitud = $request["longitud"];
                $prueba->save();
                return "OK";
            }catch(Exception $e){
                return $e->getMessage();
            }
        }
    }


    /*---------*/
    /* Gimcana */
    /*---------*/

    public function view_gincana (Request $request) {
        if($request->session()->has("id")) {
            return view("user.gincana");
        } else {
            return redirect("/");
        }
    }

    public function pagina_gincana (Request $request) {
        if($request->session()->has("id")) {
            $puntosInteres = punto::get();
            return json_encode($puntosInteres);
        } else {
            return redirect("/");
        }
    }

    public function getStatusGincana(Request $request) {
        if($request->session()->has("id")) {
            $id = session()->get('id');
            $cantidad = usuario_prueba::where('usuario','=', $id)->count('usuario');
            $total = prueba::count();
            $prueba = [];
            if($cantidad != 0){
                $pruebaBD = prueba::select("id","latitud","longitud","nombre","texto_pista","texto_pregunta")->where("id", "=", $cantidad)->get();
                $prueba = $pruebaBD[0];
            }
            $array = [$cantidad, $prueba, $total];
            return json_encode($array);
        } else {
            return redirect("/");
        }
    }

    public function getPruebaGimcana(Request $request){
        if($request->session()->has("id")) {
            try{
                $prueba = prueba::where("id","=",$request["prueba"]);
                return json_encode($prueba);
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        }else{
            return redirect("/");
        }
    }
    public function getTotalOfUserInGroup(Request $request){
        if($request->session()->has("id")) {
            try{
                $id = session()->get('id');
                $user = usuario::where("id","=",$id)->get();
                $grupo = usuario::where("grupo","=",$user[0]["grupo"])->count();
                return $grupo;
            }catch(Exception $e){
                return -1;
            }
        } else {
            return redirect("/");
        }
    }
    
    public function eliminarRegistro(Request $request) {
        if($request->session()->has("id")) {
            try{
                DB::beginTransaction();
                $id = session()->get('id');
                $registerOld = registro::whereNull("fecha_fin")->where("usuario","=",$id)->get();
                $registerOldId = $registerOld[0]['id'];
                usuario_prueba::where("usuario","=",$id)->delete();
                registro::where("id","=",$registerOldId)->delete();
                usuario::where("id","=",$id)->update(["grupo" => null]);
                DB::commit();
                return 'OK';
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        }else{
            return redirect("/");
        }
    }

    public function insertarRegistro(Request $request) {

        if($request->session()->has("id")) {
            try{
                $id = session()->get('id');
                $user = usuario::where("id","=",$id)->get();
                if($user[0]["grupo"] ==null){
                    return "notGrupo";
                }
                DB::beginTransaction();
                $registro = new usuario_prueba;
                $registro -> usuario = $id;
                $registro -> prueba = 1;
                $registro->save();
                $fechaRegistro = new registro;
                $fechaRegistro -> fecha_inicio =  date('Y-m-d H:i');
                $fechaRegistro -> usuario = $id;
                $fechaRegistro->save();
                DB::commit();
                return "OK";
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        } else {
            return redirect("/");
        }
    }

    public function pasoDePrueba(Request $request) {
        if($request->session()->has("id")) {
            try{
                if($this -> checkRespuesta($request))
                    return "FALLO";
                $id = session()->get('id');
                $registro = new usuario_prueba;
                $registro -> usuario = $id;
                $registro -> prueba = (int)$request["prueba"]+1;
                $registro->save();
                return "OK";
            }catch(Exception $e){
                return $e->getMessage();
            }
        } else {
            return redirect("/");
        }
    }

    public function insertarRegistroFinal(Request $request) {
        if($request->session()->has("id")) {
            try{
                DB::beginTransaction();
                $id = session()->get('id');
                $registro = new usuario_prueba;
                $registro -> usuario = $id;
                $registro -> prueba = 1;
                $registro->save();
                registro::where("usuario","=",$id)->whereNull("fecha_fin")->update(["fecha_fin" => date('Y-m-d H:i')]);
                DB::commit();
                return "OK";
            }catch(Exception $e){
                DB::rollBack();
                return $e->getMessage();
            }
        } else {
            return redirect("/");
        }
    }

    public function checkRespuesta(Request $request){
        if($request->session()->has("id")) {
            try{
                $pruebas = prueba::where("prueba","=",$request["prueba"])->where("respuesta","=",$request["respuesta"])->count();
                if($pruebas == 0){
                    return false;
                }else{
                    return true;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                return false;
            }
        } else {
            return redirect("/");
        }
    } 
    public function checkPassToRound(Request $request){
        if($request->session()->has("id")) {
            try{
                $id = session()->get('id');
                $prueba = $request["prueba"];
                $user = usuario::where("id","=",$id)->get();
                $grupo = usuario_prueba::where("usuarios.grupo","=",$user[0]["grupo"])->where("usuario_pruebas.prueba","=",$prueba)->join("usuarios","usuarios.id","=","usuario_pruebas.usuario")->count();
                $totalUsers =  $this->getTotalOfUserInGroup($request);
                if($grupo != $totalUsers){
                    return false;
                }else{
                    return true;
                }
            }catch(Exception $e){
                echo $e->getMessage();
                return false;
            }
        } else {
            return redirect("/");
        }
    }
}