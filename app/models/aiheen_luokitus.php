<?php

class AiheenLuokitus extends BaseModel {
    public $aihe, $ala; 
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function tallenna() {

        try {
            $query = DB::connection()->prepare('INSERT INTO Aiheen_luokitus (aihe, ala) VALUES (:aihe, :ala)');
            $query->execute(array('aihe' => $this->aihe, 'ala' => $this->ala));
        } catch (PDOException $error) {
            return false;
        }
    }
    
    public function poista() {

        try {
            $query = DB::connection()->prepare('DELETE FROM Aiheen_luokitus WHERE aihe= :aihe AND ala= :ala');
            $query->execute(array('aihe' => $this->aihe, 'ala' => $this->ala));
        } catch (PDOException $error) {
            return false;
        }
    }

}
