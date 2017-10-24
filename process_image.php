<?php

    require 'connect.php';

    include 'ImageResize.php';

    session_start();

    $postid = filter_input(INPUT_POST, 'postid', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $userid = $_SESSION['userid'];

    if(isset($_POST['imagepost']))
    {
        function file_upload_path($original_filename, $upload_subfolder_name = 'uploads')
        {
            $current_folder = dirname(__FILE__);
            $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
            return join(DIRECTORY_SEPARATOR, $path_segments);
        }

        function file_is_supported($temporary_path, $new_path)
        {
            $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];
            $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

            $actual_file_extension = pathinfo($new_path, PATHINFO_EXTENSION);
            $actual_mime_type = mime_content_type($temporary_path);

            $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
            $mime_type_is_valid = in_array($actual_mime_type, $allowed_mime_types);

            return $file_extension_is_valid && $mime_type_is_valid;
        }

        $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] == 0);

        if ($image_upload_detected) {
            $image_filename = $_FILES['image']['name'];
            $temporary_image_path = $_FILES['image']['tmp_name'];
            $new_image_path = file_upload_path($image_filename);

            if (file_is_supported($temporary_image_path, $new_image_path)) {
                move_uploaded_file($temporary_image_path, $new_image_path);
            }

            $query = "UPDATE posts SET imagepath = :imagepath WHERE postid = :postid";
            $statement = $db->prepare($query);
            $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
            $statement->bindValue(':imagepath', $image_filename);
            $statement->execute();

            $resizeimage = new \Eventviva\ImageResize("uploads\\" . $image_filename);
            $resizeimage->resizeToBestFit(500, 300);
            $resizeimage->save("uploads\\" . $image_filename);

            header("Location: fullpost.php?postid=$postid&userid=$userid");
        }
    }

    if(isset($_POST['imageremove']))
    {
        $selectquery = "SELECT * FROM posts WHERE postid = :postid";
        $statement = $db->prepare($selectquery);
        $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
        $statement->execute();

        $selectedpost = $statement->fetch();

        $filename = "uploads\\" . $selectedpost['imagepath'];

        unlink($filename);

        $updatequery = "UPDATE posts SET imagepath = null WHERE postid = :postid";
        $statement = $db->prepare($updatequery);
        $statement->bindValue(':postid', $postid, PDO::PARAM_INT);
        $statement->execute();

        header('Location: index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Error</title>
</head>
<body>

</body>
</html>