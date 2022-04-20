 <?php

class KosaricaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'kosarica' . DIRECTORY_SEPARATOR;
    private $nf;

    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::GROUPING_USED);
    }


    public function preuzmiDetalje($sifra)
    {
        $data = (array)Kosarica::readNarudzbaDetalji($sifra);
        echo json_encode($data);
    }

public function index()
{
    $narudzba=Narudzba::getNarudzbaKosarica($_SESSION['autoriziran']->sifra);
    foreach($narudzba as $proizvod){
        $proizvod->priceFormatted=$this->nf->format($proizvod->cijena);
    }

    $this->view->render($this->viewDir . 'index', [
        'kosarica' =>$kosarica,
    ]);
}
public function naruci($sifra)
{
    $kupacSifra = $_SESSION['autoriziran']->sifra;
}

}    