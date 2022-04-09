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
    public static function read($stranica, $uvjet)
    {
        $rps = App::config('rps');
        $od = $stranica * $rps - $rps;

        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra,a.naziv, a.cijena, a.kategorija,
        count(b.sifra) as kosarica
        from proizvod a left join kosarica b
        on a.sifra=b.proizvod
        where concat(a.naziv) like :uvjet
        group by a.sifra,a.naziv, a.cijena,a.kategorija
        order by 3, 4
        limit :od, :rps
        
        ');
        $uvjet = '%' . $uvjet . '%';
        $izraz->bindValue('od',$od,PDO::PARAM_INT);
        $izraz->bindValue('rps',$rps,PDO::PARAM_INT);
        $izraz->bindParam('uvjet',$uvjet);
        $izraz->execute();
        return $izraz->fetchAll();
    }
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        insert into proizvod (naziv,cijena,kategorija)
        values (:naziv,:cijena,:kategorija);
        
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
            kategorija=:kategorija,
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