<?php
class Container{
    
    public $rowsArr;

    function __construct()
    {   
        require_once 'db.php';
        $this->reader = new Read();
        $this->rowsArr = $this->reader->rowsData();
    }

    // @TODO fix to show negative days, breaks if the end date is before start.
    private function daysTillDue($date){ 
        if ($date !== null || $date !== "0000-00-00"){ 
            $start_date = new DateTime(date("Y-m-d"));
            $end_date = new DateTime($date);
            $days = $start_date->diff($end_date)->format('%d');
            return $days;
        }
        else {
            return null;
        }
    }
    private function createBody($title, $description){
    return         '<div name = "body">
                        <p name = "Title">'.$title.'</p>
                        <p name = "Description">'.$description.'</p>
                    </div>';
    }
    private function createButtons($id, $isDone){
        if ($isDone === "0"){
            $Done = "IsDoneF";
        } else {
            $Done = "IsDone";
        }
        return '<div name = "DoneButton">
                    <input type="button" id="'.$id.'B" class="'.$Done.'" onclick="toDoToggle('.$id.')">
                </div>
                <div name = "EditButton">
                    <button type=“button” id="'.$id.'E">
                        <a href=editTasks.php?id='.$id.'>Edit
                        </a>
                    </button>
                </div>';
    }
    private function daysLeft($date){
        $days = $this->daysTillDue($date);
        if ($days !== null) {
        return '<div name = "daysLeft"> Days left: '.$days.'</div>';
        }
    }
    private function createEntry($id, $isDone, $impScore, $date, $title, $description){
        echo '<div id = "'.$id.'" class = "'.$impScore.'">'.
        $this->createButtons($id, $isDone).
        $this->createBody($title, $description).
        $this->daysLeft($date).'
        </div>';
    }
    public function generateEntries($mode){
        //mode refers to entries isDone attribute
        // 0: Not Completed
        // 1: Completed
        // 2: All
        foreach($this->rowsArr as $row){
            if ($mode === 0){
                if ($row[1] === 0){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                }
            } elseif ($mode === 1){
                if ($row[1] === 1){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                } 
            } elseif ($mode === 2) {
                if ($row[1] === 2){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                } 
            } else {
                echo '<p class="error">Something broke when generating entries.</p>'
            }
        }
    }
}

?>