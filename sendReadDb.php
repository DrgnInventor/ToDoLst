<?php
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
                $rowArray = array($row["id"], $row["IsDone"], $row["ImpScore"], $row["EndDate"], $row["Title"], $row["Description"]);
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
?>