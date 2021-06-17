<?php
require 'php_logic/formValidator.php';
$valid = new Validator();
?>
<link rel="stylesheet" type="text/css" href="page_elements/formStyle.css">
<section>
    <form class="addForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        How important is the task: <input class="inputImpScore" type="range" name="score" min="1" max="3"><br>
        <br><br>
        What's the deadline? <input class="inputDate" type="date" name="deadline"><br>
        <br><br>
        What do you have to do? <?php if($valid->throwErr()[0]){echo $valid->throwErr()[1]; } else {echo $valid->throwErr()[1];}?>
        <input class="inputTitle" type="text" name="title" placeholder="To Do">
        
        <br><br>
        Additional information about the task: <textarea class="inputDescription" rows="10" cols="51" name="description" placeholder="To Do Description"></textarea>
        <br><br>
        <input class="addFormButton" type="submit" onclick="<?php $valid->submitEntry()?>">
    </form>
</section>