<?php

namespace App\Http\Controllers;
use App\Models\etiqueta;
use App\Models\prueba;
use App\Models\punto;
use App\Models\usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller{

    /*------*/
    /* Mapa */
    /*------*/

    public function pagina_mapa_principal(Request $request){
        $id = Usuario::find(session()->get('id'));
        $personal = etiqueta::all()->where('campo', '<>', 1);
        $etiquetas = etiqueta::all();
        return view('user.mapa_principal',compact('etiquetas'));
    }

    public function filtro_mapa_principal(Request $request){

    }

    /*--------*/
    /* Login */
    /*--------*/

    //Función para devolver la vista del login
    public function index(){
        return view("index");
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
            return redirect("/");
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
        if($request->session()->has("id"))
            return view("admin/perfil");
        else
            return redirect("/");
    }


    /*------------*/
    /* Registrar */
    /*-----------*/

    public function register(Request $request) {
        //Filtro para que no envie campos vacios
        if (!empty($request['username']) && !empty($request['nombre']) && !empty($request['apellidos']) && !empty($request['correo']) && !empty($request['grupo']) && !empty($request['password']) && !empty($request['passwordrepetida'])) {
            //Suprimir campos en blanco
            $request['username'] = str_replace(' ', '', $request['username']);
            $request['nombre'] = str_replace(' ', '', $request['username']);
            $request['password'] = str_replace(' ', '', $request['password']);
            $request['passwordrepetida'] = str_replace(' ', '', $request['passwordrepetida']);
            //Filtro para que no envie nada vacio
            if (!empty(trim($request['username'])) && !empty(trim($request['nombre'])) && !empty(trim($request['correo'])) && !empty(trim($request['grupo'])) && !empty(trim($request['password'])) && !empty(trim($request['passwordrepetida']))) {
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
                            return redirect("mapa_principal");
                        } else {
                            return redirect("/");
                        }
                    }else{
                        return redirect("/");

                    }
                } else {
                    // Redirigir al usuario a una página de error o mostrar un mensaje de error en la misma página
                    return redirect("/");
                }
            }
        } else {
            return redirect("/");
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
            if($checkAdmin[0]["admin"] == 1)
                return view("admin/crud");
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
                $registerData = usuario::where("username","like","%".$data["buscar"]."%")->count();
            }elseif($data["crudData"] == 2){
                $registerData = punto::count();
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

    public function getData(Request $request){
        if($request->session()->has('id')){
            $id = $request->session()->get("id");
            $user = usuario::where("id","=",$id)->get();
            if($user[0]["admin"]==0){
                return "NOT AUTORIZED";
            }
            $data = $request->except('_token');
            if($data["crudData"] == 1){
                $registerData = usuario::select('usuarios.id','usuarios.username','usuarios.nombre','usuarios.apellidos','usuarios.correo','grupos.nombre as grupo')->join("grupos", 'grupos.id', '=', 'usuarios.grupo')->where("usuarios.username","like","%".$data["buscar"]."%")->get();
            }elseif($data["crudData"] == 2){
                $registerData = punto::get();
            }elseif($data["crudData"] == 3){
                $registerData = prueba::get();
            }else{
                return "";
            }
            return json_encode($registerData);
        }else{
            return "NOT AUTORIZED";
        }
    }
    
    /*---------*/
    /*  */
    /*---------*/



}