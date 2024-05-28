<?php
session_start();
require_once('classes/database.php');

$con = new database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $connection = $con->opencon();
    if (!$connection) {
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    $action = $_POST['action'];
    $courseId = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;

    switch ($action) {
        case 'add':
            if (!in_array($courseId, $_SESSION['selected_courses'])) {
                $_SESSION['selected_courses'][] = $courseId;
            }
            break;
        
        case 'remove':
            if (($key = array_search($courseId, $_SESSION['selected_courses'])) !== false) {
                unset($_SESSION['selected_courses'][$key]);
            }
            break;
        
        case 'save':
            $userId = $_SESSION['user_id']; // Replace with actual user ID from session.

            foreach ($_SESSION['selected_courses'] as $courseId) {
                $query = $connection->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (:user_id, :course_id)");
                $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $query->bindParam(':course_id', $courseId, PDO::PARAM_INT);
                $query->execute();
            }

            // Clear selected courses after saving
            $_SESSION['selected_courses'] = [];
            break;
    }

    echo json_encode(['status' => 'success']);
    exit;
}

