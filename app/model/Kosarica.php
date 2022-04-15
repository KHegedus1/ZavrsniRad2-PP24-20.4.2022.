<?php

class Kosarica{

	public static function read()
    {
        $cennection = DB::getInstance();
        $izraz = $veza->prepare('
        
            select * from proizvod
        
        '); 
        $izraz->execute();
        return $izraz->fetchAll();
    }
}