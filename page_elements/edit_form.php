<?php
require 'php_logic/formValidator.php';
require 'php_logic/edit.php';
$valid = new Validator();
if (isset($_GET['id'])) {
    $edit = new Edit($_GET['id']);
} else {$edit = new Edit($_POST['id']);};

?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    <input type="hidden" name="id" value="<?php echo $edit->id?>"></input>
    <input type="hidden" name="isDone" value="<?php echo $edit->isDone?>"></input>
    How important is the task: <input type="range" name="score" min="1" max="3" value="<?php echo $edit->impScore?>"><br>
    <br><br>
    What's the deadline? <input type="date" name="deadline" value="<?php echo $edit->endDate?>"><br>
    <br><br>
    What do you have to do? <input type="text" name="title" placeholder="To Do" value="<?php echo $edit->title?>">
    <?php echo $edit->throwError();?>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description"><?php echo $edit->description?></textarea>
    <br><br>
    <input type="submit" onclick="<?php $valid->submitUpdatedEntry()?>">
</form>