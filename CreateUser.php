<?php
    $err = null;
    if (array_key_exists("user", $_POST)) {
        if ($_POST["user"] === "") {
            $err = "Username empty";
        }
    } else {
        $err = "Username missing from form";
    }
    $my = new mysqli("mysql.eecs.ku.edu",
                     "zcersovsky",
                     "THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG",
                     "zcersovsky");
    if ($my->connect_errno) {
        $err = "Couldn't connect to database";
    }
    if ($err === null) {
        $username = $my->escape_string($_POST["user"]);
        $query = "INSERT INTO Users (user_id) VALUES (\"{$username}\");";
        if (!$my->query($query)) {
            $err = "Failed to add user to database (Duplicate?)";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php
            if ($err === null) {
                printf("Created user");
            } else {
                printf("Failed to create user");
            }
        ?>
    </title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>
        <?php
            if ($err === null) {
                printf("Created user");
            } else {
                printf("Failed to create user");
            }
        ?>
    </h1>
    <?php
        if ($err != null) {
            printf("<strong>The error was: </strong>%s<br/>", $err);
        }
    ?>
</body>
</html>