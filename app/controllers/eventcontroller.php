<?php

class EventController extends BaseController {

    public static function create($id) {
        self::check_logged_in();
        $params = $_POST;
        if (isset($params['tyyppi'])) {
            $uusi_tapahtuma = new EventOfTopic(array(
                'aihe' => $id,
                'tyyppi' => $params['tyyppi'],
                'merkitsija' => $_SESSION['user']
            ));
            $uusi_tapahtuma->save();
        }
        Redirect::to('/aihe/' . $id . '/muokkaus');
    }

    public static function removeEvent($aihe, $alan_nimi) {
        self::check_logged_in();
        $poistettava_tapahtuma = new EventOfTopic(array(
            'aihe' => $aihe,
            'tyyppi' => $alan_nimi
        ));
        $poistettava_tapahtuma->destroy();
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
    }
    
    public static function editComment($aihe, $tyyppi) {
        self::check_logged_in();
        $params = $_POST;
        $nimi = $params['nimi'];
        $tapahtuma = EventOfTopic::find($aihe, $tyyppi, $params['aika']);
        $merkitsija = Supervisor::find($tapahtuma->merkitsija);
        View::make('tapahtuma/edit.html', array(
            'aika'=>$tapahtuma->aika,
            'aihe'=> $tapahtuma->aihe,
            'tyyppi'=> $tapahtuma->tyyppi,
            'merkitsija'=> $merkitsija,
            'kommentti'=> $tapahtuma->kommentti,
            'nimi'=> $nimi));
        
        
    }
    
        public static function saveComment($aihe, $tyyppi, $aika) {
        self::check_logged_in();
        $params = $_POST;
        $kommentti = $params['kommentti'];
        EventOfTopic::update($aihe, $tyyppi, $aika, $kommentti);
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
        
        
    }
    
        public static function destroyComment($aihe, $tyyppi, $aika) {
        self::check_logged_in();
        $params = $_POST;
        EventOfTopic::destroy($aihe, $tyyppi, $aika);
        Redirect::to('/aihe/' . $aihe . '/muokkaus');
        
        
    }

}
