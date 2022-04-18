<?php 

class Registracija
{

    public static function readOne($email)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
                select * from kupac where email=:email
        
        ');
        $izraz->execute([
            'email'=>$email
        ]);

        $kupac = $izraz->fetch();
        return $kupac;
    }
   
}