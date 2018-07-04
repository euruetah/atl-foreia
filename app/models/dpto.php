<?php

Class Dpto extends ActiveRecord{
	
    public function getDpto($page, $ppage = 10000) {
        return $this->paginate("page: $page", "per_page: $ppage");
    }
    public function listadpto (){
        return $this->distinct('id','column: id, nombreips');
    }
    public function listadoDpto (){
        return $this->find_all_by_sql ('select id, nombreips from ips');
    }	
}