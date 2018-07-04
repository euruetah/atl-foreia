<?php
class GestionController extends AppController
{
	public function index($page = 1) {
            Load::models('evento','paciente','dispmed','usuario');
            $evento = new Evento();
            $sqlQuery = 'SELECT fecha_at, servicio, cama, identificacion, generico, evento.descripcion, usuario.nombre';
            $sqlQuery = $sqlQuery.' FROM evento'; 
            $sqlQuery = $sqlQuery.' left outer join paciente on paciente.id = evento.paciente_id ';
            $sqlQuery = $sqlQuery.' left outer join dispmed on dispmed.id = evento.dispmed_id '; 
            $sqlQuery = $sqlQuery.' left outer join usuario on usuario.id = evento.usuario_id';
            if ($evento->count_by_sql($sqlQuery)>0) {
                $this->listaCampana = $evento->find_all_by_sql($sqlQuery);
                Load::model('campana');
                $campana = new Campana();
                $campana->delete_all();
                foreach ($this->listaCampana as $i):
                    $campana = new Campana();
                    $campana->fecha = $i->fecha_at;
                    $campana->servicio = $i->servicio;
                    $campana->cama = $i->cama;
                    $campana->identificacion = $i->identificacion;
                    $campana->generico = $i->generico;
                    $campana->descripcion = $i->descripcion;
                    $campana->nombre = $i->nombre;
                    $campana->save();
                endforeach;
            } 
            Redirect::to('campana/index');
        }

    // Crear evento
	public function create() {
        /**
         * Se verifica si el usuario envio el form (submit) y si ademas
         * dentro del array POST existe uno llamado "menus"
         * el cual aplica la autocarga de objeto para guardar los
         * datos enviado por POST  utilizando autocarga de objeto
         */
        if (Input::hasPost('gestion')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $gestion = new Gestion(Input::post('gestion'));
            //En caso que falle la operación de guardar
            if ($gestion->create()) {
                $gestion = $gestion->id;
                Flash::valid('Operación exitosa');
                Session::set('gestion', $gestion);
                //Eliminamos el POST, si no queremos que se vean en el form
                Input::delete();
                return Redirect::to('gestion/index');
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
        $gestion = new Gestion();
        // verficamos el envío del formulario
        if (Input::hasPost('gestion')) {
            # code...
            if ($gestion->update(Input::post('gestion'))) {
                Flash::valid('Operación exitosa');
                # code...
                return Redirect::to();
            } else {
                Flash::error('Falló operación');
            }
        } else {
            //Aplicando la autocarga de objeto, para comenzar la edición
            $this->gestion = $gestion->find_by_id((int) $id);
        }
    }


}