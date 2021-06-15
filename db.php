<?php
class DataBase {

    public function __construct()
    {
        $this->serverName = "localhost";
        $this->userName = "";
        $this->passwrd = "";
        $this->dbName = "doApp";
        $this->sqlFile = "mysql_todos_table.txt";
    }

    public function conDb(){
        $connect = new mysqli($this->serverName, $this->userName, $this->passwrd, $this->dbName);
        if ($connect -> connect_error) {
            die("Connection failed: " . $connect->connect_error);
            }  
        return $connect;
    }

    private function connectDb(){
        $connect = new mysqli($this->serverName, $this->userName, $this->passwrd);
        if ($connect -> connect_error) {
            die("Connection failed: " . $connect->connect_error);
            }  
        return $connect;
    }
    
    private function createDB(){
        $con = $this->connectDb();
        $sqlDB = "CREATE DATABASE IF NOT EXISTS $this->dbName";
        if ($con->query($sqlDB) === false) {
            echo "Error creating database: " . $con->connect_error;
        }
    }

    private function readSqlQuery(){
        $fContent = fopen($this->sqlFile, 'r');
        $sql = fread($fContent, filesize($this->sqlFile));
        fclose($fContent);
        return $sql;
    }

    private function createTable(){
        $con = $this->conDb();
        $con->hostname = $this->dbName;
        if ($con->query($this->readSqlQuery()) === False){
            echo "Error creating table: " . $con->error;
        }
    }
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
        $this->table = $this->readTable();
    }
    private function readTable(){
        $sql = "SELECT id, IsDone, ImpScore, EndDate, Title, Description FROM ToDos";
        $table = $this->con->query($sql);
        return $table;
    }
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
    private function sqlToggle($id, $class){
        switch($class){
            case "IsDoneF";
            return "UPDATE doApp SET IsDone = 1 WHERE Id = $id";
            case "IsDone";
            return "UPDATE doApp SET IsDone = 0 WHERE Id = $id";
        }
    }
    public function toDoCompleted($id, $class){
        $sql = $this->sqlToggle($id,$class);
        if ($this->con->query($sql) === True){
            echo "New entry added";
        } else {
            echo "Shit broke: " . $sql . "<br>" . $this->con->error;
        }
    }
}
?>