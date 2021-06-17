<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do list</title>
    <?php 
        //navBar.php required link js and css to page aswell as navigation.
        require_once "page_elements/navBar.php";
    ?>
</head>
<body>
    <?php 
        //db.php required to initialize the database.
        require_once "php_logic/db.php";
        $db = new DataBase();
        $db->initDb();

        //toDoContainer.php required used to generate a list of uncompleted To Do entries.
        require 'php_logic/toDoContainer.php'; 
        $printer = new Container(); 
        $printer->generateEntries(0);
    ?>
</body>
</html>