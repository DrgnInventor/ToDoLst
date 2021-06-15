<?php
$serverName = "localhost";
$userName = "username";
$passwrd = "password";

//Establish connection to mysql server
$connect = new mysqli($serverName, $userName, $passwrd);
if ($connect -> connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

//Create DATABASE doApp
$sqlDB = "CREATE DATABASE doApp";
if ($connect->query($sqlDB) === False) {
    echo "Error creating database: " . $connect->connect_error;
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