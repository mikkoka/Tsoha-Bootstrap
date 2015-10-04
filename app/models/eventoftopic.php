<?php

class EventOfTopic extends BaseModel {

    public $kommentti, $aika, $tyyppi, $aihe, $merkitsija, $nimi;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findAll($aihe) {
        
        $query = DB::connection()
                ->prepare('SELECT kommentti, aika, tyyppi, aihe, merkitsija, Tapahtumatyyppi.nimi AS nimi FROM Edistymistapahtuma, Tapahtumatyyppi WHERE aihe = :aihe AND Edistymistapahtuma.tyyppi = Tapahtumatyyppi.id'
        );        
        $query->execute(array('aihe' => $aihe));
        $rows = $query->fetchAll();
        $tapahtumat = array();

        foreach ($rows as $row) {
            $tapahtumat[] = new EventOfTopic(array(
                'kommentti' => $row['kommentti'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'aihe' => $row['aihe'],
                'merkitsija' => $row['merkitsija'],
                'nimi' => $row['nimi']
            ));
        }

        return $tapahtumat;
    }
    
    public static function findType($aihe, $tyyppi) {
        $query = DB::connection()
                ->prepare('SELECT * FROM Edistymistapahtuma WHERE aihe = :aihe AND tyyppi= :tyyppi');
        $query->execute(array('aihe' => $aihe, 'tyyppi' => $tyyppi));
        $rows = $query->fetchAll();
        $tapahtumat = array();

        foreach ($rows as $row) {
            $tapahtumat[] = new EventOfTopic(array(
                'kommentti' => $row['kommentti'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'aihe' => $row['aihe'],
                'merkitsija' => $row['merkitsija']
            ));
        }

        return $tapahtumat;
    }

    public static function find($aihe, $tyyppi, $aika) {
        $query = DB::connection()
                ->prepare('SELECT * FROM Aihe WHERE aihe = :aihe AND tyyppi= :tyyppi AND aika= :aika LIMIT 1'
        );
        $query->execute(array('aihe' => $aihe, 'tyyppi' => $tyyppi, 'aika' => $aika));
        $row = $query->fetch();

        if($row) {
            $edistymistapahtuma = new EventOfTopic(array(
                'kommentti' => $row['kommentti'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'aihe' => $row['aihe'],
                'merkitsija' => $row['merkitsija']
                ));
            
            return $edistymistapahtuma;
        }
        
        return null;
    }

    public static function findLatest($aihe) {
        $query = DB::connection()
                ->prepare('SELECT MAX(aika) AS maxaika FROM Edistymistapahtuma WHERE aihe = :aihe LIMIT 1');
        $query->execute(array('aihe' => $aihe));
        $row = $query->fetch();

        if ($row) {
            $edistymistapahtuma = new EventOfTopic(array(
                'aika' => $row['maxaika']
            ));

            return $edistymistapahtuma;
        }

        return null;
    }
    
    public static function ready($aihe) {
        $query = DB::connection()
                ->prepare('SELECT MAX(aika) AS maxaika FROM Edistymistapahtuma WHERE aihe = :aihe AND tyyppi = 3 LIMIT 1');
        $query->execute(array('aihe' => $aihe));
        $row = $query->fetch();

        if ($row) {
            $edistymistapahtuma = new EventOfTopic(array(
                'aika' => $row['maxaika']
            ));

            return $edistymistapahtuma;
        }

        return null;
    }

    public static function all() {
        $query = DB::connection()
                ->prepare('SELECT * FROM Edistymistapahtuma');
        $query->execute();
        $rows = $query->fetchAll();
        $tapahtumat = array();

        foreach ($rows as $row) {
            $tapahtumat[] = new EventOfTopic(array(
                'kommentti' => $row['kommentti'],
                'aika' => $row['aika'],
                'tyyppi' => $row['tyyppi'],
                'aihe' => $row['aihe'],
                'merkitsija' => $row['merkitsija']
            ));
        }

        return $tapahtumat;
    }
}
