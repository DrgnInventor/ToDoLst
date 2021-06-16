<?php
require_once 'db.php';
class Container{
    function __construct()
    {
        $this->reader = new Read();
        $this->rowsArr = $this->reader->rowsData();
        $this->rows = count($this->rowsArr);
    }

    private function daysTillDue($date){
        $start_date = new DateTime(date("Y-m-d"));
        $end_date = new DateTime($date);
        $days = $start_date->diff($end_date);
        return $days;
    }
    private function createElement(){

    }

}

?>