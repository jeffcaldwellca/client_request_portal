<?php
require_once "include/config.php";

unset($search);

if(isset($_POST["q"])){
  $search = $_POST["q"];
}elseif(isset($_GET["q"])){
  $search = $_GET["q"];
}

require_once "include/functions.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Portfolio</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-4">
          <a href="index.php"><img src="images/logo.png" alt="Atomic Growth" id="logo"></a>
        </div>
        <div class="col-4"></div>
        <div class="col-4 mt-4">
          <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-inline">
            <div class="form-row align-bottom">
              <input type="text" name="q" class="form-control mr-1" placeholder="Search..." >
              <button type="submit" class="btn btn-primary float-right">Search</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="container mt-5">
      <div class="row">
        <div class="col-3">
          <ul class="nav flex-column">
            <li id="nav-item"><a href="index.php" class="nav-link border-bottom <?php if(!isset($_GET['id'])) { ?> active <?php } ?>">View All</a></li>
            <?php generateNavigation(); ?>
          </ul>
        </div>
        <div class="col-9">
          <div class="row">
            <?php generatePortfolio(); ?>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>

<?php $mysqli->close(); ?>
