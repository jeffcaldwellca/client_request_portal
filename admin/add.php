<?php
// Initialize the session
session_start();

$templatename = $description = $tags = $image_url = $demo_url = $action_url = $action_text = $complete = "";
$templatename_err = $description_err = $image_url_err = $demo_url_err = $action_url_err = $action_text_err = "";

require_once "include/adminFunctions.php";

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

validateLevel();

if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if company name is empty
  if(empty(trim($_POST["templatename"]))){
      $templatename_err = "Please enter your templates name.";
  } else{
      $templatename = trim($_POST["templatename"]);
  }
  if(empty(trim($_POST["description"]))){
      $description_err = "Please enter the description of the template.";
  } else{
      $description = trim($_POST["description"]);
  }
  if(empty(trim($_POST["image_url"]))){
      $image_url_err = "Please enter the name of the image file.";
  } else{
      $image_url = trim($_POST["image_url"]);
  }
  if(empty(trim($_POST["demo_url"]))){
      $demo_url_err = "Please enter the URL to the demo site.";
  } else{
      $demo_url = trim($_POST["demo_url"]);
  }
  if(empty(trim($_POST["action_url"]))){
      $action_url_err = "Please enter the call to action URL.";
  } else{
      $action_url = trim($_POST["action_url"]);
  }
  if(empty(trim($_POST["action_text"]))){
      $action_text_err = "Please enter the call to action button text.";
  } else{
      $action_text = trim($_POST["action_text"]);
  }

    $tags = trim($_POST["tags"]);


    // Check input errors before inserting in database
    if(empty($templatename_err) && empty($description_err) && empty($image_url_err) && empty($demo_url_err) && empty($action_url_err) && empty($action_text_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO portfolio (title, description, demo_url, screenshot_url, action_url, action_text, tags) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssssss", $templatename, $description, $demo_url, $image_url, $action_url, $action_text, $tags);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                $_SESSION["created"] = 1;
                $templatename = $description = $tags = $image_url = $demo_url = $action_url = $action_text = "";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
        $complete = true;
        // Close statement
        $stmt->close();
    }}
  $_SESSION["page"] = "add";
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
          <div class="col p-3 mb-2 bg-success text-white">Template added to portfolio.</div>
        <?php
        }
        ?>

        <h2>Add New Template</h2>
        <p>Adding new templates to the available portfolio</p>
      </div>
      <div class="col-12 pt-2">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <div class="form-group <?php echo (!empty($templatename_err)) ? 'has-error' : ''; ?>">
              <label>Template Name</label>
              <input type="text" name="templatename" class="form-control" value="<?php echo $templatename; ?>">
              <span class="help-block"><?php echo $templatename_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($descrption_err)) ? 'has-error' : ''; ?>">
              <label>Short Description <em>(max 80 characters)</em></label>
              <input type="text" name="description" class="form-control" value="<?php echo $description; ?>" maxlength="80">
              <span class="help-block"><?php echo $description_err; ?></span>
          </div>
          <div class="form-group">
              <label>Tags <em>(seperated by commas)</em></label>
              <input type="text" name="tags" class="form-control" value="<?php echo $tags; ?>">
          </div>
          <div class="row">
            <div class="col">
              <div class="form-group <?php echo (!empty($image_url_err)) ? 'has-error' : ''; ?>">
                  <label>Image Name <em>(ex: imageName.jpg)</em></label>
                  <input type="text" name="image_url" class="form-control" value="<?php echo $image_url; ?>">
                  <span class="help-block"><?php echo $image_url_err; ?></span>
              </div>
            </div>
            <div class="col">
              <div class="form-group <?php echo (!empty($demo_url_err)) ? 'has-error' : ''; ?>">
                  <label>Demo URL</label>
                  <input type="text" name="demo_url" class="form-control" value="<?php echo $demo_url; ?>">
                  <span class="help-block"><?php echo $demo_url_err; ?></span>
              </div>
            </div>
            <div class="col">
              <div class="form-group <?php echo (!empty($action_text_err)) ? 'has-error' : ''; ?>">
                  <label>Call to Action Text</label>
                  <input type="text" name="action_text" class="form-control" value="<?php echo $action_text; ?>">
                  <span class="help-block"><?php echo $action_text_err; ?></span>
              </div>
            </div>
            <div class="col">
              <div class="form-group <?php echo (!empty($action_url_err)) ? 'has-error' : ''; ?>">
                  <label>Call to Action URL</label>
                  <input type="text" name="action_url" class="form-control" value="<?php echo $action_url; ?>">
                  <span class="help-block"><?php echo $action_url_err; ?></span>
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
