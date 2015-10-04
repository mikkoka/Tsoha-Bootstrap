<?php


class Ohjaajakontrolleri extends BaseController {

    public static function lisaa_aiheen_ohjaaja($id) {
        self::check_logged_in();
        $params = $_POST;
        $uusi_ohjaaja = new AiheenOhjaaja(array(
            'aihe' => $id,
            'ohjaaja' => $params['ohjaaja_id']
        ));
        $uusi_ohjaaja->tallenna();
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }
    
        public static function poista_aiheen_ohjaaja($aihe, $ohjaaja) {
        self::check_logged_in();    
        $poistettava_ohjaaja = new AiheenOhjaaja(array(
            'aihe' => $aihe,
            'ohjaaja' => $ohjaaja
        ));
        $poistettava_ohjaaja->poista();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
    public static function login() {
        View::make('ohjaaja/login.html');
    }
    
    public static function handle_login() {
        $params = $_POST;
        
        
        $user = Ohjaaja::authenticate($params['sposti'], $params['salasana']);
        
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

    public static function ohjaajalista() {
        $kaikki_ohjaajat = Ohjaaja::familynames();
        echo json_encode($kaikki_ohjaajat);
    }
}
