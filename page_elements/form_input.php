<?php
require 'php_logic/formValidator.php';
$valid = new Validator();
?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    How important is the task: <input type="range" name="score" min="1" max="3"><br>
    <br><br>
    What's the deadline? <input type="date" name="deadline"><br>
    <br><br>
    What do you have to do? <input type="text" name="title" placeholder="To Do">
    <?php if($valid->throwErr()[0]){echo $valid->throwErr()[1]; } else {echo $valid->throwErr()[1];}?>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description"></textarea>
    <br><br>
    <input type="submit" onclick="<?php $valid->submitEntry()?>">
</form>