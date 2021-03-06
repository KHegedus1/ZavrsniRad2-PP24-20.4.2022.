<?php

class Kosarica
{
    public static function ukupnoKupaca()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
                select count(*)
                from kupac
        
        ');
        $query->execute();
        return  $query->fetchColumn();
    }

    public static function readNarudzbaDetalji($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select c.ime,c.sifra as proizvodSifra, c.cijena as proizvodCijena, a.cijena, a.kolicina
        from kosarica a
        inner join narudzba b on a.narudzba=b.sifra
        inner join proizvod c on a.proizvod=c.sifra
        where b.sifra = :sifra
        ');

        $query->execute([
            'sifra'=>$sifra
        ]);
        return $query->fetchAll();
    }
    
    public static function ukupnoGotovihNarudzbi()
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select count(sifra)
        from narudzba
        where isporuceno = true
        ');

        $query->execute();
        return $query->fetchColumn();
    }
    public static function ukupnoGotovihNarudzbiS($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select c.ime,c.sifra as proizvodSifra, c.cijena as proizvodCijena, a.cijena, a.kolicina
        from kosarica a
        inner join narudzba b on a.narudzba=b.sifra
        inner join proizvod c on a.proizvod=c.sifra
        where b.sifra = :sifra
        ');

        $query->execute([
            'sifra'=>$sifra
        ]);
        return $query->fetchAll();
    }
    public static function readOne($sifra)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
            select * from kosarica where sifra=:parametar;
        
        '); 
        $izraz->execute(['parametar'=>$sifra]);
        $narudzba= $izraz->fetch();
        $izraz = $veza->prepare('
        
            select b.sifra, b.kategorija, b.naziv, b.cijena
            from proizvod a
            inner join kosarica b on a.kosarica =b.sifra 
            where a.kosarica = :parametar;
        
        '); 
        $izraz->execute(['parametar'=>$kosarica->sifra]);
        $kosarica->proizvodi=$izraz->fetchAll();
        return $kosarica;
    }
    public function naruci($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            insert into narudzba (ime,prezime,email,grad,kucniBroj,ulica) values
            (:ime,:prezime,:email:grad,:kucniBroj,:ulica)
            ');
    }
}