<?php
// Initialize the session
session_start();

$contact_email = $complete = "";
$contact_email_err = "";

require_once "include/adminFunctions.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

validateLevel();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if company name is empty
  if(empty(trim($_POST["contact_email"]))){
      $contact_email_err = "Please enter your default email address.";
  } else{
      $contact_email = trim($_POST["contact_email"]);
  }


    // Check input errors before inserting in database
    if(empty($contact_email_err)){

        // Prepare an insert statement
        $sql = "UPDATE settings SET email = ? WHERE id = 1";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $contact_email);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        $complete = true;
        // Close statement
        $stmt->close();
    }
  }else{
    $sql = "SELECT email FROM settings WHERE id = 1";
    if(!$result = $mysqli->query($sql)){
        die('There was an error running the query [' . $mysqli->error . ']');
    }

    while($row = $result->fetch_assoc()){
      $contact_email = $row['email'];
    }
  }
  $_SESSION["page"] = "settings";

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
        <?php include_once "include/adminNav.php"; ?>
      </div>
    </div>
    <div class="row border rounded-top">
      <div class="col-12 pt-2">
        <?php if($complete){ ?>
          <div class="col p-3 mb-2 bg-success text-white">Contact Email Updated</div>
        <?php
        }
        ?>

        <h2>Settings</h2>
        <p>Update global settings for contact.</p>
      </div>
      <div class="col-12 pt-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($contact_email_err)) ? 'has-error' : ''; ?>">
              <label>Contact Email</label>
              <input type="text" name="contact_email" class="form-control" value="<?php echo $contact_email; ?>">
              <span class="help-block"><?php echo $contact_email_err; ?></span>
          </div>
          <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Submit">
          </div>
      </form>

      </div>
    </div>
  </div>
  <br /><br />
<?php include_once "include/footer.php"; ?>
