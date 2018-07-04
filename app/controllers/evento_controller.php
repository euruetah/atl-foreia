<?php
class EventoController extends AppController
{
//    public function index() {
//        $evento = new Evento();
//        $this->listEvento = $evento->getEvento($page);
//        $this->evento = $evento->find_by_id((int) $id);
//    }
    public $model;
    public function index($page=1){
        $model = new Evento();
        $this->data = Load::model('evento')->paginate("page: $page", 'order: id desc');
    }
    
// Crear evento
    public function create() {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los
         * datos enviado por POST utilizando autocarga de objeto
         */
        
       if (Input::hasPost('evento')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $evento = new Evento(Input::post('evento'));
            $evento->dispmed_id = Session::get('dispmedid');
            $evento->paciente_id  = Session::get('pacienteid'); 
            $evento->ips_id = Session::get('ips'); 
            $evento->usuario_id = Session::get('usuario'); 
            
            //En caso que falle la operación de guardar
            if ($evento->create()) {
                Flash::valid('Operación exitosa');
                
                $evento->update();
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return Redirect::to('gestion/create');
            } else {
                Flash::error('Falló Operación');
            }
        }
    }

     /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function modificar($id) {
//        $evento->update();
//        Flash::show('', $text);
        $evento = new Evento();
        // verficamos el envío del formulario
        if (Input::hasPost('evento')) {
            # code...
            if ($evento->update(Input::post('evento'))) {
                Flash::valid('Operación exitosa');
                # code...
                return Redirect::to('campana/index');
            } else {
                Flash::error('Falló operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $evento->update(input::hasPost('evento'));
            $this->evento = $evento->find_by_id((int) $id);
        }
    }


}