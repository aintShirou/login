<?php
require_once('classes/database.php');
$con = new database();
session_start();

if (empty($_SESSION['user'])) {
header('location:login.php');
}

if(isset($_POST['del'])){
    $id = $_POST['id'];
    if($con->delete($id)){
        header('location:index.php');
} else {
    echo 'Something went wrong';
}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome!</title>
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- For Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="./includes/style.css">
</head>
<body>

<?php include('includes/navbar.php');?>

<div class="container user-info rounded shadow p-3 my-2">
<h2 class="text-center mb-2">User Table</h2>
  <div class="table-responsive text-center">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Profile</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Birthday</th>
          <th>Sex</th>
          <th>Username</th>
          <th>Address</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $counter = 1;
      $data = $con->view();
      foreach($data as $row) {
        ?>
        <tr>
          <td><?php echo $counter++;?></td>
          <td>
        <?php if (!empty($row['user_profile_picture'])): ?>
          <img src="<?php echo htmlspecialchars($row['user_profile_picture']); ?>" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
        <?php else: ?>
          <img src="path/to/default/profile/pic.jpg" alt="Default Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
        <?php endif; ?>
      </td>
          <td><?php echo $row['first_name'];?></td>
          <td><?php echo $row['last_name'];?></td>
          <td><?php echo $row['birthdate'];?></td>
          <td><?php echo $row['sex'];?></td>
          <td><?php echo $row['user'];?></td>
          <td><?php echo ucwords($row['Address']);?></td>
          <td>

        <!-- Edit button -->
          <form action="update.php" method="POST" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>"> 
            <button type="submit"  name="edit" class="btn btn-primary btn-sm">Edit</button>
          </form>
        <!-- Delete button -->
        <form method="POST" style="display: inline;">
            <input type="hidden" name="id" value="<?php echo $row['user_id']; ?>"> 
            <input type="submit"  name="del" value="Delete" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
        </form>
          </td>
        </tr>
        <?php
      }
      ?>

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
<!-- Bootsrap JS na nagpapagana ng danger alert natin -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>