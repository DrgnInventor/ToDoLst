<?php
require_once 'db.php';

$data = $_POST['data'];
$data = json_decode($data, true);
$upd = new Update();

if ($data['process'] === "doneButton"){
    $response = $upd->toDoToggle($data['id']);
    echo $response;
} elseif ($data['process'] === 'deleteButton'){ 
    echo $upd->deleteEntry($data['id']);
}
?>