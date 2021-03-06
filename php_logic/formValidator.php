<?php
/**
 * USED
 * 
 * INTENTION
 * Intention was to use this for form entry validation in a OOP style thus having more control over the parts of it and more reusable code
 * PROBLEM
 * I don't know how to implement it into the form as it as it throws out errors, possible that the problem arises from the url validation used for stopping possible XSS attacks where js is added in the url
 * Aditionally it could be a problem that it runs it before it has been submited have to look at it later - Drgn 1:46pm
 * 
 * FIXED IT LETS GOOOOO, turns out I just forgot to define vars lol. -Drgn 3:07pm
 * 
 * @param Validator Used to verify form
 * Public methods: testTitle($title) Used in edit.php to validate if title has been entered ot not.
 *                 throwErr() Checks if Title is enteredif not throws out error if entered passes a succes message.
 *                 submitEntry() If no error thrown adds entry to dB
 *                 submitUpdatedEntry() If no error updates/edits todo entry
 */

class Validator{

    public $score;
    public $endDate;
    public $title;
    public $description;
    public $titleErr;

    //Initializes main variables that get passed back to the Db
    function __construct()
    {
        require_once 'php_logic/db.php';
        $this->id ="";
        $this->isDone="";
        $this->score = "";
        $this->endDate = "";
        $this->title = "";
        $this->description = "";
        $this->send = new Send();
        $this->update = new Update();
        $this->read = new Read();
        $this->errorThrown = false;
    }

    //Sanitizes input
    private function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    //Checks if input data is empty
    public function verifyInput($data){
        if(empty($data)){
            return null;
        } else {
            return $this->test_input($data);
        }
    }

    //Checks if data is emppty or not if not then it gets sanitized
    private function validateInputs(){
        if (isset($_POST["score"])&&isset($_POST["deadline"])&&isset($_POST["title"])&&isset($_POST["description"])){
            if(isset($_POST["id"])){
                $this->id = $this->verifyInput($_POST["id"]);
                $this->isDone = $this->read->row($this->id)[1];
            }
            $this->score = $this->verifyInput($_POST["score"]);
            $this->endDate = $this->verifyInput($_POST["deadline"]);
            $this->title = $this->verifyInput($_POST["title"]);
            $this->description = $this->verifyInput($_POST["description"]);
            return true;
        } else {
            return false;
        }
    }

    //Error message if Title has not been filled
    public function testTitle($title){   
        if ($title === null){
            return [True, "<span class=\"error\">* Required field</span>"];
        } else {
            return [False, "<span class=\"success\"> Entry added succesfully!</span>"];
        }
    }

    //Checks if title has been entered, if not throws error field
    public function throwErr(){
        
        if ($this->validateInputs()){    
            $check = $this->testTitle($this->title);
            $this->errorThrown = $check[0];
            return $check;

        } else {
            $this->errorThrown = true;
            return [True, "<span class=\"error\">* Required field</span>"];
        }
    }

    //Reset objects values
    private function resetEntries(){
        $this->id = $this->isDone = $this->score = $this->endDate = $this->title = $this->description = null; 
    }

    //Adds a new entry to the Db
    public function submitEntry(){
        $this->validateInputs();
        if (!$this->errorThrown){
            $this->send->newEntry(False, $this->score, $this->endDate, $this->title, $this->description);
            $this->resetEntries();
        } else {
            echo "Entry cant be submited";
        }
    }

    //Updates existing entry with new data
    public function submitUpdatedEntry(){
        $this->validateInputs();
        if (!$this->errorThrown){
            $this->update->editEntry($this->id, $this->isDone, $this->score, $this->endDate, $this->title, $this->description);
        } else {
            echo "Entry cant be submited";
        }
    }
}?>