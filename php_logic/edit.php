<?php
class Edit{

    function __construct($id)
    {
        $this->read = new Read();
        $this->row = $this->read->row($id);

        $this->valid = new Validator();
        
        $this->errorThrown = false;

        $this->id = $this->row[0];
        $this->isDone =$this->row[1];
        $this->impScore = $this->row[2];
        $this->endDate = $this->row[3];
        $this->title = $this->row[4];
        $this->description = $this->row[5];

    }

    private function validateInputs(){
        $this->id = $this->valid->verifyInput($this->id);
        $this->isDone = $this->valid->verifyInput($this->isDone);
        $this->impScore = $this->valid->verifyInput($this->endDate);
        $this->endDate = $this->valid->verifyInput($this->endDate);
        $this->title = $this->valid->verifyInput($this->title);
        $this->description = $this->valid->verifyInput($this->description);
        return true;
    }
    public function throwError(){ //DUMB CODE SHOULD FIX, unesesary check as validate inputs always returns True.
        if($this->validateInputs()){
            $check = $this->valid->testTitle($this->title);
            $this->errorThrown = $check[0];
            return $check[1];
        }
    }
        //Updates entry
    public function submitUpdatedEntry(){
        $this->validateInputs();
        if (!$this->errorThrown){
            $this->send->editEntry($this->id, $this->impScore, $this->score, $this->endDate, $this->title, $this->description);
        } else {
            echo "Entry cant be submited";
        }
    }
}
?>