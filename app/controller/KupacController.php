<?php

class KupacController extends AutorizacijaController
{
    private $viewDir =  'privatno' . DIRECTORY_SEPARATOR . 
                        'kupci' . DIRECTORY_SEPARATOR;

    private $poruka;
    private $kupac;

    public function __construct()
    {
        parent::__construct();
        $this->kupac = new stdClass();
        $this->kupac->sifra=0;
        $this->customer->ime='';
        $this->customer->prezime='';
        $this->customer->ulica='';
        $this->customer->kucniBroj='';
        $this->customer->grad='';
        $this->customer->email='';
    }

    public function index()
    {
        $kupac = Kupac::read();

        $this->view->render($this->viewDir . 'index', [
            'kupac' => $customer
        ]);
    }

    public function newcustomer()
    {
        $this->view->render($this->viewDir . 'novikupac',[
            'poruka'=>'',
            'kupac'=>$this->kupac
        ]);
    }

    public function promjena($sifra)
    {
        $this->kupac = Kupac::readOne($id);

        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>'Promjeni podatke',
            'kupac'=>$this->kupac
        ]);
    }

    public function dodajNovi()
    {
        $this->pripremiPodatke();

        if($this->kontrolaIme()
        && $this->kontrolaPrezime()
        && $this->kontrolaEmail()){
            Kupac::create((array)$this->kupac);
            $this->index();
        }else{
            $this->view->render($this->viewDir.'novikupac',[
                'poruka'=>$this->poruka,
                'kupac'=>$this->kupac
            ]);
        }
    }

    public function promjeni()
    {
        $this->pripremiPodatke();

        if($this->kontrolaIme()
        && $this->kontrolaPrezime()
        && $this->kontrolaEmail()){
            Kupac::create((array)$this->kupac);
            $this->index();
        }else{
            $this->view->render($this->viewDir.'promjena',[
                'poruka'=>$this->poruka,
                'kupac'=>$this->kupac
            ]);
        }
    }

    public function brisanje($id)
    {
        Kupac::delete($id);
        header('location:' . App::config('url').'kupac/index');
    }

    private function pripremiPodatke()
    {
        $this->customer=(object)$_POST;
    }
   
    private function kontrolaIme()
    {
        if(strlen($this->kupac->ime)===0){
            $this->poruka='Obavezno je upisati ime';
            return false;
        }
        if(strlen($this->kupac->prezime)>50){
            $this->poruka='Ne smije biti više od 50 znakova';
            return false;
        }

        return true;
    }

    private function kontrolaPrezime()
    {
        if(strlen($this->kupac->prezime)===0){
            $this->poruka='Obavezno je upisati prezime';
            return false;
        }
        if(strlen($this->kupac->prezime)>50){
            $this->poruka='Ne smije biti više od 50 znakova';
            return false;
        }

        return true;
    }
    private function kontrolaEmail()
    {
        if(strlen($this->kupac->email)===0){
            $this->poruka='Obavezno je upisati email adresu';
            return false;
        }
        if(strlen($this->kupac->email)>50){
            $this->poruka='Ne smije biti više od 50 znakova';
            return false;
        }

        return true;
    }

}