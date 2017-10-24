<?php
    require 'connect.php';

    session_start();

    $postid = filter_input(INPUT_GET, 'postid', FILTER_SANITIZE_NUMBER_INT);
    $userid = $_SESSION['userid'];
    $comment = filter_input(INPUT_POST, 'postcomment', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    date_default_timezone_set('Canada/Central');
    $date = date('Y-m-d H:i:s');
    $errorflag = false;

    $commentid = filter_input(INPUT_GET, 'commentid', FILTER_SANITIZE_NUMBER_INT);
    $postuserid = filter_input(INPUT_GET, 'postuserid', FILTER_SANITIZE_NUMBER_INT);

    $userquery = "SELECT * FROM users WHERE userid = :userid";
    $userstatement = $db->prepare($userquery);
    $userstatement->bindValue(':userid', $userid, PDO::PARAM_INT);
    $userstatement->execute();
    $userinfo = $userstatement->fetch();

    if($_POST['command'] == "Submit")
    {
        if(strlen($comment) > 0) {
            $query = "INSERT INTO comments (postid, userid, comment, datecommented, username) values (:postid, :userid, :comment, :datetime, :username)";
            $statement = $db->prepare($query);
            $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
            $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
            $statement->bindValue(':comment', $comment, PDO::PARAM_STR);
            $statement->bindValue(':datetime', $date, PDO::PARAM_STR);
            $statement->bindValue(':username', $userinfo['username'], PDO::PARAM_STR);
            $statement->execute();

            header("Location: fullpost.php?postid=$postid&userid=$postuserid");
        }
        else
        {
            $errorflag = true;
        }
    }
    elseif($_POST['command'] == 'Delete')
    {
        $query = "DELETE FROM comments WHERE commentid = :commentid";
        $statement = $db->prepare($query);
        $statement->bindValue(':commentid', $commentid, PDO::PARAM_INT);
        $statement->execute();

        header("Location: fullpost.php?postid=$postid&userid=$postuserid");
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

