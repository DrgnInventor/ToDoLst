<?php
/**
 * @param Container class used for todo entry creation
 * Public methods: generateEntries($mode) creates entry from db data and echos it out. 
 * $mode refers to which entries to return 
 * $mode = 0 returns uncompleted tasks
 * $mode = 1 returns completed tasks
 * $mode = 2 returns all tasks
 * 
 */

class Container{
    
    public $rowsArr;

    function __construct()
    {   
        require_once 'db.php';
        $this->reader = new Read();
        $this->rowsArr = $this->reader->rowsData();
    }

    // BUG end date earlier than star date return positive int.
    
    //Calculates days till endDate from todo entry, takes current date to compare against.
    // Returns null if date not given.
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

    //Creates body div of todo entry Holds title and description. Returns string.
    private function createBody($title, $description){
    return         '<div class="todoGrid" id="todoBody">
                        <div class = "Title">'.$title.'</div>
                        <div class = "Description">'.$description.'</div>
                    </div>';
    }

    //Creates button div of todo entry Holds 3 buttons => Done, Edit, Delete. Returns string.
    private function createButtons($id, $isDone){
        if ($isDone === "0"){
            $Done = "IsDoneF";
        } else {
            $Done = "IsDone";
        }
        return '<div class="todoGrid" id="LeftButtons">
                    <div class = "DoneButton">
                        <input type="button" id="'.$id.'B" class="'.$Done.'" onclick="toDoToggle('.$id.')" value="Done">
                    </div>
                    <div class = "EditButton">
                        <a href="editTasks.php?id='.$id.'">
                            <button>Edit</button>
                        </a>
                    </div>
                    <div class = "DeleteButton">
                        <input type="button" id="'.$id.'D" class="'.$Done.'" onclick="deleteEntry('.$id.')" value="Delete">
                    </div>
                </div>';
    }

    //Creates div holding info about how many days left until the deadline. If no date given left empty. Returns string.
    private function daysLeft($date){
        $days = $this->daysTillDue($date);
        if ($days !== null) {
            return '<div class="todoGrid" id="Days">Days left: '.$days.'</div>';
        } else {
            return '<div name = "daysLeft"></div>';

        }
    }

    //Constructs final div adding relevant information together. Echos out the html.
    private function createEntry($id, $isDone, $impScore, $date, $title, $description){
        echo '<div id = "imp'.$impScore.'" class = "todo" name="'.$id.'">'.
        $this->createButtons($id, $isDone).
        $this->createBody($title, $description).
        $this->daysLeft($date).'
        </div>';
    }

    //Used for generating all entries in the db. Uses $mode var to control which entries need to be printed out.
    public function generateEntries($mode){
        //mode refers to entries isDone attribute
        // 0: Not Completed
        // 1: Completed
        // 2: All
        foreach($this->rowsArr as $row){
            //possible improvement use switch case
            if ($mode === 0){
                if ($row[1] == 0){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                }
            } elseif ($mode === 1){
                if ($row[1] == 1){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                } 
            } elseif ($mode === 2) {
                if ($row[1] == 2){
                    $this->createEntry($row[0],$row[1],$row[2],$row[3],$row[4],$row[5]);
                } 
            } else {
                echo '<p class="error">Something broke when generating entries.</p>';
            }
        }
    }
}

?>