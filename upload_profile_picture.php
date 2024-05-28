<?php
session_start();
require_once('classes/database.php');
$con = new database();
$response = array('success' => false, 'error' => '', 'filepath' => '');

if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $target_dir = "uploads/";
    $original_file_name = basename($_FILES["profile_picture"]["name"]);
    $new_file_name = $original_file_name;
    $target_file = $target_dir . $original_file_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check if file already exists and rename if necessary
    if (file_exists($target_file)) {
        $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;
    } else {
        $target_file = $target_dir . $original_file_name;
    }

    // Check file size
    if ($_FILES["profile_picture"]["size"] > 5 * 1024 * 1024) {
        $response['error'] = "File size exceeds 5MB.";
        echo json_encode($response);
        exit;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $response['error'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo json_encode($response);
        exit;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $response['error'] = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture_path = 'uploads/' . $new_file_name;

            // Update the user profile picture in the database
            $userID = $_SESSION['user_id']; // Ensure user_id is stored in session
            if ($con->updateUserProfilePicture($userID, $profile_picture_path)) {
                $response['success'] = true;
                $response['filepath'] = $profile_picture_path;
            } else {
                $response['error'] = "Database update failed.";
            }
        } else {
            $response['error'] = "Sorry, there was an error uploading your file.";
        }
    }
} else {
    $response['error'] = "No file was uploaded.";
}

echo json_encode($response);

