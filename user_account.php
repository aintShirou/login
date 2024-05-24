<?php

require_once('classes/database.php');
$con = new database();
session_start();


if (!isset($_SESSION['user']) || $_SESSION['account_type'] != 1) {
  header('location:login.php');
  exit();
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
  <link rel="stylesheet" href="includes/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
   <style>
    .profile-header {
      text-align: center;
      margin: 20px 0;
    }
    .profile-pic {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-bottom: 10px;
    }
    .profile-info, .address-info {
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: #f9f9f9;
      margin-bottom: 20px;
    }
    .info-header {
      background-color: #007bff;
      color: white;
      padding: 10px;
      border-radius: 10px 10px 0 0;
    }
    .info-body {
      padding: 20px;
    }
  </style>
  </style>
</head>
 <body>

<?php include('includes/user_navbar.php'); ?>

<div class="container my-3">



  <div class="row">
    <div class="col-md-12">
      <div class="profile-info">
        <div class="info-header">
          <h3>Account Information</h3>
        </div>
        <div class="info-body">
          <p><strong>First Name:</strong> Jei</p>
          <p><strong>Last Name:</strong> Pastrana</p>
          <p><strong>Birthday:</strong> July 27, 1999</p>
        </div>
      </div>
    </div>
    </div>
    <div class="row">
    <div class="col-md-12">
      <div class="address-info">
        <div class="info-header">
          <h3>Address Information</h3>
        </div>
        <div class="info-body">
          <p><strong>Street:</strong> </p>
          <p><strong>Barangay:</strong></p>
          <p><strong>City:</strong></p>
          <p><strong>Province:</strong></p>
          
        </div>
      </div>
    </div>
  </div>
  </div>
</div>


<!-- Change Profile Picture Modal -->
<div class="modal fade" id="changeProfilePictureModal" tabindex="-1" role="dialog" aria-labelledby="changeProfilePictureModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="change_profile_picture.php" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="changeProfilePictureModalLabel">Change Profile Picture</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="profilePicture">Choose a new profile picture</label>
            <input type="file" class="form-control" id="profilePicture" name="profile_picture" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Update Account Information Modal -->
<div class="modal fade" id="updateAccountInfoModal" tabindex="-1" role="dialog" aria-labelledby="updateAccountInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="update_account_info.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="updateAccountInfoModalLabel">Update Account Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="firstName">First Name</label>
            <input type="text" class="form-control" id="firstName" name="first_name" value="<?php echo $_SESSION['first_name']; ?>" required>
          </div>
          <div class="form-group">
            <label for="lastName">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="last_name" value="<?php echo $_SESSION['last_name']; ?>" required>
          </div>
          <div class="form-group">
            <label for="birthday">Birthday</label>
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $_SESSION['birthday']; ?>" required>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $_SESSION['address']; ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="change_password.php" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="currentPassword">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
          </div>
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="new_password" required>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
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
<!-- For Charts -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

</body>
</html>