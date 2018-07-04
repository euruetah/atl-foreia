<?php

Class Nivel extends ActiveRecord{
	
    public function getNivel($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }

}