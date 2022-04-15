<?php

class Narudzba
{
    public static function readOne($kljuc)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, b.ime, b.prezime, b.ulica, b.kucniBroj, b.grad, b.email,a.narudzba
        from narudzba a inner join kupac b on
        a.kupac = b.sifra
        where a.sifra=:parametar;
        
        ');
        $izraz->execute(['parametar'=>$kljuc]);
        return $izraz->fetch();
    }
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('
        
        select a.sifra, b.ime, b.prezime, b.ulica, b.kucniBroj, b.grad, b.email,a.narudzba, 
        from narudzba a inner join kupac b on
        a.kupac = b.sifra
        where kupac is true;
        order by 3,2;
        
        ');
        $izraz->execute();
        return $izraz->fetchAll();
    }
    public static function create($parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        insert into kupac (ime, prezime, ulica, kucniBroj, grad,email) values
        (:ime, :prezime, :ulica, :kucniBroj, :grad, :email)
        
        ');
        $izraz->execute([
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'ulica'=>$parametri['ulica'],
            'kucniBroj'=>$parametri['kucniBroj'],
            'grad'=>$parametri['grad'],
            'email'=>$parametri['email']
        ]);

        $zadnjaSifra = $veza->lastInsertId();

        $izraz = $veza->prepare('
        
        insert into narudzba (kupac,narudzba) values
        (:kupac,:narudzba)
        
        ');
        $izraz->execute([
            'kupac'=>$zadnjaSifra,
            'narudzba'=>$parametri['narudzba'],
        ]);

        $veza->commit();
    }
    public static function update($parametri)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        select kupac from narudzba where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$parametri['sifra']
        ]);

        $sifraKupac = $izraz->fetchColumn();

        $izraz = $veza->prepare('
        
        update kupac set
        ime=:ime,
        prezime=:prezime,
        ulica=:ulica,
        kucniBroj=:kucniBroj,
        grad=:grad,
        email=:email,
        where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifraKupac,
            'ime'=>$parametri['ime'],
            'prezime'=>$parametri['prezime'],
            'ulica'=>$parametri['ulica'],
            'kucniBroj'=>$parametri['kucniBroj'],
            'grad'=>$parametri['grad'],
            'email'=>$parametri['email']
        ]);

        $izraz = $veza->prepare('
        
        update narudzba set
        narudzba=:narudzba,
        where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$parametri['sifra'],
            'narudzba'=>$parametri['narudzba']
        ]);

        $veza->commit();
    }
    public static function delete($sifra)
    {
        $veza = DB::getInstanca();
        $veza->beginTransaction();
        $izraz = $veza->prepare('
        
        delete from narudzba where sifra=:sifra
        
        ');
        $izraz->execute([
            'sifra'=>$sifra
        ]);

        $veza->commit();
    }
}