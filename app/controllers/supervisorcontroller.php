<?php



class SupervisorController extends BaseController {
    

    private static $rules = array(
        "required" => array(
            array("enimi"),
            array("snimi"),
            array("sposti"),
            array("salasana"),
            array("rtunnus")),
        "lengthBetween" => array(
            array("enimi", 1, 40),
            array("snimi", 2, 40),
            array("salasana", 7, 100)),
        "email" => array(
            array("sposti")) ,
        "equals" => array(
            array("rtunnus", "Virallinen rekisteröitymistunnus")
        )
    );
    
    public static function supervisors() {
        $kaikki_ohjaajat = Supervisor::familynames();
        echo json_encode($kaikki_ohjaajat);

    }

    public static function addSupervisor($id) {
        self::check_logged_in();
        $params = $_POST;
        if (isset($params['ohjaaja_id'])) {
            $uusi_ohjaaja = new SupervisorOfTopic(array(
                'aihe' => $id,
                'ohjaaja' => $params['ohjaaja_id']
            ));
            $uusi_ohjaaja->save();
        }
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }
    
        public static function removeSupervisor($aihe, $ohjaaja) {
        self::check_logged_in();    
        $poistettava_ohjaaja = new SupervisorOfTopic(array(
            'aihe' => $aihe,
            'ohjaaja' => $ohjaaja
        ));
        $poistettava_ohjaaja->destroy();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
    public static function register () {
        View::make('ohjaaja/register.html');
    }
    
    public static function create() {
        $params = $_POST;
        Valitron\Validator::langDir(self::$language);
        Valitron\Validator::lang('fi');
        $attribuutit = array(
            'enimi' => $params['enimi'],
            'snimi' => $params['snimi'],
            'sposti' => $params['sposti'],
            'salasana' => $params['salasana'],
            'rtunnus' => $params['rtunnus'],
            'Virallinen rekisteröitymistunnus' => self::$rekisterointiTunnus
        );
        $validoija = new Valitron\Validator($attribuutit);
        $validoija->rules(self::$rules);

        if ($validoija->validate()) {
               
            $uusi_ohjaaja = new Supervisor($attribuutit);            
            $uusi_ohjaaja->create();
            Redirect::to('/aiheet', array('message' => 'Ohjaaja lisätty onnistuneesti!'));
            
        } else {    
            View::make('ohjaaja/register.html', array('errors' => $validoija->errors(), 'attributes' => $attribuutit));     
        }        
    }
    
    public static function login() {
        View::make('ohjaaja/login.html');
    }
    
    public static function handleLogin() {
        $params = $_POST;
             
        $user = Supervisor::authenticate($params['sposti'], $params['salasana']);     
        if (!$user) {
            Redirect::to('/login', array('message' => 'Tarkasta kirjautumistietosi!', 'sposti' => $params['sposti']));            
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/aiheet', array('message' => 'Tervetuloa takaisin, ' . $user->enimi . '!'));
        }
    }
    
    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }
}
