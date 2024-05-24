<?php

require_once('classes/database.php');
$con = new database();
session_start();
$id = $_SESSION['user_id'];
$data=$con->viewdata($id);

if (!isset($_SESSION['user']) || $_SESSION['account_type'] != 1) {
  header('location:login.php');
  exit();
}

if (isset($_POST['updatepassword'])) {
  $userId = $_SESSION['user_id'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];

  if ($newPassword === $confirmPassword) {
      $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

      // Update the password in the database using the new method
      if ($con->updatePassword($userId, $hashedPassword)) {
          // Password updated successfully
          header('Location: user_account.php?status=success');
          exit();
      } else {
          // Failed to update password
          header('Location: user_account.php?status=error');
          exit();
      }
  } else {
      // Passwords do not match
      header('Location: user_account.php?status=nomatch');
      exit();
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
          <p><strong>First Name: </strong> <?php echo $data['first_name']; ?></p>
          <p><strong>Last Name: </strong><?php echo $data['last_name']; ?></p>
          <p><strong>Birthday: </strong> <?php echo $data['birthdate']; ?></p>
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
          <p><strong>Street: </strong><?php echo $data['user_street']; ?> </p>
          <p><strong>Barangay: </strong> <?php echo $data['user_barangay']; ?></p>
          <p><strong>City: </strong> <?php echo $data['user_city']; ?></p>
          <p><strong>Province: </strong> <?php echo $data['user_province']; ?></p>
          
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
            <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo $_SESSION['birthdate']; ?>" required>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $_SESSION['Address']; ?>" required>
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

<!-- Modal for Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="changePasswordForm" method="POST">
          <div class="form-group">
            <label for="currentPassword">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="current_password" required>
          </div>
          <div class="form-group">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="new_password" required readonly>
          </div>
          <div class="form-group">
            <label for="confirmPassword">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required readonly>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="updatepassword" id="saveChangesBtn" disabled>Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const saveChangesBtn = document.getElementById('saveChangesBtn');

    currentPasswordInput.addEventListener('input', function() {
        const currentPassword = currentPasswordInput.value;
        if (currentPassword) {
            fetch('check_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'current_password': currentPassword })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    currentPasswordInput.classList.add('is-valid');
                    currentPasswordInput.classList.remove('is-invalid');
                    newPasswordInput.removeAttribute('readonly');
                    confirmPasswordInput.removeAttribute('readonly');
                } else {
                    currentPasswordInput.classList.add('is-invalid');
                    currentPasswordInput.classList.remove('is-valid');
                    newPasswordInput.setAttribute('readonly', 'readonly');
                    confirmPasswordInput.setAttribute('readonly', 'readonly');
                }
                toggleSaveButton();
            })
            .catch(error => {
                console.error('Error:', error);
                currentPasswordInput.classList.add('is-invalid');
                currentPasswordInput.classList.remove('is-valid');
                newPasswordInput.setAttribute('readonly', 'readonly');
                confirmPasswordInput.setAttribute('readonly', 'readonly');
                toggleSaveButton();
            });
        } else {
            currentPasswordInput.classList.remove('is-valid', 'is-invalid');
            newPasswordInput.setAttribute('readonly', 'readonly');
            confirmPasswordInput.setAttribute('readonly', 'readonly');
            toggleSaveButton();
        }
    });

    function toggleSaveButton() {
        if (currentPasswordInput.classList.contains('is-valid') && validatePassword(newPasswordInput) && validateConfirmPassword(confirmPasswordInput)) {
            saveChangesBtn.removeAttribute('disabled');
        } else {
            saveChangesBtn.setAttribute('disabled', 'disabled');
        }
    }

    newPasswordInput.addEventListener('input', function() {
        validatePassword(newPasswordInput);
        validateConfirmPassword(confirmPasswordInput);
        toggleSaveButton();
    });

    confirmPasswordInput.addEventListener('input', function() {
        validateConfirmPassword(confirmPasswordInput);
        toggleSaveButton();
    });

    function validatePassword(passwordInput) {
        const password = passwordInput.value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (regex.test(password)) {
            passwordInput.classList.add('is-valid');
            passwordInput.classList.remove('is-invalid');
            return true;
        } else {
            passwordInput.classList.add('is-invalid');
            passwordInput.classList.remove('is-valid');
            return false;
        }
    }

    function validateConfirmPassword(confirmPasswordInput) {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        if (password === confirmPassword && password !== '') {
            confirmPasswordInput.classList.add('is-valid');
            confirmPasswordInput.classList.remove('is-invalid');
            return true;
        } else {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.classList.remove('is-valid');
            return false;
        }
    }
});

    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const saveChangesBtn = document.getElementById('saveChangesBtn');

    currentPasswordInput.addEventListener('input', function() {
        const currentPassword = currentPasswordInput.value;
        if (currentPassword) {
            fetch('check_password.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ 'current_password': currentPassword })
            })
            .then(response => response.json())
            .then(data => {
                if (data.valid) {
                    currentPasswordInput.classList.add('is-valid');
                    currentPasswordInput.classList.remove('is-invalid');
                    newPasswordInput.removeAttribute('readonly');
                    confirmPasswordInput.removeAttribute('readonly');
                } else {
                    currentPasswordInput.classList.add('is-invalid');
                    currentPasswordInput.classList.remove('is-valid');
                    newPasswordInput.setAttribute('readonly', 'readonly');
                    confirmPasswordInput.setAttribute('readonly', 'readonly');
                }
                toggleSaveButton();
            });
        } else {
            currentPasswordInput.classList.remove('is-valid', 'is-invalid');
            newPasswordInput.setAttribute('readonly', 'readonly');
            confirmPasswordInput.setAttribute('readonly', 'readonly');
            toggleSaveButton();
        }
    });

    function toggleSaveButton() {
        if (currentPasswordInput.classList.contains('is-valid') && validatePassword(newPasswordInput) && validateConfirmPassword(confirmPasswordInput)) {
            saveChangesBtn.removeAttribute('disabled');
        } else {
            saveChangesBtn.setAttribute('disabled', 'disabled');
        }
    }

    newPasswordInput.addEventListener('input', function() {
        validatePassword(newPasswordInput);
        validateConfirmPassword(confirmPasswordInput);
        toggleSaveButton();
    });

    confirmPasswordInput.addEventListener('input', function() {
        validateConfirmPassword(confirmPasswordInput);
        toggleSaveButton();
    });

    function validatePassword(passwordInput) {
        const password = passwordInput.value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        if (regex.test(password)) {
            passwordInput.classList.add('is-valid');
            passwordInput.classList.remove('is-invalid');
            return true;
        } else {
            passwordInput.classList.add('is-invalid');
            passwordInput.classList.remove('is-valid');
            return false;
        }
    }

    function validateConfirmPassword(confirmPasswordInput) {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        if (password === confirmPassword && password !== '') {
            confirmPasswordInput.classList.add('is-valid');
            confirmPasswordInput.classList.remove('is-invalid');
            return true;
        } else {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.classList.remove('is-valid');
            return false;
        }
    }
  </script>
<!-- SweetAlert2 Script For Pop Up Notification -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const params = new URLSearchParams(window.location.search);
  const status = params.get('status');

  if (status) {
    let title, text, icon;
    switch (status) {
      case 'success':
        title = 'Success!';
        text = 'Password updated successfully.';
        icon = 'success';
        break;
      case 'error':
        title = 'Error!';
        text = 'Failed to update password.';
        icon = 'error';
        break;
      case 'nomatch':
        title = 'Error!';
        text = 'Passwords do not match.';
        icon = 'error';
        break;
      default:
        return;
    }

    Swal.fire({
      title: title,
      text: text,
      icon: icon
    });
  }
});
</script>

<!-- For Address Selector Validation -->

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Fetch region, province, city, and barangay options dynamically if needed
  // Example for adding event listeners for dynamic fetching
  // document.getElementById('region').addEventListener('change', fetchProvinces);

  // Example of a function to fetch provinces
  // function fetchProvinces() {
  //   const regionId = document.getElementById('region').value;
  //   // Fetch provinces based on regionId
  // }

  // Form validation
  var form = document.getElementById('updateAccountForm');
  form.addEventListener('submit', function(event) {
    if (form.checkValidity() === false) {
      event.preventDefault();
      event.stopPropagation();
    }
    form.classList.add('was-validated');
  }, false);
});
</script>


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