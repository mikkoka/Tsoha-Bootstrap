<?php

class FieldController extends BaseController {
    
    
    public static function addField($id) {
        self::check_logged_in();
        $params = $_POST;
        $uusi_ala = new FieldOfTopic(array(
            'aihe' => $id, 
            'ala' => $params['tutkimusala_id']            
        ));
        
        $uusi_ala->tallenna();
        
        Redirect::to('/aihe/' . $id . '/muokkaus');
    } 

    
        public static function removeField($aihe, $ala) {
        self::check_logged_in();    
        $poistettava_ala = new FieldOfTopic(array(
            'aihe' => $aihe, 
            'ala' => $ala            
        ));
        $poistettava_ala->poista();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
        
    public static function fields() {
        $kaikki_alat = FieldofResearch::all();
        echo json_encode($kaikki_alat);
    }
}

