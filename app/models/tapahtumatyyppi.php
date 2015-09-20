<?php

class Tapahtumatyyppi extends BaseModel {
    public $id, $nimi;
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * from Tapahtumatyyppi');
        $query->execute();
        $rows = $query->fetchAll();
        $tapahtumatyypit = array();
        
        foreach ($rows as $row) {
            $tapahtumatyypit[] = new Tapahtumatyyppi(Array(
                'id' => $row['id'],
                'nimi' => $row['nimi']
            ));
        }
        
        return $tapahtumatyypit;
    }

}