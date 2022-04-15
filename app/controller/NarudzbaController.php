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
                'prezime'=>'Hegeduš',
                'ulica'=>'Reisnerova',
                'kucniBroj'=>52,
                'grad'=>'Osijek',
                'email'=>'khegedus1@gmail.com'
                ]);
                break;
               
             case 'promijeni':
                Narudzba::update([
                'sifra'=>6,
                'ime'=>'Druga',
                'prezime'=>'Osoba',
                'ulica'=>'Rreisnerova',
                'kucniBroj'=>53,
                'grad'=>'Osijek',
                'email'=>'khegedus2@gmail.com'
                ]);
                break;

            case 'obrisi':
                Narudzba::delete(6);
        }
    }
}