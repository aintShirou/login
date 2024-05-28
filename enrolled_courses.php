<?php
require_once('classes/database.php');
session_start();

$con = new database();
$htmlEnrolledCourses = '';

// Assuming user ID is stored in session
$userId = $_SESSION['user_id'];

try {
    $connection = $con->opencon();

    if (!$connection) {
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    // Fetch enrolled courses for the user
    $query = $connection->prepare("
        SELECT c.course_id, c.course_name, c.course_description
        FROM courses c
        INNER JOIN enrollments e ON c.course_id = e.course_id
        WHERE e.user_id = :user_id
    ");
    $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $query->execute();
    $enrolledCourses = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($enrolledCourses as $course) {
        $htmlEnrolledCourses .= '<tr>';
        $htmlEnrolledCourses .= '<td>' . $course['course_id'] . '</td>';
        $htmlEnrolledCourses .= '<td>' . $course['course_name'] . '</td>';
        $htmlEnrolledCourses .= '<td>' . $course['course_description'] . '</td>';
        $htmlEnrolledCourses .= '</tr>';
    }

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enrolled Courses</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include('includes/user_navbar.php'); ?>
<div class="container enroll-container">
  <h2 class="text-center my-4">Enrolled Courses</h2>

  <!-- Enrolled Courses Table -->
  <div class="card mb-4">
    <div class="card-header">
      <h4>Your Enrolled Courses</h4>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered w-100">
        <thead>
          <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Description</th>
          </tr>
        </thead>
        <tbody id="enrolledCourses">
          <?php echo $htmlEnrolledCourses; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- For Charts -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>
</html>
