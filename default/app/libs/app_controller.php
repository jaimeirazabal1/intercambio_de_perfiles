<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todas las controladores heredan de esta clase en un nivel superior
 * por lo tanto los metodos aqui definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
class AppController extends Controller
{

    final protected function initialize()
    {
    	$controlador = Router::get("controller");
    	$action = Router::get("action");
    	$url = $controlador."/".$action;
    	$this->title = 'Sistema de Intercambio de Perfiles';
    	$rutas_libres = array("index/index");
    	if (!in_array($url, $rutas_libres) and !Auth::is_valid()) {
    		Flash::error("Permiso denegado");
    		Router::redirect("index/index");
    	}
    }

    final protected function finalize()
    {
        
    }

}
