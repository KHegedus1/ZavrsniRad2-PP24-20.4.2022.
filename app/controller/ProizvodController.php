<?php

class ProizvodController extends AutorizacijaController
{

    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'proizvodi' . DIRECTORY_SEPARATOR;

    private $nf;

    private $poruka;

    private $proizvod;

    public function __construct()
    {
        parent::__construct();
        $this->nf=new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00 kn');
        $this->proizvod=new stdClass();
        $this->proizvod->kategorija='';
        $this->proizvod->naziv='';
        $this->proizvod->cijena='';
    }

    public function index()
    {
        $proizvodi = Proizvod::read();

        foreach($proizvodi as $proizvod){
            $proizvod->cijena=$this->nf->format($proizvod->cijena);            
        }
        
        $this->view->render($this->viewDir . 'index',[
            'proizvodi'=>$proizvodi,
            'css'=>'<link rel="stylesheet" href="' . App::config('url') . 'public/css/webShopArtikl1.css">'
        ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'dodani',[
            'poruka'=>'',
            'proizvod'=>$this->proizvod
        ]);
    }

    public function promjena($id)
    {
        $this->proizvod = Proizvod::readOne($id);

        if($this->proizvod->cijena==0){
            $this->proizvod->cijena='';
        }else{
            $this->proizvod->cijena=$this->nf->format($this->proizvod->cijena);
        }

        $this->view->render($this->viewDir . 'promjena',[
            'poruka'=>'Promijenite podatke',
            'proizvod'=>$this->proizvod
        ]);

    }

    public function dodajNovi()
    {
        $this->pripremiPodatke();

        if($this->kontrolaNaziv()
        && $this->kontrolaIzvodac()
        && $this->kontrolaCijena()){
            Proizvod::create((array)$this->proizvod);
            header('location:' . App::config('url') . 'proizvod/index');
        }else{
            $this->view->render($this->viewDir . 'dodani',[
                'poruka'=>$this->poruka,
                'proizvod'=>$this->proizvod
            ]);
        }        
    }

    public function promijeni()
    {
        $this->pripremiPodatke();        
        
        if($this->kontrolaNaziv()
        && $this->kontrolaIzvodac()
        && $this->kontrolaCijena()){
            Proizvod::update((array)$this->proizvod);
            header('location:' . App::config('url') . 'proizvod/index');
        }else{
            $this->view->render($this->viewDir . 'promjena',[
                'poruka'=>$this->poruka,
                'proizvod'=>$this->proizvod
            ]);
        }
    }

    public function brisanje($sifra)
    {
        Proizvod::delete($sifra);
        header('location:' . App::config('url') . 'proizvod/index');
    }

    private function pripremiPodatke()
    {
        $this->proizvod=(object)$_POST;
    }

    private function kontrolaNaziv()
    {
        if(strlen($this->proizvod->naziv)===0){
            $this->poruka='Unesite naziv';
            return false;
        }
        if(strlen($this->proizvod->naziv)>50){
            $this->poruka='Naziv mora imati manje od 50 znakova.';
            return false;
        }        
        return true;
    }
    private function kontrolaCijena()
    {
        if(strlen(trim($this->proizvod->cijena))>0){

            if(strpos($this->proizvod->cijena,'kn')>=0){
                $this->proizvod->cijena = trim(str_replace('kn','',$this->proizvod->cijena));
            }

            $this->proizvod->cijena = str_replace('.','',$this->proizvod->cijena);

            $this->proizvod->cijena = (float)str_replace(',','.',$this->proizvod->cijena);

            if($this->proizvod->cijena<=0){
                $this->poruka='Cijena mora biti decimalni broj veći od 0, a unijeli ste: ' . $this->proizvod->cijena;
                $this->proizvod->cijena='';
                return false;
            }
        }

        return true;
    }    
}