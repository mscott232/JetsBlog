<?php

    require 'connect.php';

    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);
    if(isset($_POST['command']))
    {
        if ($_POST['command'] == 'Update') {
            $query = "SELECT * FROM users WHERE userid = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
            $statement->execute();

            $user = $statement->fetch();
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jets Fan Forum - Login</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <section id="header">
            <header>
                <div id="titleheading">
                    <h1>Jets Fan Forum</h1>
                    <h4>A Place To Share Your Thoughts</h4>
                    <img src="Images/shoulder-patch.jpg" id="shoulderpatch" alt="shoulder patch">
                    <img src="Images/jets-logo.svg" id="jetslogo" alt="jets logo">
                </div>
                <nav id="navigation">
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="posts.php">Posts</a></li>
                        <li><a href="new.php">Create Posts</a></li>
                        <li><a href="search.php">Search</a></li>
                        <li><a href="category.php">Category</a></li>
                    </ul>
                </nav>
            </header>
        </section>
        <section id="content">
            <div id="login">
                <form id="forum" action="register_user.php" method="post">
                    <?php if(isset($user)): ?>
                        <label for="username">Username: </label>
                        <input id="username" name="username" type="text" value="<?= $user['username'] ?>" />
                        <br>
                        <label for="password">Password: </label>
                        <input for="password" name="password" type="password"  value="<?= $user['password'] ?>" />
                        <br>
                        <label for="reenterpassword">ReEnter Password: </label>
                        <input for="reenterpassword" name="reenterpassword" type="password" value="<?= $user['password'] ?>" />
                        <br>
                        <input type="hidden" name="userid" value="<?= $user['userid'] ?>" />
                        <input type="submit" id="submitbutton" name="command" value="Update" />
                    <?php else: ?>
                        <label for="username">Username: </label>
                        <input id="username" name="username" type="text" />
                        <br>
                        <label for="password">Password: </label>
                        <input for="password" name="password" type="password" />
                        <br>
                        <label for="reenterpassword">ReEnter Password: </label>
                        <input for="reenterpassword" name="reenterpassword" type="password" />
                        <br>
                        <input type="submit" id="submitbutton" name="command" value="Register" />
                    <?php endif ?>
                </form>
                <?php if(isset($_GET['error'])): ?>
                    <p> Incorrect credentials entered </p>
                <?php endif ?>
        </section>
        <footer>
            <nav id="footernav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="posts.php">Posts</a></li>
                    <li><a href="new.php">Create Post</a></li>
                    <li><a href="search.php">Search</a></li>
                    <li><a href="category.php">Category</a></li>
                    <li><a href="process_login.php?logout">Logout</a></li>
                    <?php if(isset($_SESSION['userid']) && $_SESSION['userid'] == 1): ?>
                        <li><a href="admin.php">Admin Page</a></li>
                    <?php endif ?>
                </ul>
            </nav>
        </footer>
    </body>
</html>
