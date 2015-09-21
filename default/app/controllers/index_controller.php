<?php

/**
 * Controller por defecto si no se usa el routes
 * 
 */
Load::models("usuario","data");
class IndexController extends AppController
{

    public function index()
    {
        $usuario = new Usuario();
        $this->usuarios = $usuario->find();
    }
    public function registro(){
    	if (Input::hasPost("login","password","repeat_password")) {
    		if (Input::post("password") == Input::post("repeat_password")) {
    			$usuario = new Usuario();
    			$r = $usuario->registrar_nuevo(Input::post("login"),Input::post("password"));
    			if ($r) {
    				Flash::valid("Usuario Registrado");
    			}else{
    				Flash::error("El usuario no se puedo registrar");
    			}
    		}else{
    			Flash::error("Las Claves no coincidieron");
    		}
    	}
    	Router::redirect("/");
    }
    public function login(){
        if (Input::hasPost("login","password")){
            $pwd = Input::post("password");
            $usuario=Input::post("login");
            $u = new Usuario();
            $pwd = $u->encriptar_password($pwd);
            $auth = new Auth("model", "class: usuario", "login: $usuario", "password: $pwd");
            if ($auth->authenticate()) {
                Router::redirect("index/dashboard");
                die;
            } else {
                Flash::error("Login o password incorrectos");
            }
        }
        Router::redirect("/");
    }
    public function logout(){
    	if (Auth::is_valid()) {
    		Auth::destroy_identity();
    		Flash::valid("Sesión finalizada");
    	}
    	Router::redirect("/");
    }
    public function dashboard(){
    	if (Auth::is_valid()) {
	    	$data = new Data();
	    	$this->data = $data->find();
    	}
    }

}
