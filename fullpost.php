<?php
/**
 * Display the full posting
 */
    require 'connect.php';

    session_start();

    $postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);
    $userid = filter_input(INPUT_GET, 'userid', FILTER_SANITIZE_NUMBER_INT);

    $postquery = "SELECT * FROM posts WHERE postid = :postid";
    $statement = $db->prepare($postquery);
    $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
    $statement->execute();
    $singlepost = $statement->fetch();

    $userquery = "SELECT * FROM users WHERE userid = :userid";
    $userstatement = $db->prepare($userquery);
    $userstatement->bindValue(':userid', $userid, PDO::PARAM_INT);
    $userstatement->execute();
    $userinfo = $userstatement->fetch();

    $commentquery = "SELECT * FROM comments WHERE postid = :postid";
    $commentstatement = $db->prepare($commentquery);
    $commentstatement->bindValue(':postid', $postid, PDO::PARAM_INT);
    $commentstatement->execute();
    $comments = $commentstatement->fetchAll();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Jets Fan Forum - <?= $singlepost['title'] ?></title>
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
                    </ul>
                </nav>
            </header>
        </section>
        <section id="content">
            <div id="selectedpost">
                <h3><?= $singlepost['title'] ?></h3>
                <h5><?= $userinfo['username'] ?></h5>
                <h5>Category: <?= $singlepost['category'] ?></h5>
                <p><?= $singlepost['post'] ?></p>
                <?php if($singlepost['imagepath'] != null): ?>
                    <img src="uploads\<?= $singlepost['imagepath'] ?>" alt="uploaded image" />
                <?php endif ?>
                <?php if(isset($_SESSION['userid']) && ($_SESSION['userid'] == $singlepost['userid'] || $_SESSION['userid'] == 1)): ?>
                    <p>Do you wish to <a href="edit.php?postid=<?= $postid ?>">Edit</a> this post?</p>
                    <form id="imageform" action="process_image.php" method="post" enctype="multipart/form-data">
                        <label for="image">Image Filename: </label>
                        <input type="file" name="image" id="image" />
                        <br>
                        <input type="hidden" name="postid" value="<?= $postid ?>" />
                        <input type="submit" name="imagepost" value="Post" />
                    </form>
                <?php endif ?>
            </div>
            <div id="makecomment">
                <form id="comment" action="process_comment.php?postid=<?= $postid ?>&postuserid=<?= $userid ?>" method="post">
                    <label for="postcomment">Comment</label>
                    <br>
                    <textarea id="postcomment" name="postcomment"></textarea>
                    <br>
                    <?php if(isset($_SESSION['userid'])): ?>
                        <input type="submit" id="submitbutton" name="command" value="Submit" />
                    <?php else: ?>
                        <p>You need to be logged in to comment</p>
                    <?php endif ?>
                </form>

            </div>
            <div id="comments">
                <h3>Comments</h3>
                <?php foreach($comments as $comment): ?>
                    <div id="singlecomment">
                        <h4><?= $comment['username'] ?></h4>
                        <h5><?= $comment['datecommented'] ?></h5>
                        <p><?= $comment['comment'] ?></p>
                        <?php if(isset($_SESSION['userid']) && ($_SESSION['userid'] == $singlepost['userid'] || $_SESSION['userid'] == $comment['userid'] || $_SESSION['userid'] == 1)): ?>
                            <form id="deletecomment" action="process_comment.php?postid=<?= $postid ?>&commentid=<?= $comment['commentid'] ?>&postuserid=<?= $userid ?>" method="post">
                                <input type="submit" id="deletebutton" name="command" value="Delete" />
                            </form>
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
