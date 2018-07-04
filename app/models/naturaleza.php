<?php

Class Naturaleza extends ActiveRecord{
	
    public function getNaturaleza($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    	
}