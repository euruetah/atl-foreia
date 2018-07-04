<?php

Class Usuario extends ActiveRecord{
	
    Public function GetIps($user) {
        return $this->find_first('conditions: user="'.$user.'"','columns: ips_id');
    }
    Public function GetCoduser($user) {
        return $this->find_first('conditions: user="'.$user.'"');
    }
    Public function GetNomusuario($user) {
        return $this->find_first('conditions: user="'.$user.'"','columns: nombre');
    }
     
    Public function GetRol($user) {
        return $this->find_first('conditions: user="'.$user.'"','columns: rol');
    }
    	
}