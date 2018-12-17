<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to admin page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}

// Include config file
require_once "../include/config.php";

// Define variables and initialize with empty values
$username = $password = $level = "";
$username_err = $password_err = $level_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter an email address.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password. level FROM users WHERE username = ?";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $level);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["level"] = $level;

                            // Redirect user to admin page
                            header("location: admin.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $mysqli->close();
}
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
        <?php if(isset($_SESSION["created"])){ ?>
          <div class="col p-3 mb-2 bg-success text-white">Account created.</div>
        <?php
          unset($_SESSION["created"]);
        }
        ?>
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <label>Email Address</label>
              <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
              <span class="help-block"><?php echo $username_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label>Password</label>
              <input type="password" name="password" class="form-control">
              <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group">
              <input type="submit" class="btn btn-primary" value="Login">
          </div>
          <p>Don't have an account? <a href="index.php">Sign up now</a>.</p>
        </form>
      </div>
    </div>
  </div>
<?php include_once "include/footer.php"; ?>
