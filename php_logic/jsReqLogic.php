<?php
require_once 'db.php';

$data = $_POST['data'];
$data = json_decode($data, true);
$upd = new Update();

//Used for procesing jquery requests. AJAX
//proocess refers to which button has been pressed.
/* doneButton changes todo entries isDone state
*  deleteButton deletes the entry if possible from the db
*/ 

if ($data['process'] === "doneButton"){
    $response = $upd->toDoToggle($data['id']);
    echo $response;
} elseif ($data['process'] === 'deleteButton'){ 
    echo $upd->deleteEntry($data['id']);
}
?>