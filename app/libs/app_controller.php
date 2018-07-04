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
    	//esto se ejecuta para todos los controladores que extienden de AppController
    	if (!Auth::is_valid()) {
            // El usuario no es valido, lo mandamos al login
            Redirect::to("login"); 
        }  
    }

    final protected function finalize()
    {
        
    }

}
