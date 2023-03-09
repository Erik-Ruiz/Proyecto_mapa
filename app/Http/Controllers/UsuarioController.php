<?php

namespace App\Http\Controllers;
use App\Models\etiqueta;
use App\Models\prueba;
use App\Models\punto;
use App\Models\punto_etiqueta;
use App\Models\usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller{

    public function pagina_mapa_principal(Request $request){
        $id = Usuario::find(session()->get('id'));
        $personal = etiqueta::all()->where('campo', '<>', 1);
        $etiquetas = etiqueta::all();
        return view('user.mapa_principal',compact('etiquetas'));
    }

    public function filtro_mapa_principal(Request $request){
        $request->except("_token");
        if(empty($request->get("filtro_nombre"))){
            $puntos = punto::all();
           return json_encode($puntos);

        }else{
            $puntos = punto::Where('nombre', 'like','%'.$request->get('filtro_nombre').'%')->get();
            return json_encode($puntos);
        }


        if($request->get("filtro_etiqueta")=="NO"){
            $puntos = punto::all();
            return json_encode($puntos);
        }else{
            $sitios = array();
            $pune = array();
            $filto = $request->get("filtro_etiqueta");
            // $puntos = punto::with(['etiquetas'])->Where('etiqueta','=',$request->get("filtro_etiqueta"))->get();
            $puntos = DB::select('Select punto from punto_etiquetas where etiqueta ='.$filto);
            foreach ($puntos as $punto){
                $sitios[]=$punto->punto;
            }
            $pune = punto::where('id', '=', $sitios)->get();
            return json_encode($pune);
        }

    }

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
    
    //Perfil
    public function perfil(Request $request){
        //Comprobamos si existe la sesion para redirigirlo a la página
        if($request->session()->has("id"))
            return view("admin/perfil");
        else
            return redirect("/");
    }
   //Crud
   
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

    /*------------*/
    /* Registrar */
    /*-----------*/

    public function register(Request $request){
        //recogemos el usuario
        $user= $request->except("_token");
        //comprobamos si exsiste el usuario
        $userDB = usuario::where("username","=", $user["username"])->orwhere("correo","=", $user["correo"])->get()->count();
        if ($userDB==0){           
            $insertaruser= new usuario();
            $insertaruser->username= $user["username"];
            $insertaruser->nombre= $user["nombre"];
            $insertaruser->apellidos= $user["apellidos"];
            $insertaruser->correo= $user["correo"];
            $insertaruser->grupo= $user["grupo"];
            $insertaruser->password= $user["password"];
            $insertaruser->admin=false;
            $insertaruser->save();
            // Iniciar sesión automáticamente después del registro
            $request->session()->put('id', $insertaruser['id']);
            return redirect("user/mapa_main");
        }else{
            return redirect("/");
        }
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
}