<?php
/**
 * Create a new blog post with authentication
 */
    session_start();

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jets Fan Forum - New Post</title>
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
            <div id="posting">
                <form id="forum" action="process_post.php" method="post" enctype="multipart/form-data">
                    <label for="title">Title</label>
                    <br>
                    <input id="title" name="title" type="text" />
                    <br>
                    <label for="category">Category</label>
                    <select id="category" name="category">
                        <option value="Player">Player</option>
                        <option value="Team">Team</option>
                        <option value="General">General</option>
                    </select>
                    <br>
                    <label for="forumpost">Content</label>
                    <br>
                    <textarea id="forumpost" name="forumpost"></textarea>
                    <br>
                    <?php if(isset($_SESSION['userid'])): ?>
                    <input type="submit" id="submitbutton" name="command" value="Submit" />
                    <?php else: ?>
                        <p>You need to be logged in to post</p>
                    <?php endif ?>
                </form>
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
