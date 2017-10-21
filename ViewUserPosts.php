<?php
    $errorMessages = array();
    $my = new mysqli("mysql.eecs.ku.edu",
                     "zcersovsky",
                     "THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG",
                     "zcersovsky");
    if ($my->connect_errno) {
        $errorMessages[] = "Couldn't connect to server;";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Posts By User</title>
    <style>
    table {
        border-collapse: collapse;
    }
    td {
        border: 1px dashed black;
    }
    th {
        border: 2px solid black;
    }
    label {
        font-weight: bold;
    }
    </style>
</head>
<body>
    <?php if (array_key_exists("user", $_GET)) {
        $username = $my->escape_string($_GET["user"]);
        ?>
        <table>
            <thead>
                <tr><th>Posts by <?php echo $username; ?></th></tr>
            </thead>
            <tbody>
        <?php
        $username = $my->escape_string($_GET["user"]);
        $query = "SELECT content FROM Posts WHERE author_id=\"{$username}\";";
        if ($results = $my->query($query)) {
            while ($result = $results->fetch_assoc()) {
                echo "<tr><td>{$result["content"]}</td></tr>";
            }
            $results->free();
        }
        ?>
            </tbody>
        </table>
    <?php } else { ?>
        <label>View posts for: </label>
        <form action="ViewUserPosts.php">
            <select name="user">
                <?php
                    $query = "SELECT user_id FROM Users;";
                    if ($results = $my->query($query)) {
                        while ($result = $results->fetch_assoc()) {
                            echo "<option value=\"{$result["user_id"]}\">{$result["user_id"]}</option>";
                        }
                        $results->free();
                    }
                ?>
            </select>
            <input type="submit" value="Go!">
        </form>
    <?php } ?>
    <a href="AdminHome.html">Go back</a>
</body>
</html>