<?php
require_once 'db.php';

$data = $_POST['data'];
$data = json_decode($data, true);

if ($data['process'] === "doneButton"){
    $upd = new Update();
    $response = $upd->toDoToggle($data['id']);
    echo $response;
} elseif ($data['process'] === 'editButton'){
    $read = new Read();
    $row = $read->row($data['id']);
    $edit = new Edit($row);
}


?>