<?php

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
        <form id="forum" action="process_login.php" method="post">
            <label for="username">Username: </label>
            <input id="username" name="username" type="text" />
            <br>
            <label for="password">Password: </label>
            <input for="password" name="password" type="password" />
            <br>
            <input type="submit" id="submitbutton" name="command" value="Submit" />
        </form>
        <?php if(isset($_GET['error'])): ?>
            <p> Username or password incorrect. </p>
        <?php endif ?>
        <p>Not a user? <a href="new_user.php">Register here</a></p>
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
