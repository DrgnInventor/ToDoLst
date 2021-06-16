<?php
require_once 'php_logic/formValidator.php';
require_once 'php_logic/edit.php';
$valid = new Validator();
$edit = new Edit($_GET['id']);
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
    How important is the task: <input type="range" name="score" min="1" max="3" value="<?php echo $edit->impScore?>"><br>
    <br><br>
    What's the deadline? <input type="date" name="deadline" value="<?php echo $edit->endDate?>"><br>
    <br><br>
    What do you have to do? <input type="text" name="title" placeholder="To Do" value="<?php echo $edit->title?>">
    <?php $edit->throwError()?>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description" ><?php echo $edit->description?></textarea>
    <br><br>
    <input type="submit" onclick="<?php $edit->submitUpdatedEntry()?>">
</form>