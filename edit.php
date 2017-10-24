<?php

    require 'connect.php';

    $postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);

    $postquery = "SELECT * FROM posts WHERE postid = :postid";
    $statement = $db->prepare($postquery);
    $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
    $statement->execute();
    $singlepost = $statement->fetch();


?>

<!DOCTYPE html>
    <html>
        <head>
            <title>Jets Fan Forum - <?= $singlepost['title'] ?> - Edit</title>
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
            <div id="posting">
                <form id="forum" action="process_post.php" method="post">
                    <label for="title">Title</label>
                    <br>
                    <input id="title" name="title" type="text" value="<?= $singlepost['title'] ?>"/>
                    <br>
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="Player" <?php if($singlepost['category'] == "Player") {echo "selected";} ?> >Player</option>
                        <option value="Team" <?php if($singlepost['category'] == "Team") {echo "selected";} ?> >Team</option>
                        <option value="General" <?php if($singlepost['category'] == "General") {echo "selected";} ?> >General</option>
                    </select>
                    <br>
                    <label for="forumpost">Content</label>
                    <br>
                    <textarea id="forumpost" name="forumpost"><?= $singlepost['post'] ?></textarea>
                    <br>
                    <?php if($singlepost['imagepath'] != null): ?>
                        <img src="uploads\<?= $singlepost['imagepath'] ?>" alt="uploaded image" />
                    <?php endif ?>
                    <input type="hidden" name="postid" value="<?= $postid ?>" />
                    <input type="submit" name="command" value="Update" />
                    <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
                </form>
                <form id="imageremove" action="process_image.php" method="post">
                    <input type="hidden" name="postid" value="<?= $postid ?>" />
                    <input type="submit" name="imageremove" value="Delete Image" onclick="return confirm('Are you sure you wish to delete this image?')" />
                </form>
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