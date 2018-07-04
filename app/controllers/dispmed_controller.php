<?php
class DispmedController extends AppController
{
	public function index($page = 1) {
            $dispmed = new Dispmed();
            $this->listDispmed = $dispmed->getDispmed($page);
        }

    // Crear evento
	public function create() {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los
         * datos enviado por POST utilizando autocarga de objeto
         */
        if (Input::hasPost('dispmed')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $dispmed = new Dispmed(Input::post('dispmed'));
            //En caso que falle la operación de guardar
            if ($dispmed->create()) {
                $dispmedid = $dispmed->id;
                Flash::valid('Operación exitosa');
                Session::set('dispmedid', $dispmedid);
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return Redirect::to('evento/create');
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
        $dispmed = new Dispmed();
        // verficamos el envío del formulario
        if (Input::hasPost('dispmed')) {
            # code...
            if ($dispmed->update(Input::post('dispmed'))) {
                Flash::valid('Operación exitosa');
                # code...
                return Redirect::to();
            } else {
                Flash::error('Falló operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->dispmed = $dispmed->find_by_id((int) $id);
        }
    }


}