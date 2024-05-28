<?php
require_once('classes/database.php');
session_start();

$con = new Database();
$htmlAvailableCourses = '';
$htmlSelectedCourses = '';

// Assuming user ID is stored in session
$userId = $_SESSION['user_id']; // Replace this with actual user ID from session

// Fetch available courses
$availableCourses = $con->fetchAvailableCourses($userId);

foreach ($availableCourses as $course) {
    $htmlAvailableCourses .= '<tr>';
    $htmlAvailableCourses .= '<td>' . $course['course_id'] . '</td>';
    $htmlAvailableCourses .= '<td>' . $course['course_name'] . '</td>';
    $htmlAvailableCourses .= '<td>' . $course['course_description'] . '</td>';
    $htmlAvailableCourses .= '<td>';
    if ($course['enrolled_status'] == 'Enrolled') {
        $htmlAvailableCourses .= '<button class="btn btn-secondary" disabled>Already Enrolled</button>';
    } else {
        $htmlAvailableCourses .= '<button class="btn btn-success" onclick="addCourse(' . $course['course_id'] . ')">Add</button>';
    }
    $htmlAvailableCourses .= '</td>';
    $htmlAvailableCourses .= '</tr>';
}

// Fetch selected courses from session
if (!isset($_SESSION['selected_courses'])) {
    $_SESSION['selected_courses'] = [];
}

if (count($_SESSION['selected_courses']) > 0) {
    $selectedCourses = $con->fetchSelectedCourses($_SESSION['selected_courses']);
    foreach ($selectedCourses as $course) {
        $htmlSelectedCourses .= '<tr>';
        $htmlSelectedCourses .= '<td>' . $course['course_id'] . '</td>';
        $htmlSelectedCourses .= '<td>' . $course['course_name'] . '</td>';
        $htmlSelectedCourses .= '<td>' . $course['course_description'] . '</td>';
        $htmlSelectedCourses .= '<td><button class="btn btn-danger" onclick="removeCourse(' . $course['course_id'] . ')">Remove</button></td>';
        $htmlSelectedCourses .= '</tr>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Enroll in Courses</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include('includes/user_navbar.php'); ?>
<div class="container">
  <h2 class="text-center my-4">Enroll in Courses</h2>
  
  <!-- Available Courses Table -->
  <div class="card mb-4">
    <div class="card-header">
      <h4>Available Courses</h4>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered w-100">
        <thead>
          <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="availableCourses">
          <?php echo $htmlAvailableCourses; ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <!-- Selected Courses Table -->
  <div class="card mb-4">
    <div class="card-header">
      <h4>Selected Courses</h4>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-bordered w-100">
        <thead>
          <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Description</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="selectedCourses">
          <?php echo $htmlSelectedCourses; ?>
        </tbody>
      </table>
    </div>
  </div>
  
  <!-- Save Transaction Button -->
  <div class="text-center mb-4">
    <button class="btn btn-primary" onclick="saveTransaction()">Save Transaction</button>
  </div>
</div>

<script>
function addCourse(courseId) {
    $.ajax({
        url: 'process_course.php',
        method: 'POST',
        data: { action: 'add', course_id: courseId },
        success: function(response) {
            location.reload();
        }
    });
}

function removeCourse(courseId) {
    $.ajax({
        url: 'process_course.php',
        method: 'POST',
        data: { action: 'remove', course_id: courseId },
        success: function(response) {
            location.reload();
        }
    });
}

function saveTransaction() {
    $.ajax({
        url: 'process_course.php',
        method: 'POST',
        data: { action: 'save' },
        success: function(response) {
            alert('Transaction saved successfully!');
            location.reload();
        }
    });
}
</script>
</body>
</html>
