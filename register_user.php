<?php

    require 'connect.php';

    session_start();

    $user = $_POST['username'];
    $password = $_POST['password'];
    $reenterpassword = $_POST['reenterpassword'];
    date_default_timezone_set('Canada/Central');
    $date = date('Y-m-d');

    $userid = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_NUMBER_INT);

    if($_POST['command'] == "Register")
    {
        if ($password == $reenterpassword && strlen(user) > 0 && strlen($password) > 0)
        {
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO users (username, password, datejoined) values (:username, :password, :datejoined)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $user);
            $statement->bindValue(':password', $hashedpassword);
            $statement->bindValue(':datejoined', $date);
            $statement->execute();

            $insert_id = $db->lastInsertId();

            if ($_SESSION['userid'] == 1)
            {
                header('Location: admin.php');
            }
            else
            {
                $_SESSION['userid'] = $insert_id;
                header('Location: index.php?login');
            }
        }
        else
        {
            header('Location: new_user.php?error');
        }
    }
    elseif($_POST['command'] == "Update")
    {
        if ($password == $reenterpassword && strlen(user) > 0 && strlen($password) > 0)
        {
            $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE users SET username = :username, password = :password WHERE userid = :userid";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $user);
            $statement->bindValue(':password', $hashedpassword);
            $statement->bindValue(':userid', $userid, PDO::PARAM_STR);
            $statement->execute();

            header('Location: admin.php');
        }
        else
        {
            header('Location: admin.php?error');
        }
    }
    elseif($_POST['command'] == "Delete")
    {
        $query = "DELETE FROM users WHERE userid = :userid";
        $statement = $db->prepare($query);
        $statement->bindValue(':userid', $userid, PDO::PARAM_INT);
        $statement->execute();

        header('Location: admin.php');
    }

