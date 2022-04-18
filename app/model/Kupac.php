<?php 

class Kupac
{
    public static function readOne($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
                select *
                from kupac
                where sifra=:sifra
        
        ');
        $query->execute(['sifra' => $sifra]);
        return  $query->fetch();
    }

    public static function read()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
                select *
                from kupac
        
        ');
        $query->execute();
        return  $query->fetch();
    }

    public static function insert($paramaters)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
                insert into kupac (ime, prezime, ulica, kucniBroj, grad, email)
                values (:ime, :prezime, :ulica, :kucniBroj, now())
        
        ');
        $query->execute([
            'ime'=>$paramaters['ime'],
            'prezime'=>$paramaters['prezime'],
            'ulica'=>$paramaters['ulica'],
            'kucniBroj'=>$paramaters['kucniBroj'],
            'grad'=>$paramaters['grad'],
            'email'=>$paramaters['email'],
        ]);
    } 
    
    public static function update($paramaters)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
                
        update kupac set 
        ime=:ime,
        prezime=:prezime,
        ulica=:ulica,
        kucniBroj=:kucniBroj,
        grad=:grad,
        email=:email
        where sifra=:sifra
        ');
        
        $query->execute([
            'ime'=>$paramaters['ime'],
            'prezime'=>$paramaters['prezime'],
            'ulica'=>$paramaters['ulica'],
            'kucniBroj'=>$paramaters['kucniBroj'],
            'grad'=>$paramaters['grad'],
            'email'=>$paramaters['email'],
            'sifra'=>$paramaters['sifra'],
        ]);
    }  
}
