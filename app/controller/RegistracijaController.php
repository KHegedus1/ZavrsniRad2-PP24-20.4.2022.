<?php
  class RegistracijaController extends Controller
  {
    public function __construct()
    {
        parent::__construct();
        
        $this->kupac = new stdClass();
        $this->kupac->sifra = null;
        $this->kupac->ime = '';
        $this->kupac->prezime = '';
        $this->kupac->ulica = '';
        $this->kupac->kucniBroj = '';
        $this->kupac->grad = '';
        $this->kupac->email = '';

        $this->poruka = new stdClass();
        $this->poruka->ime='';
        $this->poruka->prezime='';
        $this->poruka->ulica = '';
        $this->poruka->kucniBroj = '';
        $this->poruka->grad = '';
        $this->poruka->email = '';
    }
      public function index()
      {
          $this->regView('Popunite podatke','');
      }

      private function regView($poruka,$email)
    {
        $this->view->render('registracija',[
            'poruka'=>$poruka,
            'email'=>$email
        ]);
    }
    public function noviKupac(){
    $this->kupac = (object) $_POST;

        Kupac::insert((array)$this->kupac);

        $kupac = Registracija::readOne($this->kupac->email);
        $_SESSION['autoriziran'] = $kupac;

        header('location: ' . App::config('url'));
            
    }
}