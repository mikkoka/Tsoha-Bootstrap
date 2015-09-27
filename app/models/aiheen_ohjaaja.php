<?php

class AiheenOhjaaja extends BaseModel {
    public $aihe, $ohjaaja; 
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function tallenna() {
        
        try {
            $query = DB::connection()->prepare('INSERT INTO Aiheen_ohjaaja (aihe, ohjaaja) VALUES (:aihe, :ohjaaja)');
            $query->execute(array('aihe' => $this->aihe, 'ohjaaja' => $this->ohjaaja));
        } catch (PDOException $error) {
            return false;
//            Kint::dump($error);
//            die();
        }
    }
    
    public function poista() {

        try {
            $query = DB::connection()->prepare('DELETE FROM Aiheen_ohjaaja WHERE aihe= :aihe AND ohjaaja= :ohjaaja');
            $query->execute(array('aihe' => $this->aihe, 'ohjaaja' => $this->ohjaaja));
        } catch (PDOException $error) {
            echo $e->getMessage();
            die();
        }
    }

}
