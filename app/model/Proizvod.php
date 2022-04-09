<?php

class Proizvod
{
    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select * from proizvod where sifra=:parametar;
        
        ');
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra,a.naziv,a.cijena,a.kategorija, 
        count(b.sifra) as kupac
        from proizvod a left join kupac b
        on a.sifra=b.proizvod
        group by a.sifra, a.naziv, a.cijena, a.kategorija,
        order by 3;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        insert into proizvod (naziv,cijena,kategorija,sifra)
        values (:naziv,:cijena,:kategorija,:sifra);
        
        ');
        $izraz->execute($parametri);
    }
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        update proizvod set 
            naziv=:naziv,
            cijena=:cijena,
            kategorija=kategorija,
            where sifra=:sifra;
        
        ');
        $izraz->execute($parametri);
    }
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        delete from proizvod where sifra=:sifra;
        
        ');
        $izraz->execute(['sifra'=>$sifra]);
    }
}