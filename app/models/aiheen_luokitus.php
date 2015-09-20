<?php

class AiheenLuokitus extends BaseModel {
    public $aihe, $ala; 
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Aiheen_luokitus (aihe, ala) VALUES (:aihe, :ala)');
        $query->execute(array('aihe'=>$this->aihe, 'ala'=>$this->ala));
        $row = $query->fetch();
    }
}
