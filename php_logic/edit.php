<?php
class Edit{

    function __construct($id)
    {
        require_once 'php_logic/db.php';

        $this->read = new Read();
        $this->row = $this->read->row($id);

        $this->valid = new Validator();

        $this->errorThrown = false;
     
        $this->id = $this->storeData("id", 0);
        $this->isDone = $this->storeData("isDone", 1);
        $this->impScore = $this->storeData("impScore", 2);
        $this->endDate = $this->storeData("endDate", 3);
        $this->title = $this->storeData("title", 4);
        $this->description = $this->storeData("description", 5);

    }

    //Used to grab entry data, uses post if set if not get. Returns vars value.
    private function storeData($name, $index){
        if (isset($_POST[$name])){
            return $_POST[$name];
        } else {
            return $this->row[$index];}
    }

    //Used to sanitize entries, Uses formValidator code.
    private function validateInputs(){
        $this->id = $this->valid->verifyInput($this->id);
        $this->isDone = $this->valid->verifyInput($this->isDone);
        $this->impScore = $this->valid->verifyInput($this->endDate);
        $this->endDate = $this->valid->verifyInput($this->endDate);
        $this->title = $this->valid->verifyInput($this->title);
        $this->description = $this->valid->verifyInput($this->description);
        return true;
    }

    //Used to throw error in edit form, diferent from formValidator as the form is prefilled with entrys from db.
    //IMPROVEMENT TODO: Add succes message
    public function throwError(){ //DUMB CODE SHOULD FIX, unesesary check as validate inputs always returns True.
        if($this->validateInputs()){
            $check = $this->valid->testTitle($this->title);
            $this->errorThrown = $check[0];
            if(!$this->errorThrown){
                return "<span class=\"error\"> *</span>";
            }else{
                return $check[1];
            }
        }
    }
}
?>