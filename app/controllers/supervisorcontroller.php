<?php



class SupervisorController extends BaseController {
    
    public static function supervisors() {
        $kaikki_ohjaajat = Supervisor::familynames();
        echo json_encode($kaikki_ohjaajat);
    }

    public static function addSupervisor($id) {
        self::check_logged_in();
        $params = $_POST;
        $uusi_ohjaaja = new SupervisorOfTopic(array(
            'aihe' => $id,
            'ohjaaja' => $params['ohjaaja_id']
        ));
        $uusi_ohjaaja->save();
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
