<?php

class Aihekontrolleri extends BaseController {
    
    private static $saannot = array(
        "required" => array(
            array("opnro"), 
            array("otsikko"), 
            array("tekija_nimi")),
        "numeric" => "opnro",
        "lengthBetween" => array (
            array("otsikko", 5, 300),
            array("tekija_nimi", 5, 80),
            array("opnro", 7, 9))
        );
    
    public static $kieli = '/home/mkahri/htdocs/tsoha/vendor/vlucas/valitron/lang';
    
    public static function edit($id) {
        self::check_logged_in();
        $aihe = Aihe::find($id);
        $ohjaajat = Ohjaaja::findOhjaajat($id);
        $luoja = Ohjaaja::findLuoja($id);
        $alat = Tutkimusala::gradunAlat($id);
        $tapahtumat = Edistymistapahtuma::findAll($id);
        $tapahtumatyyppi = Tapahtumatyyppi::all();
        $kaikki_ohjaajat = Ohjaaja::all();
        $kaikki_alat = Tutkimusala::all();
        
        View::make('aihe/edit.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'luoja' =>$luoja,
            'alat'=>$alat,
            'tapahtumat'=>$tapahtumat,
            'tapahtumatyyppi'=>$tapahtumatyyppi,
            'kaikki_ohjaajat'=>$kaikki_ohjaajat,
            'kaikki_alat'=>$kaikki_alat));
    }  
    
        public static function edit_gradu($id) {
        self::check_logged_in();
        $aihe = Aihe::find($id);
        
        View::make('aihe/gradu_edit.html', array(
            'aihe'=>$aihe,
            ));
    }    
 
    public static function index() {
        $aiheet = Aihe::all();
        
        View::make('aihe/index.html', array('aiheet'=>$aiheet));
    }
    
    public static function search() {
        $params = $_GET;        
        if (empty($params['tutkimusala']) && !empty($params['snimi'])) {
            $aiheet = Aihe::ohjaajanAiheet($params['snimi']);
            $message =  "Hakusana '" . $params['snimi'] . "' tuotti seuraavat tulokset:";
        } else if (empty($params['snimi']) && !empty($params['tutkimusala'])) {
            $aiheet = Aihe::alanAiheet($params['tutkimusala']);
            $message = "Hakusana '" . $params['tutkimusala'] . "' tuotti seuraavat tulokset:"; 
        } else if (empty($params['snimi']) && empty($params['tutkimusala'])) {
           header('Location: ' . BASE_PATH . '/aiheet');
           exit;
        } else {
            $aiheet = Aihe::ohjaajanAiheetAlalla($params['snimi'], $params['tutkimusala']);
            $message = "Hakusanat '". $params['snimi'] . "' ja '" . $params['tutkimusala'] . "' tuottivat seuraavat tulokset:"; 
        }
        View::make('aihe/index.html', array('aiheet' => $aiheet, 'haku' => $message));
    }
    
    public static function show($id) {
        $aihe = Aihe::find($id);
        $ohjaajat = Ohjaaja::findOhjaajat($id);
        $luoja = Ohjaaja::findLuoja($id);
        $alat = Tutkimusala::gradunAlat($id);
        $tapahtuma = Edistymistapahtuma::findLatest($id);  
        $valmis = Edistymistapahtuma::valmis($id);
        
        View::make('aihe/show.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'luoja' =>$luoja,
            'alat'=>$alat,
            'tapahtuma'=>$tapahtuma,
            'valmis'=>$valmis));
    }
    
    
    public static function muokkaa($id) {
        self::check_logged_in();
        $params = $_POST;
        $attribuutit = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'tekija_nimi' => $params['tekija_nimi'],
            'opnro' => $params['opnro'],
            'id' => $id
        );

        Valitron\Validator::langDir(self::$kieli); 
        Valitron\Validator::lang('fi');
        $validoija = new Valitron\Validator($attribuutit);
        $validoija->rules(self::$saannot);

        if ($validoija->validate()) {
               
            $aihe = new Aihe($attribuutit);            
            $aihe->paivita();
            Redirect::to('/aihe/' . $id);
            
        } else {    
            View::make('aihe/gradu_edit.html', array('errors' => $validoija->errors(), 'aihe' => $attribuutit));     
        }         
    }
    
    public static function tallenna() {
        self::check_logged_in();
        $params = $_POST;
        $attribuutit = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'tekija_nimi' => $params['tekija_nimi'],
            'opnro' => $params['opnro'],
            'luoja' => $_SESSION['user']
        );

        Valitron\Validator::langDir(self::$kieli); 
        Valitron\Validator::lang('fi');
        $validoija = new Valitron\Validator($attribuutit);
        $validoija->rules(self::$saannot);

        if ($validoija->validate()) {
               
            $aihe = new Aihe($attribuutit);            
            $aihe->tallenna();
            Redirect::to('/aihe/' . $aihe->id . '/muokkaus');
            
        } else {    
            View::make('aihe/add.html', array('errors' => $validoija->errors(), 'attributes' => $attribuutit));     
        }
    }
    
    public static function poista($id) {
        self::check_logged_in();
        $aihe = new Aihe(array('id' => $id));
        $aihe->poista();
        Redirect::to('/aiheet', array('message' => 'Aihe poistettu onnistuneesti!'));
    }
    
    public static function uusiAihe() {
        self::check_logged_in();
        View::make('aihe/add.html');
    }         
}

