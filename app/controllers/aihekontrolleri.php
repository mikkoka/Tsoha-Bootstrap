<?php

class Aihekontrolleri extends BaseController {
    public static function index() {
        $aiheet = Aihe::all();
        
        View::make('aihe/index.html', array('aiheet'=>$aiheet));
    }
    
        public static function uusiAihe() {
        
        View::make('aihe/add.html');
    }

    public static function luoUusiAihe() {
        $params = $_POST;
        $aihe = new Aihe(array(
            'otsikko' => $params['otsikko'],
            'kuvaus' => $params['kuvaus'],
            'tekija_nimi' => $params['tekija_nimi'],
            'opnro' => $params['opnro']
        ));

        $aihe->tallenna();

        Redirect::to('/aihe/' . $aihe->id . '/muokkaus');
    }

    public static function show($id) {
        $aihe = Aihe::find($id);
        $ohjaajat = Ohjaaja::findOhjaajat($id);
        $alat = Tutkimusala::gradunAlat($id);
        $tapahtuma = Edistymistapahtuma::findLatest($id);  
        $valmis = Edistymistapahtuma::valmis($id);
        
        View::make('aihe/show.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'alat'=>$alat,
            'tapahtuma'=>$tapahtuma,
            'valmis'=>$valmis));
    }
    
        public static function edit($id) {
        $aihe = Aihe::find($id);
        $ohjaajat = Ohjaaja::findOhjaajat($id);
        $alat = Tutkimusala::gradunAlat($id);
        $tapahtumat = Edistymistapahtuma::findAll($id);
        $tapahtumatyyppi = Tapahtumatyyppi::all();
        $kaikki_ohjaajat = Ohjaaja::all();
        $kaikki_alat = Tutkimusala::all();
        
        View::make('aihe/edit.html', array(
            'aihe'=>$aihe,
            'ohjaajat'=>$ohjaajat,
            'alat'=>$alat,
            'tapahtumat'=>$tapahtumat,
            'tapahtumatyyppi'=>$tapahtumatyyppi,
            'kaikki_ohjaajat'=>$kaikki_ohjaajat,
            'kaikki_alat'=>$kaikki_alat));
    }  
    
            public static function edit_gradu($id) {
        $aihe = Aihe::find($id);
        
        View::make('aihe/gradu_edit.html', array(
            'aihe'=>$aihe,
            ));
    }
    

    
    
    
    public static function lisaa_ohjaaja($id) {
        $params = $_POST;
        $uusi_ohjaaja = new AiheenOhjaaja(array(
            'aihe' => $id, 
            'ohjaaja' => $params['ohjaaja_id']            
        ));
        
        $uusi_ohjaaja->tallenna();
        
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }
    
        public static function lisaa_tutkimusala($id) {
        $params = $_POST;
        $uusi_ala = new AiheenLuokitus(array(
            'aihe' => $id, 
            'ala' => $params['tutkimusala_id']            
        ));
        
        $uusi_ala->tallenna();
        
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }
            
}

