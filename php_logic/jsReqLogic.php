<?php
require_once 'php_logic/db.php';
$data = $_PHP['data'];
$data = json_decode($data, true);
if ($data['process'] === "doneButton"){
    $upd = new Update();
    return  $upd->toDoToggle($data['id'], $data['isDone']);
}


?>