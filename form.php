<?php require_once 'formValidator.php'; $valid = new Validator(); $error = null;?>

<style>
    .error {color: #FF0000;}
</style>

<p><span class="error">* required field</span></p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    How important is the task: <input type="range" name="score" min="1" max="3"><br>
    <br><br>
    What's the deadline? <input type="date" name="deadline"><br>
    <br><br>
    What do you have to do? <input type="text" name="title" placeholder="To Do">
    <span class="error">* <?php echo $error;?></span>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description"></textarea>
    <br><br>
    <input type="submit" onsubmit="<?php 
        $valid->validateInputs();
        if ($valid->throwErr()==="ERROR: Empty field."){
        $error = $valid->throwErr(); 
        }else{
        $valid->submitEntry();
        }?>">
</form>
