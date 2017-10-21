<?php
    $errorMessages = array();
    $my = new mysqli("mysql.eecs.ku.edu",
                     "zcersovsky",
                     "THE QUICK BROWN FOX JUMPED OVER THE LAZY DOG",
                     "zcersovsky");
    if ($my->connect_errno) {
        $errorMessages[] = "Couldn't connect to 2px;";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete posts</title>
</head>
<body>
    <?php if (array_key_exists("post", $_POST)) { ?>
        <h1>Posts deleted</h1>
        <table>
            <thead>
                <tr>
                    <th>Post ID</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($_POST["post"] as $post) {
                    $postId = $my->escape_string($post);
                    ?>
                    <tr>
                        <td><?php echo $postId; ?></td>
                    <?php
                    $query = "DELETE FROM Posts WHERE post_id=\"{$postId}\";";
                    if ($my->query($query)) {
                        echo "<td>Deleted</td>";
                    } else {
                        echo "<td>Failed to Delete</td>";
                    }
                    ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    <?php } else { ?>
        <h1>Delete posts</h1>
        <form action="DeletePosts.php" method="post">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Post</th>
                        <th>Delete?</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT Users.user_id, Posts.post_id, Posts.content FROM Users INNER JOIN Posts ON Users.user_id = Posts.author_id GROUP BY Users.user_id;";
                if ($results = $my->query($query)) {
                    while ($result = $results->fetch_assoc()) {
                ?>
                        <tr>
                            <td>
                                <?php echo $result["user_id"]; ?>
                            </td><td>
                                <?php echo $result["content"]; ?>
                            </td><td>
                                <input type="checkbox" name="post[]" value="<?php echo $result["post_id"]; ?>">
                            </td>
                        </tr>
                <?php
                    }
                    $results->free();
                }
                ?>
                </tbody>
            </table>
            <input type="submit" value="Delete">
        </form>
    <?php } ?>
    <a href="AdminHome.html">Go home</a>
</body>
</html>