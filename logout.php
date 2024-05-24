<?php 
    session_start();
    $_SESSION['user'] = '';
    $_SESSION['user_profile_picture'] = '';
    $_SESSION['user_id'] = '';
   
    session_unset();
    header('location:login.php');
