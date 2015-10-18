<?php

class FieldController extends BaseController {
    
    
    public static function addField($id) {
        self::check_logged_in();
        $params = $_POST;
        if (isset($params['tutkimusala_id'])) {
            $uusi_ala = new FieldOfTopic(array(
                'aihe' => $id,
                'ala' => $params['tutkimusala_id']
            ));

            $uusi_ala->save();
        }
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }

    public static function removeField($aihe, $ala) {
        self::check_logged_in();    
        $poistettava_ala = new FieldOfTopic(array(
            'aihe' => $aihe, 
            'ala' => $ala            
        ));
        $poistettava_ala->destroy();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
        
    public static function fields() {
        $kaikki_alat = FieldofResearch::all();
        echo json_encode($kaikki_alat);
    }
}

