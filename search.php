<?php

    require 'connect.php';

    $results = null;
    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(isset($search))
    {
        $query = "SELECT * FROM posts WHERE (post LIKE ? OR title LIKE ?) AND category = ?";
        $statement = $db->prepare($query);
        $statement->bindValue(1, "%$search%", PDO::PARAM_STR);
        $statement->bindValue(2, "%$search%", PDO::PARAM_STR);
        $statement->bindValue(3, $category, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll();
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jets Fan Forum - Search</title>
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
            <div id="searcharea">
                <form id="contentsearch" method="post">
                    <label for="search">Search</label>
                    <input id="search" name="search" type="text" />
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="Player">Player</option>
                        <option value="Team">Team</option>
                        <option value="General">General</option>
                    </select>
                    <input type="submit" name="submit" />
                </form>
                <div id="allposts">
                    <?php if($search != null): ?>
                        <?php if($results != null): ?>
                            <?php foreach($results as $result): ?>
                                <div id="singlepost">
                                    <h5><a href="fullpost.php?postid=<?= $result['postid'] ?>&userid=<?= $result['userid'] ?>"><?= $result['title'] ?></a></h5>
                                    <h6>Date Created: <?= $result['dateposted'] ?></h6>
                                    <?php if($result['dateupdated'] != null): ?>
                                        <h6>Date Updated: <?= $result['dateupdated'] ?></h6>
                                    <?php endif ?>
                                    <p><?= $result['post'] ?></p>
                                </div>
                            <?php endforeach ?>
                        <?php else: ?>
                            <p>No search results found</p>
                        <?php endif ?>
                    <?php endif ?>
                </div>
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
