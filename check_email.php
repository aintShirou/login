<?php
require_once('classes/database.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $con = new database();

    $query = $con->opencon()->prepare("SELECT user_email FROM users WHERE user_email = ?");
    $query->execute([$email]);
    $existingUser = $query->fetch();

    if ($existingUser) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}