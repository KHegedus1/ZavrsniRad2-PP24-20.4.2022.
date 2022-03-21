<?php

class NarudzbaController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'narudzbe' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index');
    }

    public function test($sto)
    {
        switch($sto){
            case 'dodaj':
                Narudzba::create([
                'ime'=>'Kristijan',
                'prezime'=>'Hegedus',
                'ulica'=>'Reisnerova ulica',
                'kucniBroj'=>52,
                'grad'=>'Osijek',
                'email'=>'khegedus@gmail.com',
                'narudzba'=>'2020-02-06 23:10:33',
                ]);
                break;
               
             case 'promijeni':
                Narudzba::update([
                'sifra'=>6,
                'ime'=>'Druga',
                'prezime'=>'Osoba',
                'ulica'=>'Biokovska ulica',
                'kucniBroj'=>124,
                'grad'=>'Osijek',
                'email'=>'druga.osoba@gmail.com',
                'narudzba'=>'2020-02-06 23:10:33',
                ]);
                break;

            case 'obrisi':
                Narudzba::delete(6);
        }
    }
}