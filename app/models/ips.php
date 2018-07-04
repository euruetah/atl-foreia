<?php

Class Ips extends ActiveRecord{
    
    protected function initialize() {
        $this->has_many('Dpto');
        $this->has_many('Ciudad');
        $this->has_many('Nivel');
        $this->has_many('Naturaleza');
    }
	
    public function getIps($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    public function listaips (){
        return $this->distinct('id','column: id, nombreips');
    }
    public function listadoips (){
        return $this->find_all_by_sql ('select id, nombreips from ips');
    }	
}