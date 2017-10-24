<?php

    require 'connect.php';

    if($_GET)
    {
        if(isset($_GET['Player']))
        {
            $query = "SELECT * FROM posts WHERE category = 'Player' ";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
        elseif(isset($_GET['Team']))
        {
            $query = "SELECT * FROM posts WHERE category = 'Team'";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
        elseif(isset($_GET['General']))
        {
            $query = "SELECT * FROM posts WHERE category = 'General'";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Jets Fan Forum Posts</title>
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
    <div id="orderby">
        <h4>Select the category:</h4>
        <ul>
            <li><a href="category.php?Player">Player</a></li>
            <li><a href="category.php?Team">Team</a></li>
            <li><a href="category.php?General">General</a></li>
        </ul>
    </div>
    <div id="allposts">
        <?php if(isset($_GET['Player']) || isset($_GET['Team']) || isset($_GET['General'])): ?>
            <?php foreach($posts as $post): ?>
                <div id="singlepost">
                    <h5><a href="fullpost.php?postid=<?= $post['postid'] ?>&userid=<?= $post['userid'] ?>"><?= $post['title'] ?></a></h5>
                    <h6>Category: <?= $post['category'] ?></h6>
                    <h6>Date Created: <?= $post['dateposted'] ?></h6>
                    <?php if($post['dateupdated'] != null): ?>
                        <h6>Date Updated: <?= $post['dateupdated'] ?></h6>
                    <?php endif ?>
                    <p><?= $post['post'] ?></p>
                    <?php if($post['imagepath'] != null): ?>
                        <img src="uploads\<?= $post['imagepath'] ?>" alt="uploaded image" />
                    <?php endif ?>
                </div>
            <?php endforeach ?>
        <?php endif ?>
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