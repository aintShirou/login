<?php
require_once('classes/database.php');

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $con = new database();

    $query = $con->opencon()->prepare("SELECT user FROM users WHERE user = ?");
    $query->execute([$username]);
    $existingUser = $query->fetch();

    if ($existingUser) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}