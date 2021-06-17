<?php
/**
 * @param Database Initializes database if there is none allready. Creates the db then table 
 * Only public methods: conDb() Connect to the databases table 
 * @param Send Adds new entries to the Db.
 * Public methods: newEntry($isDone, $impScore, $endDate, $title, $description)
 *      @param isDone Determines has the Task been done. !Rather than deleting tasks store them in a seperate page to see what has allready been finished!
 *      @param impScore Score to determine which tasks are more urgent. !Used for styling diferentiate important tasks from less important ones!
 *      @param endDate Todo deadline !Used to calculate how many days left using local time, Styling.!
 *      @param title Name of the todo !Possible use have it only show title and expand into a description when clicked or hover!
 *      @param description More information about the todo !For now shows with title, TODO implement it as a hidden element!
 * @param Read Reads Db entries.
 * Public methods: rowsData() returns the table rows in a array => [[row1], [row2], [row3]... ,[rown]]
 * @param Update Updates Db entries
 * Public methods: toDoToggle() updates the entries isDone entry to the opposite. Can be used to both make todo finished or unfinished
 */
class DataBase {

    public function __construct()
    {
        $this->serverName = "localhost";
        $this->userName = "";
        $this->passwrd = "";
        $this->dbName = "doApp";
        $this->sqlFile = "php_logic/mysql_todos_table.txt"; //Sql querys to create todos table
    }

    //Public function when a connection to the table is needed
    public function conDb(){
        $connect = new mysqli($this->serverName, $this->userName, $this->passwrd, $this->dbName);
        if ($connect -> connect_error) {
            die("Connection failed: " . $connect->connect_error);
            }  
        return $connect;
    }

    //Db creation connection
    private function connectDb(){
        $connect = new mysqli($this->serverName, $this->userName, $this->passwrd);
        if ($connect -> connect_error) {
            die("Connection failed: " . $connect->connect_error);
            }  
        return $connect;
    }
    
    //Creates Db, Creates if there isnt one allready
    private function createDB(){
        $con = $this->connectDb();
        $sqlDB = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        if ($con->query($sqlDB) === false) {
            echo "Error creating database: " . $con->connect_error;
        }
    }

    //Read Sql querys for table creation. Returns string of sql querys
    private function readSqlQuery(){
        $fContent = fopen($this->sqlFile, 'r');
        $sql = fread($fContent, filesize($this->sqlFile));
        fclose($fContent);
        return $sql;
    }

    //Creates table from returned sql querys
    private function createTable(){
        $con = $this->conDb();
        if ($con->query($this->readSqlQuery()) === False){
            echo "Error creating table: " . $con->error;
        }
    }

    //Initializes Database
    public function initDb(){
        $this->createDB();
        $this->readSqlQuery();
        $this->createTable();
    }

}

class Read {
    public $table;
    
    public function __construct(){
        $this->db = new DataBase();
        $this->con = $this->db->conDb();
    }
    
    //Reads db Table and return it as an array
    private function readTable(){
        $sql = "SELECT * FROM ToDos";
        $table = $this->con->query($sql);
        return $table;
    }

    //Returns table as an array where each index hold an array of row data. [[row1], [row2], [row3],....,[rown]]
    public function rowsData(){
        $table = $this->readTable();
        $todos = array();
        while($row = mysqli_fetch_assoc($table)) {
            $rowArray = array($row["Id"], $row["IsDone"], $row["ImpScore"], $row["EndDate"], $row["Title"], $row["Description"]);
            array_push($todos, $rowArray);
            }
        return $todos;
    }

    //Find specific row
    public function row($id){
        $todos = $this->rowsData();
        for ($i = 0; $i < sizeof($todos); $i++){
            if ($todos[$i][0] == $id){
                return $todos[$i];
            }
        }
    }
}

class Send {

    public function __construct()
    {
        $this->db = new DataBase();
        $this->con = $this->db->conDb();
    }

    //Adds new entry to the table. !!Possible optimization remove $isDone as new entries always are not done, unless xtra functionality when adding entry specify its allready been done
    //Use case being keeping track of what has been done as the entries don't get deleted when completed
    public function newEntry($isDone, $impScore, $endDate, $title, $description){
        $sql = "INSERT INTO ToDos (IsDone, ImpScore, EndDate, Title, Description)
        VALUES ('$isDone', '$impScore', '$endDate', '$title', '$description')";
        if ($this->con->query($sql) === True){
            echo "New entry added";
        } else {
            echo "NewEntry broke: " . $sql . "<br>" . $this->con->error;
        }
    }
}

class Update {

    private $status;

    public function __construct()
    {
        $this->db = new DataBase();
        $this->con = $this->db->conDb();
    }
    
    //returns sql which toggles between 1 and 0 for isDone colum, used to change status of ToDos
    private function sqlToggle($id, $isDoneStatus){
        $sql0 = "UPDATE `todos` SET `IsDone` = '0' WHERE `todos`.`Id` = ".$id."; ";
        $sql1 = "UPDATE `todos` SET `IsDone` = '1' WHERE `todos`.`Id` = ".$id."; ";
        if ($isDoneStatus == 0){
            return [1, $sql1];
        }elseif($isDoneStatus == 1){
            return [0, $sql0];
        }else {
            return [-1, "SELECT * WHERE todos"];
        }
    }

    //Uses returned sql to toggle the value
    public function toDoToggle($id){
        $read = new Read();
        $status = $read->row($id)[1];

        $sql = $this->sqlToggle($id, $status);

        if ($this->con->query($sql[1]) === True){
            return $sql[0];
        } else {
            echo "Toggle broke: " . $sql[1] . "<br>" . $this->con->error ." <br>";
        }
    }

    //Creates sql query to edit entry
    private function sqlEdit($id, $isDone, $impScore, $endDate, $title, $description){
        return "UPDATE `todos` SET `IsDone` = '".$isDone."', `ImpScore` = '".$impScore."', `EndDate` = '".$endDate."', `Title` = '".$title."', `Description` = '".$description."' WHERE `todos`.`Id` = '".$id."'; ";
    }

    //Edits entry in db
    public function editEntry($id, $isDone, $impScore, $endDate, $title, $description){
        $sql = $this->sqlEdit($id, $isDone, $impScore, $endDate, $title, $description);
        if ($this->con->query($sql) === True){
            echo "Entry Updated";
        } else {
            echo "Edit broke: " . $sql . "<br>" . $this->con->error;
        }
    }
    
    //Creates swl query to delete entry from db
    private function deleteSql($id){
        return "DELETE FROM `todos` WHERE `todos`.`Id` = ".$id." ";
    }

    //Deletes todo entry from db
    public function deleteEntry($id){
        $sql = $this->deleteSql($id);
        if ($this->con->query($sql) === True){
            echo true;
        } else {
            echo "Delete broke: " . $sql . "<br>" . $this->con->error;
        }
    }
}
?>