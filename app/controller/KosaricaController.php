<?php

class KosaricaController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'kosarica' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index');
    }
    public function dodajukosaricu($sifra){
        
        if($kosarica ==null){
            $kosarica = $this->model('Narudzba');
            $kosarica->status = 'kosarica';
            $kosarica->create();
        }
        $noviProizvod = $this->model('Naruzba');
        $noviProizvod->narudzba=$kosarica->narudzba;
        $noviProizvod->proizvod = $proizvod;
        $noviProizvod->cijena =$this->model('Proizvod')->find($proizvod)->cijena;
        $noviProizvod->qty =1;
        $noviProizvod->create(); 
    }
}