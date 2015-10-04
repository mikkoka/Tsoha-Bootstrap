<?php

class Aihe extends BaseModel{
    public $id, $luotu, $luoja, $otsikko, $kuvaus, $tekija_nimi, $opnro, $linkki;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Aihe ORDER BY luotu DESC');
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
    
        public static function ohjaajanAiheet($ohjaaja) {
        $query = DB::connection()->prepare('SELECT Aihe.id AS id, otsikko, luotu FROM Aihe, Aiheen_ohjaaja, Ohjaaja WHERE Ohjaaja.snimi = :snimi AND Aiheen_ohjaaja.aihe = Aihe.id AND Aiheen_ohjaaja.ohjaaja = Ohjaaja.id ORDER BY luotu DESC');
        $query->execute(array('snimi' => $ohjaaja));
        $rows = $query->fetchAll();
        $aiheet = array();
        
        foreach($rows as $row) {
            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'luotu' => $row['luotu'],                
                'otsikko' => $row['otsikko']
                ));
        }
        
        return $aiheet;
    }
    
        public static function alanAiheet($ala) {
        $query = DB::connection()->prepare('SELECT Aihe.id AS id, otsikko, luotu FROM Aihe, Aiheen_luokitus, Tutkimusala WHERE Tutkimusala.nimi = :nimi AND Aiheen_luokitus.aihe = Aihe.id AND Aiheen_luokitus.ala = Tutkimusala.id ORDER BY luotu DESC');
        $query->execute(array('nimi' => $ala));
        $rows = $query->fetchAll();
        $aiheet = array();
        
        foreach($rows as $row) {
            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'luotu' => $row['luotu'],                 
                'otsikko' => $row['otsikko']
                ));
        }
        
        return $aiheet;
    }
    
        public static function ohjaajanAiheetAlalla($ohjaaja, $ala) {
        
        $query = DB::connection()->prepare('SELECT Aihe.id AS id, otsikko, luotu FROM Aihe, Aiheen_ohjaaja, Ohjaaja, Aiheen_luokitus, Tutkimusala WHERE Ohjaaja.snimi = :snimi AND Aiheen_ohjaaja.aihe = Aihe.id AND Aiheen_ohjaaja.ohjaaja = Ohjaaja.id AND Tutkimusala.nimi = :nimi AND Aiheen_luokitus.aihe = Aihe.id AND Aiheen_luokitus.ala = Tutkimusala.id ORDER BY luotu DESC');
        $query->execute(
                array('snimi' => $ohjaaja,
                    'nimi' => $ala));
        $rows = $query->fetchAll();
        $aiheet = array();

        foreach($rows as $row) {
            $aiheet[] = new Aihe(array(
                'id' => $row['id'],
                'luotu' => $row['luotu'], 
                'otsikko' => $row['otsikko']
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
    
    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Aihe (otsikko, kuvaus, tekija_nimi, opnro, luoja, luotu) VALUES (:otsikko, :kuvaus, :tekija_nimi, :opnro, :luoja, NOW()) RETURNING id');
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'tekija_nimi' => $this->tekija_nimi, 'opnro' => $this->opnro, 'luoja' => $this->luoja));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
        public function paivita() {
        $query = DB::connection()->prepare('UPDATE Aihe SET otsikko= :otsikko, kuvaus= :kuvaus, tekija_nimi= :tekija_nimi, opnro= :opnro WHERE id= :id');
        $query->execute(array('otsikko' => $this->otsikko, 'kuvaus' => $this->kuvaus, 'tekija_nimi' => $this->tekija_nimi, 'opnro' => $this->opnro, 'id' => $this->id));
    }
    
    public function poista() {
        $query1 = DB::connection()->prepare('DELETE FROM Aiheen_luokitus WHERE aihe= :id');
        $query1->execute(array('id' => $this->id)); 
        $query2 = DB::connection()->prepare('DELETE FROM Aiheen_ohjaaja WHERE aihe= :id');
        $query2->execute(array('id' => $this->id));  
        $query3 = DB::connection()->prepare('DELETE FROM Edistymistapahtuma WHERE aihe= :id');
        $query3->execute(array('id' => $this->id));  
        $query4 = DB::connection()->prepare('DELETE FROM Aihe WHERE id= :id');
        $query4->execute(array('id' => $this->id));      
    }
}
