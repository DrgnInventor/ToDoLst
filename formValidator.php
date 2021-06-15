<?php
class Validator{
    
    public function __construct()
    {
        $this->score = "";
        $this->endDate = "";
        $this->title = "";
        $this->description = "";
        
    }
    private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    private function verifyInput($data){
        if(empty($data)){
            return null;
        } else {
            return $this->test_input($data);
        }
    }
    public function validateInputs(){
        $this->score = $this->verifyInput($_POST["score"]);
        $this->endDate = $this->verifyInput($_POST["deadline"]);
        $this->title = $this->verifyInput($_POST["title"]);
        $this->description = $this->verifyInput($_POST["description"]);
    }
    public function throwErr(){
        if ($this->title === null){
            return "ERROR: Empty field.";
        } else {
            return "";
        }
    }
    public function submitEntry(){
        if ($this->throwErr() === ""){
            $db = new Send();
            $db->newEntry(False, $this->score, $this->endDate, $this->title, $this->description);
        }
    }
}?>