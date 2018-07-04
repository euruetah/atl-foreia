<?php

/**
 * 
 */
class LoginController extends Controller {

    public function index() {
        // especificamos el template a usar
        View::template("login");
        // Solo si se ha enviado el formulario
        if (Input::hasPost('login')) {
            // recuperamos los datos del formulario para validar acceso
            $login = Input::post('login');
            $user = $login["user"];
            // en la base de datos la tengo con md5, desde php hago la conversion
//            $pwd = md5($login["password"]);
            $pwd = $login["password"];
            // iniciamos el Auth, mi modelo se llama Users, asi como la tabla
            $auth = new Auth("model", "class: Usuario", "user: " . $user, "password: " . $pwd);
            if ($auth->authenticate()) {
                // Si el usuario es valido, lo mandamos al index
                // de la aplicacion ya logueado
                
//                Load::model('usuario');
                $usuario = Load::model('usuario');
                
                $idusuario = $usuario->getCoduser($user)->id;
                $usuariocod = $usuario->find($idusario);
                $idips = $usuario->ips_id;
                $rol = $usuario->rol;
                session::set('usuario', $idusuario);
                session::set('ips', $idips);
                session::set('user', $user);
                session::set('rol', $rol);
                Redirect::to("index");
            } else {
                Flash::info("Error el usuario y/o password no son validos");
            }
            
        }
    }

    public function destroy() {
        Auth::destroy_identity();
        Flash::info("Hasta pronto!");
        Redirect::to("index");
    }

}

?>