<?php

    /**
     * - basename()
     * - getimagesize()
     * - file_exists()
     * - pathinfo()
     * - strtolower()
     * - move_uploaded_file()
     */

    $target_dir  = "uploads/";
    $file        = $_FILES['file'];
    $target_file = $target_dir.basename($file['name']);

    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo 'Error happened while uploading your file.';

        return;
    }

    if (!isset($_POST['submit'])) {
        echo 'Forbidden fake image upload.';

        return;
    }

    $check = getimagesize($file['tmp_name']);
    if (!$check) {
        echo 'File is not an image<br/>';

        return;
    }

    echo 'File is an image - '.$check['mime'].'.<br/>';

    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (file_exists($target_file)) {
        echo 'Sorry, file already exists.';

        return;
    }

    if ($file['size'] > 10000000) {
        echo 'Sorry, your file is too large.';

        return;
    }

    $ext = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg' && $ext != 'gif') {
        echo 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';

        return;
    }

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        echo 'The file '.htmlspecialchars(basename($file['name'])).' has been uploaded.';

        return;
    }

    echo 'Sorry, there was an error uploading your file.';
