<?php

Class Campana extends ActiveRecord{
	
    public function getCampana($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    	
    public function crearReporte($periodo, $mes){
        $this->delete_all();
        
    }
}