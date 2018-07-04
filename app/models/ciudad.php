<?php

Class Ciudad extends ActiveRecord{
	
    protected function initialize() {
        $this->belongs_to('Dpto');        
    }
}