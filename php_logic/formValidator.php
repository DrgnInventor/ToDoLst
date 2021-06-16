<?php

/**
 * NOT USED
 * 
 * INTENTION
 * Intention was to use this for form entry validation in a OOP style thus having more control over the parts of it and more reusable code
 * PROBLEM
 * I don't know how to implement it into the form as it as it throws out errors, possible that the problem arises from the url validation used for stopping possible XSS attacks where js is added in the url
 * Aditionally it could be a problem that it runs it before it has been submited have to look at it later - Drgn 1:46pm
 */

class Validator{
    
    //Initializes main variables that get passed back to the Db
    public function __construct()
    {
        $this->score = "";
        $this->endDate = "";
        $this->title = "";
        $this->description = "";
        
    }

    //Sanitized input
    private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Checks if input data is empty
    private function verifyInput($data){
        if(empty($data)){
            return null;
        } else {
            return $this->test_input($data);
        }
    }

    //Checks if data is emppty or not if not then it gets sanitized
    public function validateInputs(){
        $this->score = $this->verifyInput($_POST["score"]);
        $this->endDate = $this->verifyInput($_POST["deadline"]);
        $this->title = $this->verifyInput($_POST["title"]);
        $this->description = $this->verifyInput($_POST["description"]);
    }

    //Error message if Title has not been filled
    public function throwErr(){
        if ($this->title === null){
            return "ERROR: Empty field.";
        }
    }

    //Adds a new entry to the Db
    public function submitEntry(){
        if (!$this->throwErr() === "ERROR: Empty field."){
            $db = new Send();
            $db->newEntry(False, $this->score, $this->endDate, $this->title, $this->description);
        }
    }
}?>