<?php

class Aihe extends BaseModel{
    public $id, $luotu, $luoja, $otsikko, $kuvaus, $tekija_nimi, $opnro, $linkki;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Aihe');
        $query->execute();
        $rows = $query->fetchAll();
        $aiheet = array();
        
        foreach($rows as $row) {
            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'luotu' => $row['luotu'],
                'luoja' => $row['luoja'],
                'otsikko' => $row['otsikko'],
                'kuvaus' => $row['kuvaus'],
                'tekija_nimi' => $row['tekija_nimi'],
                'opnro' => $row['opnro'],
                'linkki' => $row['linkki']
                ));
        }
        
        return $aiheet;
    }
    
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Aihe WHERE id = :id LIMIT 1');
        $query->execute(array('id'=>$id));
        $row = $query->fetch();
        
        if($row) {
            $aihe = new Aihe(array(
                'id' => $row['id'],
                'luotu' => $row['luotu'],
                'luoja' => $row['luoja'],
                'otsikko' => $row['otsikko'],
                'kuvaus' => $row['kuvaus'],
                'tekija_nimi' => $row['tekija_nimi'],
                'opnro' => $row['opnro'],
                'linkki' => $row['linkki']     
            ));
            
            return $aihe;
        }
        
        return null;
    }
}

