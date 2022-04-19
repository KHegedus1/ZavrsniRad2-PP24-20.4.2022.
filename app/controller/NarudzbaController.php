<?php

class NarudzbaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'narudzbe' . DIRECTORY_SEPARATOR;

    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::DECIMAL);
        $this->nf->setPattern('#,##0.00');
    }

    public function index()
    {
        $narudzba=Narudzba::getNarudzbaKosarica($_SESSION['autoriziran']->sifra);
        foreach($narudzba as $proizvod){
            $proizvod->priceFormatted=$this->nf->format($proizvod->cijena);
        }

        $this->view->render($this->viewDir . 'index', [
            'narudzba' =>$narudzba,
        ]);
    }

    public function dodajuKosaricu($proizvodSifra, $kolicina=1)
    {
        $kupacSifra = $_SESSION['autoriziran']->sifra;
        if (Narudzba::getNarudzbaKosarica($kupacSifra) == null) {
            Narudzba::create($kupacSifra);
        }
        $narudzbaSifra = Narudzba::getNarudzba($kupacSifra)->sifra;



        echo Narudzba::dodajuKosaricu($proizvodSifra, $narudzbaSifra, $kolicina);
    }

    public function obrisiizKosarice($proizvodSifra)
    {
        $kupacSifra = $_SESSION['autoriziran']->sifra;
        $narudzbaSifra = Narudzba::getNarudzba($kupacSifra)->sifra;

        echo Narudzba::obrisiizKosarice($proizvodSifra, $narudzbaSifra);

    }
}

