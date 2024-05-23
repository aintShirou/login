<?php
require_once('classes/database.php');
session_start();

// Initialize the database connection
$con = new database();
$html = ''; // Initialize empty variable for user table content

try {
    $connection = $con->opencon();

    // Check for connection error
    if (!$connection) {
        echo json_encode(['error' => 'Database connection failed.']);
        exit;
    }

    // Define the number of records per page
    $recordsPerPage = 2;

    // Get the current page number from the request, default to 1 if not set
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($currentPage - 1) * $recordsPerPage;

    // Get the total number of records
    $totalQuery = $connection->prepare("SELECT COUNT(*) AS total FROM users");
    $totalQuery->execute();
    $totalRecords = $totalQuery->fetch(PDO::FETCH_ASSOC)['total'];
    $totalPages = ceil($totalRecords / $recordsPerPage);

    // Fetch users for the current page
    $query = $connection->prepare("SELECT users.user_id, users.first_name, users.last_name, users.birthdate, users.sex, users.user, users.user_profile_picture, CONCAT(user_address.user_city,', ', user_address.user_province) AS Address FROM users INNER JOIN user_address ON users.user_id = user_address.user_id LIMIT :offset, :recordsPerPage");
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $html .= '<tr>';
        $html .= '<td>' . $user['user_id'] . '</td>';
        $html .= '<td><img src="' . htmlspecialchars($user['user_profile_picture']) . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;"></td>';
        $html .= '<td>' . $user['first_name'] . '</td>';
        $html .= '<td>' . $user['last_name'] . '</td>';
        $html .= '<td>' . $user['birthdate'] . '</td>';
        $html .= '<td>' . $user['sex'] . '</td>';
        $html .= '<td>' . $user['user'] . '</td>';
        $html .= '<td>' . $user['Address'] . '</td>';
        $html .= '<td>'; // Action column
        $html .= '<form action="update.php" method="post" style="display: inline;">';
        $html .= '<input type="hidden" name="id" value="' . $user['user_id'] . '">';
        $html .= '<button type="submit" class="btn btn-primary btn-sm">Edit</button>';
        $html .= '</form>';
        $html .= '<form method="POST" style="display: inline;">';
        $html .= '<input type="hidden" name="id" value="' . $user['user_id'] . '">';
        $html .= '<input type="submit" name="delete" class="btn btn-danger btn-sm" value="Delete" onclick="return confirm(\'Are you sure you want to delete this user?\')">';
        $html .= '</form>';
        $html .= '</td>';
        $html .= '</tr>';
    }

    // Output the pagination HTML
    $paginationHtml = '';
    if ($totalPages > 1) {
        $paginationHtml .= '<nav><ul class="pagination justify-content-center">';
        if ($currentPage > 1) {
            $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            $active = $i == $currentPage ? ' active' : '';
            $paginationHtml .= '<li class="page-item' . $active . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
        if ($currentPage < $totalPages) {
            $paginationHtml .= '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
        }
        $paginationHtml .= '</ul></nav>';
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
  <title>User Table with Pagination</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- For Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css?v=<?php echo time(); ?>">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<?php include('includes/navbar.php'); ?>
<div class="container user-info rounded shadow p-3 my-5">
    <h2 class="text-center mb-2">User Table</h2>
    <!-- Search input -->
    <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Search users...">
    </div>
    <div class="table-responsive text-center">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User_ID</th>
                    <th>Picture</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birthday</th>
                    <th>Sex</th>
                    <th>Username</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                <?php echo $html; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination links -->
    <?php echo $paginationHtml; ?>
</div>
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- For Charts -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<!-- script na nagpapagana ng live search -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var search = $(this).val();
            $.ajax({
                url: 'live_search.php',
                method: 'POST',
                data: {search: search},
                success: function(response) {
                    $('#userTableBody').html(response);
                }
            });
        });
    });
</script>
</body>
</html>
