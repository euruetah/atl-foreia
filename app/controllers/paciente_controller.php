<?php
class PacienteController extends AppController
{
	public function index($page = 1) {
        $paciente = new Paciente();
        $this->listPaciente = $paciente->getPacientes($page);
    }

    // Crear evento
	public function create() {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los
         * datos enviado por POST utilizando autocarga de objeto
         */
        if (Input::hasPost('paciente')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $paciente = new Paciente(Input::post('paciente'));
            //En caso que falle la operación de guardar
            if ($paciente->create()) {
                $idpac = $paciente->id;
                Session::set('pacienteid', $idpac);
                Flash::valid('Operación exitosa para el id'.$idpac);
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return Redirect::to('dispmed/create');
                
                
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
        $paciente = new Paciente();
        // verficamos el envío del formulario
        if (Input::hasPost('paciente')) {
            # code...
            if ($paciente->update(Input::post('paciente'))) {
                Flash::valid('Operación exitosa');
                # code...
                return Redirect::to();
            } else {
                Flash::error('Falló operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->paciente = $paciente->find_by_id((int) $id);
        }
    }


}