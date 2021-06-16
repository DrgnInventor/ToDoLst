<?php
require_once 'php_logic/formValidator.php';
$valid = new Validator();
?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    How important is the task: <input type="range" name="score" min="1" max="3" value="<?php echo $_POST['impScore']?>"><br>
    <br><br>
    What's the deadline? <input type="date" name="deadline" value="<?php echo $_POST['endDate']?>"><br>
    <br><br>
    What do you have to do? <input type="text" name="title" placeholder="To Do" value="<?php echo $_POST['title']?>">
    <?php if($valid->throwErr()[0]){echo $valid->throwErr()[1]; } else {echo $valid->throwErr()[1];}?>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description" value="<?php echo $_POST['description']?>"></textarea>
    <br><br>
    <input type="submit" onclick="<?php $valid->submitUpdatedEntry()?>">
</form>