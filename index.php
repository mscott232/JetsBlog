<?php
/**
 * Query and display 5 posts from the database
 * Require connect file
 */
    require 'connect.php';

    session_start();

    $query = "SELECT * FROM posts ORDER BY dateposted desc LIMIT 5";
    $statement = $db->prepare($query);
    $statement->execute();
    $posts = $statement->fetchAll();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jets Fan Forum</title>
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
                        <li><a href="new.php">Create Post</a></li>
                        <li><a href="search.php">Search</a></li>
                        <li><a href="category.php">Category</a></li>
                    </ul>
                </nav>
            </header>
        </section>
        <section id="content">
            <div id="description">
                <h3>A little about us!</h3>
                <p>
                    Something about the fans and group in here
                    <?php if(isset($_GET['login'])): ?>
                        <p><?= $_SESSION['userid'] ?> </p>
                    <?php endif; ?>
                </p>
            </div>
            <div id="rules">
                <h4>Rules for the forum</h4>
                <p>
                    Add a few rules here
                </p>
            </div>
            <div id="recentposts">
                <?php foreach($posts as $post): ?>
                    <div id="recentpost">
                        <h5><?= $post['title'] ?></h5>
                        <h6>Category: <?= $post['category'] ?></h6>
                        <h6><?= $post['dateposted'] ?></h6>
                        <p><?= $post['post'] ?></p>
                        <?php if($post['imagepath'] != null): ?>
                            <img src="uploads\<?= $post['imagepath'] ?>" alt="uploaded image" />
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </section>
        <footer>
            <nav id="footernav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="posts.php">Posts</a></li>
                    <li><a href="new.php">Create Posts</a></li>
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
