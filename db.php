<?php
class DataBase {
    private $serverName = "localhost";
    private $userName = "";
    private $passwrd = "";
    private $dbName = "doApp";
    private $sqlFile = "mysql_todos_table.txt";

    public function __construct($serverName, $userName, $passwrd, $dbName, $sqlFile)
    {
        $this->serverName = $serverName;
        $this->userName = $userName;
        $this->passwrd = $passwrd;
        $this->dbName = $dbName;
        $this->sqlFile = $sqlFile;
        $this->createDB();
        $this->connectDb();
        $this->readSqlQuery();
        $this->createTable();

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
        $con = $this->connectDb();
        $con->hostname = $this->dbName;
        if ($con->query($this->readSqlQuery()) === False){
            echo "Error creating table: " . $con->error;
        }
    }

}
?>