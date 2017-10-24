<?php
/**
 * Process the blog posts post inputs depending on if it's a new post, updated post or deleted post.
 * Displays an error if there is a validation issue
 * Requires connection to the database
 */
    require 'connect.php';

    session_start();

    $postid = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $post = filter_input(INPUT_POST, 'forumpost', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userid = $_SESSION['userid'];
    date_default_timezone_set('Canada/Central');
    $date = date('Y-m-d H:i:s');
    $errorflag = false;



    if($_POST['command'] == "Submit")
    {
        if(strlen($title) > 0 && strlen($post) > 0)
        {
            $query = "INSERT INTO posts (userid, post, title, dateposted, category) values (:userid, :post, :title, :datetime, :category)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
            $statement->bindValue(':title', $title, PDO::PARAM_STR);
            $statement->bindValue(':post', $post, PDO::PARAM_STR);
            $statement->bindValue(':datetime', $date, PDO::PARAM_STR);
            $statement->bindValue(':category', $category, PDO::PARAM_STR);
            $statement->execute();

            $insert_id = $db->lastInsertId();

            header("Location: fullpost.php?postid=$insert_id&userid=$userid");
        }
        else
        {
            $errorflag = true;
        }
    }
    elseif($_POST['command'] == "Update")
    {
        if(strlen($title) > 0 && strlen($post) > 0)
        {
            $query = "UPDATE posts SET title = :title, post = :post, dateupdated = :datetime, category = :category WHERE postid = :postid";
            $statement = $db->prepare($query);
            $statement->bindValue(':title', $title, PDO::PARAM_STR);
            $statement->bindValue(':post', $post, PDO::PARAM_STR);
            $statement->bindValue(':datetime', $date, PDO::PARAM_STR);
            $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
            $statement->bindValue(':category', $category, PDO::PARAM_STR);

            $statement->execute();

            header('Location: index.php?success');
        }
        else
        {
            $errorflag = true;
        }
    }
    elseif($_POST['command'] == "Delete")
    {
        $query = "DELETE FROM posts WHERE postid = :postid";
        $statement = $db->prepare($query);
        $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
        $statement->execute();

        header('Location: index.php?success');
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Error</title>
    </head>
    <body>
        <?php if($errorflag == true): ?>
            <p>You experienced an error! <a href="index.php">Go Home!</a></p>
        <?php endif ?>
    </body>
</html>
