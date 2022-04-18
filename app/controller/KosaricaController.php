 <?php

class OrderController extends AuthorizedController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'kosarica' . DIRECTORY_SEPARATOR;
    private $nf;

    public function __construct()
    {
        parent::__construct();
        $this->nf = new \NumberFormatter("hr-HR", \NumberFormatter::GROUPING_USED);
    }

    public function active()
    {
        if(!isset($_GET['search'])){
            $search = '';
        }else{
            $search = $_GET['search'];
        }

        $ukupnoNarudzbi = Kosarica::ukupnoAktivnihNarudzbi($search);
        $ukupnoNarudzbi = Kosarica::readAktivneNarudzbeKupaca($search);

        $this->view->render($this->viewDir . 'kosarica',[
            'type'=>'active',
            'search'=>$search,
            'orders'=>$orders,
            'ukupnoNarudzbi'=>$ukupnoNarudzbi,
        ]);
        return;
    }

    public function searchactive($search){
        header('Content-type: application/json');
        echo json_encode(Kosarica::searchActive($search));
    }

    public function preuzmiDetalje($sifra)
    {
        $data = (array)Kosarica::readNarudzbaDetalji($sifra);
        echo json_encode($data);
    }

    public function gotovo()
    {
        if(!isset($_GET['search'])){
            $search = '';
            $ukupnoNarudzbi = Kosarica::ukupnoGotovihNarudzbi();
        }else{
            $search = $_GET['search'];
            $ukupnoNarudzbi = Kosarica::ukupnoGotovihNarudzbi($search);
        }

        $narudzbe = Order::readGotoveNarudzbeKupaca($search);

        $this->view->render($this->viewDir . 'narudzbe',[
            'type'=>'finalized',
            'search'=>$search,
            'narudzbe'=>$narudzbe,
            'ukupnoNarudzbi'=>$ukupnoNarudzbi,
        ]);
        return;
    }

    public function gotovoTrazenje($search){
        header('Content-type: application/json');
        echo json_encode(Kosarica::gotovoTrazenje($search));
    }

    public function gotovoTrazenjeDetalji($sifra)
    {
        $data = (array)Kosarica::readNaruzbaDetalji($sifra);
        echo json_encode($data);
    }
}