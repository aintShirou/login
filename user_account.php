<?php
require_once('classes/database.php');
$con = new Database();
session_start();
 
if (!isset($_SESSION['user']) || $_SESSION['account_type'] != 1) {
  header('location:login.php');
  exit();
}
 
$id = $_SESSION['user_id'];
$data = $con->viewdata($id);
 
if (isset($_POST['updatepassword'])) {
  $userId = $_SESSION['user_id'];
  $currentPassword = $_POST['current_password'];
  $newPassword = $_POST['new_password'];
  $confirmPassword = $_POST['confirm_password'];
 
  $con = new database();
 
  if ($con->validateCurrentPassword($userId, $currentPassword)) {
      if ($currentPassword === $newPassword) {
          // New password is the same as the current password
          header('Location: user_account.php?status=samepassword');
          exit();
      }
 
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
  } else {
      // Current password is incorrect
      header('Location: user_account.php?status=wrongpassword');
      exit();
  }
 
  // Fetching currently enrolled courses:
 
 
}
 
 
 
if (isset($_POST['updateaddress'])) {
  $user_id = $id;
  $street = $_POST['user_street'];
  $barangay = $_POST['barangay_text'];
  $city = $_POST['city_text'];
  $province = $_POST['province_text'];
 
  if($con->updateUserAddress($user_id, $street, $barangay, $city, $province)){
    // Address updated successfully
    header('Location: user_account.php?status=success1');
    exit();
  }else{
    // Failed to update address
    header('Location: user_account.php?status=error');
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
 
  <!-- jQuery for Address Selector -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
 
  <!-- For Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="includes/style.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
  <!-- For Pop Up Notification -->
  <link rel="stylesheet" href="./package/dist/sweetalert2.css">
 
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
          <p><strong>First Name:</strong><?php echo $data['first_name']?></p>
          <p><strong>Last Name:</strong><?php echo $data['last_name']?></p>
          <p><strong>Birthday:</strong> <?php echo $data['birthdate']?></p>
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
          <p><strong>Street:</strong><?php echo $data['user_street']?> </p>
          <p><strong>Barangay:</strong><?php echo $data['user_barangay']?> </p>
          <p><strong>City:</strong><?php echo $data['user_city']?> </p>
          <p><strong>Province:</strong><?php echo $data['user_province']?> </p>
         
        </div>
      </div>
    </div>
  </div>
  </div>
 
 
<!-- Change Profile Picture Modal -->
    <!-- Modal for Profile Picture Upload -->
    <div class="modal fade" id="changeProfilePictureModal" tabindex="-1" role="dialog" aria-labelledby="changeProfilePictureModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        <form id="uploadProfilePicForm" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadProfilePicModalLabel">Upload Profile Picture</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="file" class="form-control form-control-file" id="profilePictureInput" name="profile_picture" accept="image/*" required>
                    <small id="fileSizeError" class="form-text text-danger" style="display:none;">File size exceeds 5MB</small>
                </div>
                <div class="form-group">
                    <img id="imagePreview" src="#" alt="Image Preview" style="display:none; width: 100%; height: auto;">
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
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <form id="updateAccountForm" method="post" novalidate>
  <div class="modal-header">
    <h5 class="modal-title" id="updateAccountInfoModalLabel">Update Account Information</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <p>Current Address: <address><?php echo $data['user_street'].', ',$data['user_barangay'].', '. $data['user_city'].', '. $data['user_province'];?></address></p>
    <div class="form-group">
      <label class="form-label">Region<span class="text-danger"> *</span></label>
      <select name="user_region" class="form-control form-control-md" id="region" required></select>
      <input type="hidden" class="form-control form-control-md" name="region_text" id="region-text">
      <div class="valid-feedback">Looks good!</div>
      <div class="invalid-feedback">Please select a region.</div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-6">
        <label class="form-label">Province<span class="text-danger"> *</span></label>
        <select name="user_province" class="form-control form-control-md" id="province" required></select>
        <input type="hidden" class="form-control form-control-md" name="province_text" id="province-text" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please select your province.</div>
      </div>
      <div class="form-group col-md-6">
        <label class="form-label">City / Municipality<span class="text-danger"> *</span></label>
        <select name="user_city" class="form-control form-control-md" id="city" required></select>
        <input type="hidden" class="form-control form-control-md" name="city_text" id="city-text" required>
        <div class="valid-feedback">Looks good!</div>
        <div class="invalid-feedback">Please select your city/municipality.</div>
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Barangay<span class="text-danger"> *</span></label>
      <select name="user_barangay" class="form-control form-control-md" id="barangay" required></select>
      <input type="hidden" class="form-control form-control-md" name="barangay_text" id="barangay-text" required>
      <div class="valid-feedback">Looks good!</div>
      <div class="invalid-feedback">Please select your barangay.</div>
    </div>
    <div class="form-group">
      <label class="form-label">Street <span class="text-danger"> *</span></label>
      <input type="text" class="form-control form-control-md" name="user_street" id="street-text" required>
      <div class="valid-feedback">Looks good!</div>
      <div class="invalid-feedback">Please enter your street.</div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" name="updateaddress" class="btn btn-primary">Save changes</button>
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
          <div id="currentPasswordFeedback" class="invalid-feedback"></div>
        </div>
       
        <div class="form-group">
          <label for="newPassword">New Password</label>
          <input type="password" class="form-control" id="newPassword" name="new_password" required readonly>
          <div id="newPasswordFeedback" class="invalid-feedback"></div>
        </div>
        <div class="form-group">
          <label for="confirmPassword">Confirm New Password</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required readonly>
          <div id="confirmPasswordFeedback" class="invalid-feedback"></div>
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
 
<!-- Password Validation Logic Starts Here --><script>
document.addEventListener('DOMContentLoaded', function() {
    const currentPasswordInput = document.getElementById('currentPassword');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    const saveChangesBtn = document.getElementById('saveChangesBtn');
    const currentPasswordFeedback = document.getElementById('currentPasswordFeedback');
    const newPasswordFeedback = document.getElementById('newPasswordFeedback');
    const confirmPasswordFeedback = document.getElementById('confirmPasswordFeedback');
 
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
                    currentPasswordFeedback.textContent = '';
 
                    newPasswordInput.removeAttribute('readonly');
                    confirmPasswordInput.removeAttribute('readonly');
                } else {
                    currentPasswordInput.classList.add('is-invalid');
                    currentPasswordInput.classList.remove('is-valid');
                    currentPasswordFeedback.textContent = 'Current password is incorrect.';
 
                    newPasswordInput.setAttribute('readonly', 'readonly');
                    confirmPasswordInput.setAttribute('readonly', 'readonly');
                }
                toggleSaveButton();
            })
            .catch(error => {
                console.error('Error:', error);
                currentPasswordInput.classList.add('is-invalid');
                currentPasswordInput.classList.remove('is-valid');
                currentPasswordFeedback.textContent = 'An error occurred while verifying the current password.';
 
                newPasswordInput.setAttribute('readonly', 'readonly');
                confirmPasswordInput.setAttribute('readonly', 'readonly');
                toggleSaveButton();
            });
        } else {
            currentPasswordInput.classList.remove('is-valid', 'is-invalid');
            currentPasswordFeedback.textContent = '';
            newPasswordInput.setAttribute('readonly', 'readonly');
            confirmPasswordInput.setAttribute('readonly', 'readonly');
            toggleSaveButton();
        }
    });
 
    newPasswordInput.addEventListener('input', function() {
        const newPassword = newPasswordInput.value;
        const currentPassword = currentPasswordInput.value;
 
        if (newPassword === currentPassword) {
            newPasswordInput.classList.add('is-invalid');
            newPasswordInput.classList.remove('is-valid');
            newPasswordFeedback.textContent = 'New password cannot be the same as the current password.';
        } else if (validatePassword(newPasswordInput)) {
            newPasswordInput.classList.add('is-valid');
            newPasswordInput.classList.remove('is-invalid');
            newPasswordFeedback.textContent = '';
        } else {
            newPasswordInput.classList.add('is-invalid');
            newPasswordInput.classList.remove('is-valid');
            newPasswordFeedback.textContent = 'Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.';
        }
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
        return regex.test(password);
    }
 
    function validateConfirmPassword(confirmPasswordInput) {
        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;
        if (password === confirmPassword && password !== '') {
            confirmPasswordInput.classList.add('is-valid');
            confirmPasswordInput.classList.remove('is-invalid');
            confirmPasswordFeedback.textContent = '';
            return true;
        } else {
            confirmPasswordInput.classList.add('is-invalid');
            confirmPasswordInput.classList.remove('is-valid');
            confirmPasswordFeedback.textContent = 'Passwords do not match.';
            return false;
        }
    }
 
    function toggleSaveButton() {
        if (currentPasswordInput.classList.contains('is-valid') && validatePassword(newPasswordInput) && validateConfirmPassword(confirmPasswordInput)) {
            saveChangesBtn.removeAttribute('disabled');
        } else {
            saveChangesBtn.setAttribute('disabled', 'disabled');
        }
    }
});
 
</script><!-- Password Validation Logic Ends Here -->
 
<!-- SweetAlert2 Script For Pop Up Notification -->
<script src="./package/dist/sweetalert2.min.js"></script>
 
<!-- After the message is shown the whole website will be reloaded and the query parameters after the url will be removed so that the message only appear once. -->
<!-- Pop Up Messages after a succesful transaction starts here --> <script>
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
      case 'success1':
        title = 'Success!';
        text = 'Address was updated successfully.';
        icon = 'success';
        break;
      case 'error':
        title = 'Error!';
        text = 'Something went wrong.';
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
    }).then(() => {
      // Remove the status parameter from the URL
      const newUrl = window.location.origin + window.location.pathname;
      window.history.replaceState(null, null, newUrl);
    });
  }
});
</script> <!-- Pop Up Messages after a succesful transaction ends here -->
 
 
<!-- Change Profile Picture Logic Starts here --><script>
    $(document).ready(function() {
        $('#profilePictureInput').change(function() {
            const file = this.files[0];
            if (file) {
                // Check file size
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'File size exceeds 5MB.',
                        icon: 'error'
                    });
                    $('#imagePreview').hide();
                    $('#uploadProfilePicForm').data('valid', false);
                    return;
                } else {
                    $('#fileSizeError').hide();
                    $('#uploadProfilePicForm').data('valid', true);
                }
 
                // Preview the image
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreview').show();
                }
                reader.readAsDataURL(file);
            }
        });
 
        $('#uploadProfilePicForm').submit(function(event) {
            event.preventDefault();
            if (!$(this).data('valid')) {
                Swal.fire({
                    title: 'Error!',
                    text: 'File size exceeds 5MB.',
                    icon: 'error'
                });
                return;
            }
 
            const formData = new FormData(this);
            $.ajax({
                url: 'upload_profile_picture.php', // Change this to your PHP file
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    try {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        if (response.success) {
                            $('#profilePicPreview').attr('src', response.filepath);
                            $('#changeProfilePictureModal').modal('hide');
                            Swal.fire({
                                title: 'Success!',
                                text: 'Profile picture updated successfully.',
                                icon: 'success'
                            }).then(() => {
                                // Reload the page after displaying the success message
                                window.location.href = window.location.href.split('?')[0];
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.error,
                                icon: 'error'
                            });
                        }
                    } catch (e) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'An error occurred while processing the response.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while uploading the file.',
                        icon: 'error'
                    });
                }
            });
        });
    });
    </script><!-- Change Profile Picture Logic Ends here -->
 
<!-- For Address Selector Validation --><script>
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
</script><!-- For Address Selector Validation -->
 
 
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!-- Make Sure jquery3.6.0 is before the ph-address-selector.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="ph-address-selector.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
 
</body>
</html>