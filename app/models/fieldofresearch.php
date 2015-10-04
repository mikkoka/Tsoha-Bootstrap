<?php

class FieldofResearch extends BaseModel {
    public $id, $nimi;
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * from Tutkimusala');
        $query->execute();
        $rows = $query->fetchAll();
        $tutkimusalat = array();
        
        foreach ($rows as $row) {
            $tutkimusalat[] = new FieldofResearch(Array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }
        
        return $tutkimusalat;
    }
    
    public static function gradunAlat($aihe) {
        $query = DB::connection()->prepare('SELECT * from Tutkimusala, Aiheen_luokitus WHERE Aiheen_luokitus.aihe = :aihe AND Aiheen_luokitus.ala = Tutkimusala.id');
        $query->execute(array('aihe' => $aihe));
        $rows = $query->fetchAll();
        $tutkimusalat = array();
        
        foreach ($rows as $row) {
            $tutkimusalat[] = new FieldofResearch(Array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }
        
        return $tutkimusalat;
    }
}
