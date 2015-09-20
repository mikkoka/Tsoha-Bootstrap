<?php

class Ohjaaja extends BaseModel {
    public $id, $enimi, $snimi, $salasana, $sposti; 
    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * from Ohjaaja');
        $query->execute();
        $rows = $query->fetchAll();
        $ohjaajat = array();
        
        foreach ($rows as $row) {
            $ohjaajat[] = new Ohjaaja(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }
        
        return $ohjaajat;
    }
    
     public static function find($id) {
        $query = DB::connection()
                ->prepare('SELECT * FROM Ohjaaja WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row = $query->fetch();
        
        if($row) {
            $ohjaaja = new Ohjaaja(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }       
        return $ohjaaja;
    }
    
        public static function findNimi($snimi) {
        $query = DB::connection()->prepare('SELECT * FROM Ohjaaja WHERE snimi = :snimi LIMIT 1');
        $query->execute(array('snimi'=>$snimi));
        $row = $query->fetch();
        
        if($row) {
            $ohjaaja = new Ohjaaja(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }       
        return $ohjaaja;
    }
    
        public static function findOhjaajat($aihe) {
        $query = DB::connection()
                ->prepare('SELECT * from Ohjaaja, Aiheen_ohjaaja WHERE Aiheen_ohjaaja.aihe = :aihe AND Aiheen_ohjaaja.ohjaaja = Ohjaaja.id');
        $query->execute(array('aihe' => $aihe));
        $rows = $query->fetchAll();
        $ohajaajat = array();
        
        foreach ($rows as $row) {
            $ohajaajat[] = new Ohjaaja(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }
        
        return $ohajaajat;
    }

}
