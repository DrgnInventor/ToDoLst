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
        $con->hostname = $this->dbName;
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
    public function __construct(){
        $this->db = new DataBase();
        $this->con = $this->db->conDb();
        $this->table = $this->readTable(); // Holds table array
    }
    
    //Reads db Table and return it as an array
    private function readTable(){
        $sql = "SELECT id, IsDone, ImpScore, EndDate, Title, Description FROM ToDos";
        $table = $this->con->query($sql);
        return $table;
    }

    //Returns table as an array where each index hold an array of row data. [[row1], [row2], [row3],....,[rown]]
    public function rowsData(){
        $todos = array();
        if ($this->table->num_rows < 0){
            while($row = mysqli_fetch_assoc($this->table)) {
                $rowArray = array($row["Id"], $row["IsDone"], $row["ImpScore"], $row["EndDate"], $row["Title"], $row["Description"]);
                $todos.array_push($todos, $rowArray);
              }
        }
        return $todos;
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
            echo "Shit broke: " . $sql . "<br>" . $this->con->error;
        }
    }
}

class Update {
    public function __construct()
    {
        $this->db = new DataBase();
        $this->con = $this->db->conDb();
    }
    
    //returns sql which toggles between 1 and 0 for isDone colum, used to change status of ToDos
    private function sqlToggle($id, $class){
        switch($class){
            case "IsDoneF";
            return [1, "UPDATE doApp SET IsDone = 1 WHERE Id = $id"];
            case "IsDone";
            return [0, "UPDATE doApp SET IsDone = 0 WHERE Id = $id"];
        }
    }

    //Uses returned sql to toggle the value
    public function toDoToggle($id, $class){
        $sql = $this->sqlToggle($id,$class);
        if ($this->con->query($sql[1]) === True){
            echo "New entry added";
            return $sql[0];
        } else {
            echo "Shit broke: " . $sql . "<br>" . $this->con->error;
        }
    }
}
?>