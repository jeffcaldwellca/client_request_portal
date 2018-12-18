<?php
// Initialize the session
session_start();

$companyname = $phone = $template = $logo_available = $photos_available = $sent = "";
$companyname_err = $phone_err = $template_err = "";

require_once "include/adminFunctions.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

validateLevel();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if company name is empty
    if(empty(trim($_POST["companyname"]))){
        $companyname_err = "Please enter your company name.";
    } else{
        $companyname = trim($_POST["companyname"]);
    }
    if(empty(trim($_POST["phone"]))){
        $phone_err = "Please enter your contact phone.";
    } else{
        $phone = trim($_POST["phone"]);
    }
    if(empty(trim($_POST["template"]))){
        $template_err = "Please select your preferred template.";
    } else{
        $template = trim($_POST["template"]);
    }

    if(empty($companyname_err) && empty($phone_err) && empty($template_err)){

      $sql = "SELECT email FROM settings LIMIT 1";

      if(!$result = $mysqli->query($sql))
          die('There was an error running the query [' . $mysqli->error . ']');

          while($row = $result->fetch_assoc()){
            $email = $row["email"];
          }
      $to = $email;
      $subject = "New Request Submission";

      $message = "
      <html>
      <head>
      <title>New Request Submission</title>
      </head>
      <body>
      <p>Company Name: {$companyname} </p>
      <p>Contact Name: {$_SESSION['fullname']}</p>
      <p>Email: {$_SESSION['username']} </p>
      <p>Preferred Template: {$template} </p>
      <p>Has Logo: {$_POST['logo']} </p>
      <p>Has Photos: {$_POST['photos']}
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <'. $email .'>' . "\r\n";

      mail($to,$subject,$message,$headers);

      $sent = true;
    }
  }
  $_SESSION["page"] = "admin";
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
        <?php if($sent){ ?>
          <div class="col p-3 mb-2 bg-success text-white">Submission sent successfully.</div>
        <?php
        }
        ?>

        <h2>Submit Request</h2>
        <p>Please fill out this form to make your request.</p>
      </div>
      <div class="col-12 pt-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($companyname_err)) ? 'has-error' : ''; ?>">
              <label>Company Name</label>
              <input type="text" name="companyname" class="form-control" value="<?php echo $companyname; ?>">
              <span class="help-block"><?php echo $companyname_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
              <label>Phone Number</label>
              <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
              <span class="help-block"><?php echo $phone_err; ?></span>
          </div>
          <div class="form-group">
            <label>Select Preferred Template</label>
            <select title="template" name="template" class="form-control">
              <option value="">Select...</option>
              <?php generateTemplateSelect(); ?>
            </select>
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label class="checkbox-inline">
                    <input type="checkbox" name="logo" value="yes"> Logo available?
                </label>
              </div>
              <div class="col-6">
                <label class="radio-inline">
                    <input type="checkbox" name="photos" value="yes"> Photos available?
                </label>
              </div>
            </div>
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
