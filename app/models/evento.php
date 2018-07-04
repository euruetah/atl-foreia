<?php

Class Evento extends ActiveRecord{
	
    protected function initialize() {
        $this->has_many('Paciente');
        $this->has_many('Usuario');
        $this->has_many('Dispmed');
        $this->has_many('Clasificacion');
        $this->has_many('Ips');
        $this->has_many('deteccion');
        $this->has_many('Desenlace');        
    }
    
    public function getEvento($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
	
    public function getDatosPaciente(){
        return $this->find('columns: identificacion, sexo, edad, edaden, diagnostico','join: left join paciente on paciente.id = evento.paciente_id');
    }
    
    public function getDatosDispositivo(){
        return $this->find('columns: generico, comercial, regsanitario, lote, modelo, referencia, serial, fabricante, distribuidor, usado','join: left join dispmed on dispmed.id = evento.dispmed_id');
    }
    
    public function getDatosUsuario(){
        return $this->find('columns: identificacion, sexo, edad, edaden, diagnostico','join: left join paciente on paciente.id = evento.paciente_id');
    }
    
    public function creaCampana(){
//        Load::models('evento','paciente','dispmed','usuario');
        return $this->find('columns: fecha_at, servicio, cama, paciente_id, dispmed_id, descripcion, usuario_id');
        
    }
    
    public function porRangoedad() {
        //calcula el total de caso por rango de Edad
        if (Session::get('rol')=='A') {
            return $this->find_all_by_sql('select etiqueta, count(edad) as cant from paciente, rangos  where (edad >= minimo and edad <= maximo )group by etiqueta');
        } else {
            $codips = Session::get('ips');
            return $this->find_all_by_sql('select etiqueta, count(edad) as cant from paciente, rangos  where (edad >= minimo and edad <= maximo )group by etiqueta');
        }        
    }
    
    public function porSexo($codips) {
        //Calcula el total de casos por Sexo
        if (is_null($codips)) {
            return $this->find_all_by_sql('select sexo, count(paciente_id) as cant from evento left outer join paciente on evento.paciente_id = paciente.id group by sexo');
        } else {
            return $this->find_all_by_sql('select sexo, count(paciente_id) as cant from evento left outer join paciente on evento.paciente_id = paciente.id where ips_id ='.$codips.' group by sexo');
        }
        
    }
    
    public function porClaseevt($codips) {
        //Calcula el total de casos por Clasificacion del Evento
        if (is_null($codips)) {
            return $this->find_all_by_sql('select clasificacion.descripcion as etiqueta, count(evento.id) as cant from evento left outer join clasificacion on evento.clasificacion_id = clasificacion.id group by clasificacion.descripcion');
        } else {
            return $this->find_all_by_sql('select clasificacion.descripcion as etiqueta, count(evento.id) as cant from evento left outer join clasificacion on evento.clasificacion_id = clasificacion.id where ips_id = '.$codips.' group by clasificacion.descripcion');
        }
    }
    
    public function porGenerico($codips) {
        //Calcula el total de casos por Generico del Dispositivo Medico
        if (is_null($codips)) {
            return $this->find_all_by_sql('select generico as etiqueta, count(evento.id) as cant from evento left outer join dispmed on evento.dispmed_id = dispmed.id group by generico');
        } else {
            return $this->find_all_by_sql('select generico as etiqueta, count(evento.id) as cant from evento left outer join dispmed on evento.dispmed_id = dispmed.id where ips_id = '.$codips.' group by generico');
        }
    }
    
    public function porCausa($codips) {
        //Calcula el total de casos por Generico del Dispositivo Medico
        if (is_null($codips)) {
            return $this->find_all_by_sql('select termcausa as etiqueta, count(evento_id) as cant from gestion inner join evento on gestion.evento_id = evento.id left join causa on causa.id = gestion.causa_id group by termcausa');
        } else {
            return $this->find_all_by_sql('select termcausa as etiqueta, count(evento_id) as cant from gestion inner join evento on gestion.evento_id = evento.id left join causa on causa.id = gestion.causa_id where ips_id = '.$codips.' group by termcausa');
        }
    }
    
    public function porServicio($codips) {
        //Calcula el total de casos por Servicio de ocurrencia
        if (is_null($codips)) {
            return $this->find_all_by_sql('select servicio as etiqueta, count(id) as cant from evento where  month(fecha_at)=12 and year(fecha_at)=2017 group by servicio');
        } else {
            return $this->find_all_by_sql('select servicio as etiqueta, count(id) as cant from evento where ips_id='.$codips.' and month(fecha_at)=12 and year(fecha_at)=2017 group by servicio');
        }
    }
    
    public function porDesenlace($codips) {
        //Calcula el total de casos por Servicio de ocurrencia
        $mes = 11;
        $periodo = 2017;
        $strquery='select desenlace.descripcion as etiqueta, count(evento.id) as cant from evento left outer join desenlace on desenlace.id = evento.desenlace_id ';
        if (is_null($codips)) {
            $filtro = 'where year(fecha_at)=2017 ';
        } else {
            $filtro = 'where ips_id='.$codips.' and month(fecha_at)=12 and year(fecha_at)=2017';
        }
        return $this->find_all_by_sql($strquery.' group by desenlace.descripcion');
    }
}