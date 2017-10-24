<?php
/**
 * Query and display all posts from the database with option to sort
 * Require connect file
 */
    require 'connect.php';

    if($_GET)
    {
        if(isset($_GET['title']))
        {
            $query = "SELECT * FROM posts ORDER BY title";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
        elseif(isset($_GET['createdold']))
        {
            $query = "SELECT * FROM posts ORDER BY dateposted ASC";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
        elseif(isset($_GET['creatednew']))
        {
            $query = "SELECT * FROM posts ORDER BY dateposted DESC";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
        elseif(isset($_GET['dateupdated']))
        {
            $query = "SELECT * FROM posts ORDER BY dateupdated DESC";
            $statement = $db->prepare($query);
            $statement->execute();
            $posts = $statement->fetchAll();
        }
    }
    else
    {
        $query = "SELECT * FROM posts ORDER BY dateposted";
        $statement = $db->prepare($query);
        $statement->execute();
        $posts = $statement->fetchAll();
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
                <h4>Order By:</h4>
                <ul>
                    <li><a href="posts.php?title">Title</a></li>
                    <li><a href="posts.php?createdold">Date Created Oldest</a></li>
                    <li><a href="posts.php?creatednew">Date Created Newest</a></li>
                    <li><a href="posts.php?dateupdated">Date Updated</a></li>
                </ul>
            </div>
            <div id="allposts">
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
