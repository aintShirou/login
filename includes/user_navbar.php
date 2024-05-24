<?php
$current_page = basename($_SERVER['PHP_SELF']);

// Assuming the profile picture URL is stored in the session or fetched from the database
$profilePicture = $_SESSION['profile_picture'] ?? 'path/to/default/profile_picture.jpg';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Welcome, <?php echo $_SESSION['user']; ?>!</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="index.php">List<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'livesearch.php' OR $current_page == 'update.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="livesearch.php">Live Search</a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'register.php' OR $current_page == 'update.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <li class="nav-item <?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
        <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>

    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <img src="<?php echo $_SESSION['user_profile_picture']; ?>" width="30" height="30" class="rounded-circle" alt="Profile Picture"> <?php echo $_SESSION['user']; ?>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changeProfilePictureModal"><i class="fas fa-user-circle"></i> Change Profile Picture</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updateAccountInfoModal"><i class="fas fa-user-edit"></i> Update Account Information</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePasswordModal"><i class="fas fa-key"></i> Change Password</a>
        </div>

      </li>
    </ul>
  </div>
</nav>