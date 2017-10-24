<?php
    require 'connect.php';

    $query = "SELECT * FROM users";
    $statement = $db->prepare($query);
    $statement->execute();
    $users = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Jets Fan Forum</title>
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
            <div id="usertable">
                <table>
                    <thead>
                        <th>User Name</th>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <td>
                                    <form id="updateuser" action="new_user.php" method="post">
                                        <input type="hidden" name="userid" value="<?= $user['userid'] ?>" />
                                        <input type="submit" name="command" value="Update" onclick="return confirm('Are you sure you wish to update this user?')" />
                                    </form>
                                </td>
                                <td>
                                    <?php if($user['userid'] != 1): ?>
                                        <form id="deleteuser" action="register_user.php" method="post">
                                            <input type="hidden" name="userid" value="<?= $user['userid'] ?>" />
                                            <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this user?')" />
                                        </form>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
                <br>
                <p><a href="new_user.php">Create User</a></p>
                <?php if(isset($_GET['error'])): ?>
                    <p> Incorrect credentials entered. Update not completed. </p>
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
                    <li><a href="admin.php">Admin Page</a></li>
                </ul>
            </nav>
        </footer>
    </body>
</html>
