<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        require_once "page_elements/navBar.php";

    ?>
</head>
<body>
    <?php 
        require "php_logic/db.php";
        $db = new DataBase();
        $db->initDb();
        require 'php_logic/toDoContainer.php'; 
        $printer = new Container(); 
        $printer->generateEntries(0);
    ?>
</body>
</html>