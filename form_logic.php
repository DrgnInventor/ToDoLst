<?php
require_once 'db.php';
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$impScore = $endDate = $title = $description = $titleErr ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["score"])){
    $impScore = 2;
  } else {
    $impScore = test_input($_POST["score"]);}

if(empty($_POST["deadline"])){
    $endDate = null;
  } else {
    $endDate = test_input($_POST["deadline"]);
}

if(empty($_POST["title"])){
    $titleErr = "Title of 'To Do' IS REQUIRED";
  } else {
    $title = test_input($_POST["title"]);}
  
if(empty($_POST["description"])){
    $description = null;
  } else {
    $description = test_input($_POST["description"]);
}

if ($titleErr === ""){
    $db = new Send();
    $db->newEntry(False, $impScore, $endDate, $title, $description);
}
}?>

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
    <span class="error">* <?php echo $titleErr;?></span>
    <br><br>
    Additional information about the task: <textarea rows="10" cols="51" name="description" placeholder="To Do Description"></textarea>
    <br><br>
    <input type="submit">
</form>
