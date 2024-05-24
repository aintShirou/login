<?php
session_start();
require_once('classes/database.php');

header('Content-Type: application/json'); // Ensure the content type is set to JSON

if (isset($_POST['current_password'])) {
    $currentPassword = $_POST['current_password'];
    $userId = $_SESSION['user_id'];

    $con = new database();
    $isValid = $con->validateCurrentPassword($userId, $currentPassword);

    echo json_encode(['valid' => $isValid]);
    exit;
} else {
    echo json_encode(['valid' => false, 'error' => 'Current password not provided']);
    exit;
}
