<?php

Class Dispmed extends ActiveRecord{
	
	public function getDispmed($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }

    
	
}