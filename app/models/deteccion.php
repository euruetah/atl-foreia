<?php

Class Deteccion extends ActiveRecord{
	
    public function getDeteccion($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    	
}