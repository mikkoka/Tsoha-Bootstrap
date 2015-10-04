<?php

class Alakontrolleri extends BaseController {
    
    
    public static function lisaa_aiheen_luokitus($id) {
        self::check_logged_in();
        $params = $_POST;
        $uusi_ala = new AiheenLuokitus(array(
            'aihe' => $id, 
            'ala' => $params['tutkimusala_id']            
        ));
        
        $uusi_ala->tallenna();
        
        Redirect::to('/aihe/' . $id . '/muokkaus');
    } 

    
        public static function poista_aiheen_luokitus($aihe, $ala) {
        self::check_logged_in();    
        $poistettava_ala = new AiheenLuokitus(array(
            'aihe' => $aihe, 
            'ala' => $ala            
        ));
        $poistettava_ala->poista();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
        
    public static function tutkimusalalista() {
        $kaikki_alat = Tutkimusala::all();
        echo json_encode($kaikki_alat);
    }
}

