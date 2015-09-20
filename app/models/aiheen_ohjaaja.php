<?php

class AiheenOhjaaja extends BaseModel {
    public $aihe, $ohjaaja; 
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public function tallenna() {
        $query = DB::connection()->prepare('INSERT INTO Aiheen_ohjaaja (aihe, ohjaaja) VALUES (:aihe, :ohjaaja)');
        $query->execute(array('aihe'=>$this->aihe, 'ohjaaja'=>$this->ohjaaja));
        $row = $query->fetch();
    }
}
    
    

