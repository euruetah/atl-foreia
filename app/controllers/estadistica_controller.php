<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class EstadisticaController extends AppController {
   
    public function index(){

        $paciente = Load::model('paciente');
        
        $this->strdatos ="";
        $this->strcategoria ="'";

        foreach ($paciente->find_all_by_sql('select etiqueta, count(edad) as cant from paciente, rangos  where (edad >= minimo and edad <= maximo )group by etiqueta') as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strcategoria = $this->strcategoria.",'";
                $this->strdatos = $this->strdatos.",";
            }
            $this->strcategoria = $this->strcategoria.$datos->etiqueta."'";
            $this->strdatos=$this->strdatos.$datos->cant;              
        endforeach;
        $this->listadatos = $paciente->find_all_by_sql('select etiqueta, count(edad) as cant from paciente, rangos  where (edad >= minimo and edad <= maximo )group by etiqueta');

    }
            
    public function pie(){

//        $evento = Load::model('evento');
//        $this->datos = $evento->porRangoedad();
//
//        $this->strdatos ="";
//        $this->strcategoria ="Distribucion de eventos adversos por Sexo";
//
//        foreach ($this->datos as $datos) :
//            if (strlen($this->strdatos)>0){
//                $this->strdatos = $this->strdatos.",";
//            }
//            if ($datos->sexo==0){
//                $strcat="Masculino";
//            }else { 
//                $strcat="Femenino";
//            }
//            $this->strdatos = $this->strdatos."{name: '".$strcat."', y: ".$datos->cant."}";     
//        endforeach;
  
    }
    
    public function propeadv(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porRangoedad($codips);

        $this->strdatos ="";
        $this->strcategoria ="Por Rango de edad";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."{name: '".$datos->etiqueta."', y: ".$datos->cant."}";     
        endforeach;
        
    }
    
     public function desenlace(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porDesenlace($codips);

        $this->strdatos ="";
        $this->strcategoria ="Por tipo de Desenlace del Evento";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."['".$datos->etiqueta."', ".$datos->cant."]";     
        endforeach;
        
    }
    
    public function servicio(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porServicio($codips);

        $this->strdatos ="";
        $this->strcategoria ="Distribucion por servicios ";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."['".$datos->etiqueta."', ".$datos->cant."]";     
        endforeach;
        
    }
    
    public function generico(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porGenerico($codips);

        $this->strdatos ="";
        $this->strcategoria ="Porcentaje de participacion de DM";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."['".$datos->etiqueta."', ".$datos->cant."]";     
        endforeach;
        
    }
    
    public function claseevt(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porClaseevt($codips);

        $this->strdatos ="";
        $this->strcategoria ="Por Clase de Eventos adversos";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."['".$datos->etiqueta."', ".$datos->cant."]";     
        endforeach;
        
    }
    
     public function causa(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porCausa($codips);

        $this->strdatos ="";
        $this->strcategoria ="Distribucion de las distintas causas";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            $this->strdatos = $this->strdatos."['".$datos->etiqueta."', ".$datos->cant."]";     
        endforeach;
        
    }
    public function propsexo(){

        $evento = Load::model('evento');
        $codips = Session::get('ips');
        $this->datos = $evento->porSexo($codips);

        $this->strdatos ="";
        $this->strcategoria ="Distribucion de eventos adversos por Sexo";

        foreach ($this->datos as $datos) :
            if (strlen($this->strdatos)>0){
                $this->strdatos = $this->strdatos.",";
            }
            if ($datos->sexo==0){
                $strcat="Masculino";
            }else { 
                $strcat="Femenino";
            }
            $this->strdatos = $this->strdatos."{name: '".$strcat."', y: ".$datos->cant."}";     
        endforeach;
        $coduser = Session::get('usuario');
        
    }
    
    public function create() {
        
        if (Input::hasPost('periodos')) {
            /**
             * se le pasa al modelo por constructor los datos del form y ActiveRecord recoge esos datos
             * y los asocia al campo correspondiente siempre y cuando se utilice la convención
             * model.campo
             */
            $periodo = new Periodos(Input::post('periodo'));
            //En caso que falle la operación de guardar
            if ($periodo->create()) {
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
            
}

