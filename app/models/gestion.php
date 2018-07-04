<?php

Class Gestion extends ActiveRecord{
    
    protected function initialize() {
        $this->has_many('Causa');
        $this->belongs_to('Evento');
    }
	
    public function getGestion($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    
}