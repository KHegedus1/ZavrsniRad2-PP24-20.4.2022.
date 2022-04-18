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


    public static function readAktivneNarudzbeKupaca($search)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select distinct a.sifra, a.ime, a.prezime, a.grad, b.sifra as kosaricaId
        from kupac a
        inner join narudzba b on a.sifra=b.kupac
        inner join kosarica c on c.narudzba=b.sifra
        inner join proizvod d on d.sifra=c.proizvod
        where concat(a.grad, e.ime, f.ime) like :search
        and b.isporuceno = 0
        ');

        $search = '%' . $search . '%';
        $query->bindParam('search', $search);
        $query->execute();
        return $query->fetchAll();
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

    public static function ukupnoGotovihNarudzbiS($search)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select count(distinct b.sifra)
        from kupac a
        left join narudzba b on a.sifra=b.kupac
        left join kosarica c on c.narudzba=b.sifra
        left join proizvod d on d.sifra=c.proizvod
        inner join manufacturer e on d.manufacturer=e.sifra
        inner join category f on d.category=f.sifra
        where concat(b.sifra, a.grad, e.ime, f.ime) like :search
        and b.isporuceno = true
        ');

        $search = '%' . $search . '%';
        $query->bindParam('search', $search);
        $query->execute();
        return $query->fetchColumn();
    }

    public static function readGotoveNarudzbeKupaca($search)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select distinct a.sifra, a.ime, a.prezime, a.grad, b.sifra as kosaricaSifra
        from kupac a
        inner join narudzba b on a.sifra=b.kupac
        inner join kosarica c on c.narudzba=b.sifra
        inner join proizvod d on d.sifra=c.proizvod
        where concat(b.sifra, a.grad, e.ime, f.ime) like :search
        and b.isporuceno = 1
        order by kosaricaSifra desc
        ');

        $search = '%' . $search . '%';
        $query->bindParam('search', $search);
        $query->execute();
        return $query->fetchAll();
    }

    public static function ukupnoGotovihNarudzbiS($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
        
        select c.ime,c.sifra as proizvodSIfra, c.cijena as proizvodCijena, a.cijena, a.kolicina
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
}