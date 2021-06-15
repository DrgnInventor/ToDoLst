<?php
$serverName = "localhost";
$userName = "";
$passwrd = "";
$dbName = "doApp";

//Establish connection to mysql server
$connect = new mysqli($serverName, $userName, $passwrd);
if ($connect -> connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

//Create DATABASE doApp
$sqlDB = "CREATE DATABASE IF NOT EXISTS $dbName";
if ($connect->query($sqlDB) === false) {
    echo "Error creating database: " . $connect->connect_error;
} elseif ($connect->query($sqlDB) === true){
    echo "Database Created ";
} else {
    echo "Something broke ";
}

$connect = new mysqli($serverName, $userName, $passwrd, $dbName);
if ($connect -> connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

//Reads sql querys from txt file
$sqlFile = 'mysql_todos_table.txt';

$fContent = fopen($sqlFile, 'r');
$sql = fread($fContent, filesize($sqlFile));
fclose($fContent);

//Creates table
if ($connect->query($sql) === False){
    echo "Error creating table: " . $connect->error;
}

mysqli_close($connect);
?>