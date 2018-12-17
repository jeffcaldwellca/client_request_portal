<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

validateLevel();
?>
<?php include_once "include/header.php"; ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <a href="../index.php"><img src="../images/logo.png" alt="Atomic Growth" id="logo"></a>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col">
        <h2>Reset Password</h2>
        <p>Please fill out this form to reset your password.</p>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <?php include_once "include/adminNav.php"; ?>
      </div>
    </div>
  </div>
<?php include_once "include/footer.php"; ?>
