<?php

class Alakontrolleri extends BaseController {
    
    
    public static function lisaa_aiheen_luokitus($id) {
        $params = $_POST;
        $uusi_ala = new AiheenLuokitus(array(
            'aihe' => $id, 
            'ala' => $params['tutkimusala_id']            
        ));
        
        $uusi_ala->tallenna();
        
        Redirect::to('/aihe/' . $id . '/muokkaus');
    } 

    
        public static function poista_aiheen_luokitus($aihe, $ala) {
        $poistettava_ala = new AiheenLuokitus(array(
            'aihe' => $aihe, 
            'ala' => $ala            
        ));
        $poistettava_ala->poista();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
}

