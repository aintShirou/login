<?php
$current_page = basename($_SERVER['PHP_SELF']);
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
  </div>
</nav>