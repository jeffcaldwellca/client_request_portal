<?php
require_once "../include/config.php";

function validateLevel(){
  global $mysqli;

  $sql = "SELECT level from users WHERE id=". $_SESSION['id'];

  if(!$result = $mysqli->query($sql)){
      die('There was an error running the query [' . $mysqli->error . ']');
  }

  while($row = $result->fetch_assoc()){
    $_SESSION["level"] = $row["level"];
  }
}

function generateTemplateSelect(){
  global $mysqli;

  $sql = "SELECT title from portfolio";
  if(!$result = $mysqli->query($sql)){
      die('There was an error running the query [' . $mysqli->error . ']');
  }

  while($row = $result->fetch_assoc()){
    echo "<option value=\"". $row['title'] ."\">". $row['title'] ."</option>";
  }
}

?>
