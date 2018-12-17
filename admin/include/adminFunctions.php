<?php

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

function getPageData(id){
  $global $mysqli;

  $sql = "SELECT name, description, page_file, level FROM pages WHERE id=". $_GET["id"];

  while($row = $result->fetch_assoc()){
    if($_SESSION["level"] == $row["level"]){
      echo "
      <h2>". $row['name'] ."</h2>
      <p>". $row['description'] ."</p>
      ";
      include_once $row['page_file'];
    }else{
      $name = "No Access";
      $description = "You don't belong here.";

      echo "
      <h2>". $name ."</h2>
      <p>". $description ."</p>
      ";
    }
  }
}

?>
