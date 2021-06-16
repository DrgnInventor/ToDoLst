<?php
require_once 'db.php';
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$impScore = $endDate = $title = $description = $titleErr ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["score"])){
    $impScore = 2;
  } else {
    $impScore = test_input($_POST["score"]);}

if(empty($_POST["deadline"])){
    $endDate = null;
  } else {
    $endDate = test_input($_POST["deadline"]);
}

if(empty($_POST["title"])){
    $titleErr = "Title of 'To Do' IS REQUIRED";
  } else {
    $title = test_input($_POST["title"]);}
  
if(empty($_POST["description"])){
    $description = null;
  } else {
    $description = test_input($_POST["description"]);
}

if ($titleErr === ""){
    $db = new Send();
    $db->newEntry(False, $impScore, $endDate, $title, $description);
}
}?>