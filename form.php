<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <?php 
        //navBar.php required link js and css to page aswell as navigation.
        require_once 'page_elements/navBar.php'
    ?>
</head>
<body>
<br>
    <?php
        //form_input.php required. Form to add new entries to db.
        require 'page_elements/form_input.php'
    ?>
</body>
</html>