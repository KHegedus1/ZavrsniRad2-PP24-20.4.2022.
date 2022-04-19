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
    