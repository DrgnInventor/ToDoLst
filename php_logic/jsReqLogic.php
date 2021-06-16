<?php
require_once 'php_logic/db.php';
$data = $_PHP['data'];
$data = json_decode($data, true);
if ($data['process'] === "doneButton"){
    $upd = new Update();
    echo  $upd->toDoToggle($data['id'], $data['isDone']);
} elseif ($data['process'] === 'editButton'){
    $read = new Read();
    $row = $read->row($data['id']);
    $edit = new Edit($row);
}


?>