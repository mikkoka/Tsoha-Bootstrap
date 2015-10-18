<?php

class Supervisor extends BaseModel {
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
            $ohjaajat[] = new Supervisor(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }
        
        return $ohjaajat;
    }
    
    public static function familynames() {
        $query = DB::connection()->prepare('SELECT snimi from Ohjaaja');
        $query->execute();
        $rows = $query->fetchAll();
        $ohjaajat = array();
        
        foreach ($rows as $row) {
            $ohjaajat[] = new Supervisor(Array(
                'snimi' => $row['snimi']
            ));
        }
        
        return $ohjaajat;
    }
    
    public static function authenticate($sposti, $salasana) {
        $query = DB::connection()->prepare('SELECT * FROM Ohjaaja WHERE sposti = :sposti AND salasana = :salasana LIMIT 1');                 
        $query->execute(array('sposti' => $sposti, 'salasana' => $salasana));
        $row = $query->fetch();
        if ($row) {
            $ohjaaja = new Supervisor(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        } else {
            $ohjaaja = null;
        }
        return $ohjaaja; 
    }

    public static function find($id) {
        $query = DB::connection()
                ->prepare('SELECT * FROM Ohjaaja WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row = $query->fetch();
        
        if($row) {
            $ohjaaja = new Supervisor(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }       
        return $ohjaaja;
    }
    
        public static function findCreator($aihe) {
        $query = DB::connection()
                ->prepare('SELECT enimi, snimi, Ohjaaja.id FROM Ohjaaja, Aihe WHERE Aihe.id = :aihe AND Ohjaaja.id=Aihe.luoja LIMIT 1');
        $query->execute(array('aihe'=>$aihe));
        $row = $query->fetch();
        
        if($row) {
            $ohjaaja = new Supervisor(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
            ));
        } else { $ohjaaja = null;}      
        return $ohjaaja;
    }
    
    
        public static function findName($snimi) {
        $query = DB::connection()->prepare('SELECT * FROM Ohjaaja WHERE snimi = :snimi LIMIT 1');
        $query->execute(array('snimi'=>$snimi));
        $row = $query->fetch();
        
        if($row) {
            $ohjaaja = new Supervisor(Array(
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
            $ohajaajat[] = new Supervisor(Array(
                'id' => $row['id'],
                'enimi' => $row['enimi'],
                'snimi' => $row['snimi'],
                'salasana' => $row['salasana'],
                'sposti' => $row['sposti'],
            ));
        }
        
        return $ohajaajat;
    }
    
        public function create() {
        $query = DB::connection()->prepare('INSERT INTO Ohjaaja (snimi, enimi, sposti, salasana) VALUES (:snimi, :enimi, :sposti, :salasana)');
        $query->execute(array('snimi' => $this->snimi, 'enimi' => $this->enimi, 'sposti' => $this->sposti, 'salasana' => $this->salasana));
        $row = $query->fetch();

    }

}
