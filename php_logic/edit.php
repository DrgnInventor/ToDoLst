<?php
class Edit{

    function __construct($row)
    {
    $this->id = $row[0];
    $this->isDone = $row[1];
    $this->impScore = $row[2];
    $this->endDate = $row[3];
    $this->title = $row[4];
    $this->description = $row[5];
    }
    
    public function sendData(){
        
    }

}
?>