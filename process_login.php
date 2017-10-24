<?php
    require 'connect.php';

    $user = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :user";
    $statement = $db->prepare($query);
    $statement->bindValue(':user', $user, PDO::PARAM_STR);
    $statement->execute();
    $userinfo = $statement->fetch();

    if (password_verify($password, $userinfo['password']))
    {
        session_start();
        $_SESSION['userid'] = $userinfo['userid'];

        header('Location: index.php?login');
    }
    else
    {
        header('Location: login.php?error');
    }



    if(isset($_GET['logout']))
    {
        session_destroy();

        header('Location: index.php?loggedout');
    }

?>

