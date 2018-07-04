<?php

Class Paciente extends ActiveRecord{
	
    public function getPacientes($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
	
}