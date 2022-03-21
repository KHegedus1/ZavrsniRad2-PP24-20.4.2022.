<?php

class App
{
    public static function start()
    {
        $ruta = Request::getRuta();

        $djelovi = explode('/',$ruta);
        $klasa='';
        if(!isset($djelovi[1]) || $djelovi[1]===''){
            $klasa='Index';
        }else{
            $klasa=ucfirst($djelovi[1]);
        }
        $klasa .= 'Controller';

        $metoda='';
        if(!isset($djelovi[2]) || $djelovi[2]===''){
            $metoda='index';
        }else{
            $metoda=$djelovi[2];
        }

        $parametar=null;
        if(!isset($djelovi[3]) || $djelovi[3]===''){
            $parametar=null;
        }else{
            $parametar=$djelovi[3];
        }

        if(class_exists($klasa) && method_exists($klasa,$metoda)){
            $instanca = new $klasa();
            if($parametar==null){
                $instanca->$metoda();
            }else{
                $instanca->$metoda($parametar);
            }
            
        }else{
            $view = new View();
            $view->render('error404',[
                'onoceganema' =>$klasa . '->' . $metoda
            ]);
        }
    }

    public static function config($kljuc)
    {
        $config = include BP_APP . 'konfiguracija.php';
        return $config[$kljuc];
    }
    public static function autoriziran()
    {
        if(isset($_SESSION) && isset($_SESSION['autoriziran'])){
            return true;
        }

        return false;
    }
}