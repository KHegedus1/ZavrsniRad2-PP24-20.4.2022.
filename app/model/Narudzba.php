<?php

class Narudzba
{
    public static function getNarudzba($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            select sifra, kupac
            from narudzba 
            where isporuceno = 0 and kupac=:kupacSifra 
            
        ');
        $query->execute([
            'kupacSifra' => $sifra
        ]);

        return $query->fetch();
    }
    public static function create($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            insert into narudzba (kupac, isporuceno) values
            (:kupacSifra, false)
            
        ');
        $query->execute([
            'kupacSifra' => $sifra
        ]);

    }

    public static function dodajuKosaricu($proizvod, $narudzbaSifra, $kolicina)
    {
        $connection = DB::getInstanca();

        $query = $connection->prepare('
            select a.kolicina
            from kosarica as a
            inner join narudzba as b on a.narudzba = b.sifra
            where a.proizvod = :proizvod and b.sifra = :narudzbaSifra
            
        ');
        $query->execute([
            'proizvod' => $proizvod,
            'narudzbaSifra' => $narudzbaSifra
        ]);

        $postojiliuKosarici = $query->fetchColumn();

        if($postojiliuKosarici == 0){
            $query = $connection->prepare('
            insert into kosarica (narudzba, proizvod, cijena, kolicina) values
            (:narudzbaSifra, :proizvod, (select cijena from proizvod where sifra = :proizvod), 1 )
            
            ');
            return $query->execute([
                'proizvod' => $proizvod,
                'narudzbaSifra' => $narudzbaSifra
            ]);
        }else{
            $query = $connection->prepare('
            update kosarica a
            inner join narudzba as b on a.narudzba=b.sifra
            set a.kolicina = a.kolicina+1
            where proizvod= :proizvod and b.sifra= :narudzbaSifra
            
            ');
            return $query->execute([
                'proizvod' => $proizvod,
                'narudzbaSifra' => $narudzbaSifra
            ]);
        }
    }
    public static function obrisiizKosarice($proizvod, $narudzbaSifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            delete from kosarica 
            where proizvod = :proizvod and narudzba = :narudzbaSifra
            
        ');
        return $query->execute([
            'proizvod' => $proizvod,
            'narudzbaSifra' => $narudzbaSifra
        ]);
    }
    public static function getNarudzbaKosarica($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            select a.sifra as kosaricaSifra,c.sifra as sifra, c.ime,b.cijena, b.kolicina
            from narudzba a
            inner join kosarica b on a.sifra=b.narudzba
            inner join proizvod c on b.proizvod=c.sifra
            where a.isporuceno = 0 and a.kupac = :kupacSifra
            
        ');
        $query->execute([
            'kupacSifra' => $sifra
        ]);

        return $query->fetchAll();
    }
    }
    public static function zbrajanje($sifra)
    {
        $connection = DB::getInstanca();
        $query = $connection->prepare('
            select sum(b.cijena*b.kolicina) as number
            from narudzba a
            inner join kosarica b on a.sifra=b.narudzba
            where a.isporuceno = 0 and a.kupac = :kupacSifra
            
        ');
        $query->execute([
            'kupacSifra' => $sifra
        ]);

        return $query->fetchColumn();
    }
}
