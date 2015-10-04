<?php

class TopicController extends BaseController {
    
    private static $rules = array(
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
    
    public static $language = '/home/mkahri/htdocs/tsoha/vendor/vlucas/valitron/lang';
    
    // UPDATING
    
    public static function update1($id) {
        self::check_logged_in();
        $aihe = Topic::find($id);
        $ohjaajat = Supervisor::findOhjaajat($id);
        $luoja = Supervisor::findLuoja($id);
        $alat = FieldofResearch::gradunAlat($id);
        $tapahtumat = EventOfTopic::findAll($id);
        $tapahtumatyyppi = EventType::all();
        $kaikki_ohjaajat = Supervisor::all();
        $kaikki_alat = FieldofResearch::all();
        
        View::make('aihe/update.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'luoja' =>$luoja,
            'alat'=>$alat,
            'tapahtumat'=>$tapahtumat,
            'tapahtumatyyppi'=>$tapahtumatyyppi,
            'kaikki_ohjaajat'=>$kaikki_ohjaajat,
            'kaikki_alat'=>$kaikki_alat));
    }  
    
        public static function update2($id) {
        self::check_logged_in();
        $aihe = Topic::find($id);
        
        View::make('aihe/update2.html', array(
            'aihe'=>$aihe,
            ));
    }
    
        public static function saveUpdate($id) {
        self::check_logged_in();
        $params = $_POST;
        $attribuutit = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'tekija_nimi' => $params['tekija_nimi'],
            'opnro' => $params['opnro'],
            'id' => $id
        );

        Valitron\Validator::langDir(self::$language); 
        Valitron\Validator::lang('fi');
        $validoija = new Valitron\Validator($attribuutit);
        $validoija->rules(self::$rules);

        if ($validoija->validate()) {
               
            $aihe = new Topic($attribuutit);            
            $aihe->paivita();
            Redirect::to('/aihe/' . $id);
            
        } else {    
            View::make('aihe/update2.html', array('errors' => $validoija->errors(), 'aihe' => $attribuutit));     
        }         
    } 
           
    public static function save() {
        self::check_logged_in();
        $params = $_POST;
        $attribuutit = array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'tekija_nimi' => $params['tekija_nimi'],
            'opnro' => $params['opnro'],
            'luoja' => $_SESSION['user']
        );

        Valitron\Validator::langDir(self::$language); 
        Valitron\Validator::lang('fi');
        $validoija = new Valitron\Validator($attribuutit);
        $validoija->rules(self::$rules);

        if ($validoija->validate()) {
               
            $aihe = new Topic($attribuutit);            
            $aihe->tallenna();
            Redirect::to('/aihe/' . $aihe->id . '/muokkaus');
            
        } else {    
            View::make('aihe/add.html', array('errors' => $validoija->errors(), 'attributes' => $attribuutit));     
        }
    }
    
    public static function destroy($id) {
        self::check_logged_in();
        $aihe = new Topic(array('id' => $id));
        $aihe->poista();
        Redirect::to('/aiheet', array('message' => 'Aihe poistettu onnistuneesti!'));
    }
    
    public static function create() {
        self::check_logged_in();
        View::make('aihe/add.html');
    } 
    
    // LISTING, VIEWING
 
    public static function all() {
        $aiheet = Topic::all();
        
        View::make('aihe/index.html', array('aiheet'=>$aiheet));
    }
    
    public static function search() {
        $params = $_GET;        
        if (empty($params['tutkimusala']) && !empty($params['snimi'])) {
            $aiheet = Topic::ohjaajanAiheet($params['snimi']);
            $message =  "Hakusana '" . $params['snimi'] . "' tuotti seuraavat tulokset:";
        } else if (empty($params['snimi']) && !empty($params['tutkimusala'])) {
            $aiheet = Topic::alanAiheet($params['tutkimusala']);
            $message = "Hakusana '" . $params['tutkimusala'] . "' tuotti seuraavat tulokset:"; 
        } else if (empty($params['snimi']) && empty($params['tutkimusala'])) {
           header('Location: ' . BASE_PATH . '/aiheet');
           exit;
        } else {
            $aiheet = Topic::ohjaajanAiheetAlalla($params['snimi'], $params['tutkimusala']);
            $message = "Hakusanat '". $params['snimi'] . "' ja '" . $params['tutkimusala'] . "' tuottivat seuraavat tulokset:"; 
        }
        View::make('aihe/index.html', array('aiheet' => $aiheet, 'haku' => $message));
    }
    
    public static function show($id) {
        $aihe = Topic::find($id);
        $ohjaajat = Supervisor::findOhjaajat($id);
        $luoja = Supervisor::findLuoja($id);
        $alat = FieldofResearch::gradunAlat($id);
        $tapahtuma = EventOfTopic::findLatest($id);  
        $valmis = EventOfTopic::ready($id);
        
        View::make('aihe/show.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'luoja' =>$luoja,
            'alat'=>$alat,
            'tapahtuma'=>$tapahtuma,
            'valmis'=>$valmis));
    }       
}

