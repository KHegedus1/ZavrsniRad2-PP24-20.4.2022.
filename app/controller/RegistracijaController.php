<?php
  class RegistracijaController extends Controller
  {
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