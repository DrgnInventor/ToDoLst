<?php
class DataBase {

    public function __construct()
    {
        $this->serverName = "localhost";
        $this->userName = "";
        $this->passwrd = "";
        $this->dbName = "doApp";
        $this->sqlFile = "mysql_todos_table.txt";
        $this->createDB();
        $this->connectDb();
        $this->readSqlQuery();
        $this->createTable();

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
        $con = $this->connectDb();
        $con->hostname = $this->dbName;
        if ($con->query($this->readSqlQuery()) === False){
            echo "Error creating table: " . $con->error;
        }
    }

}

?>