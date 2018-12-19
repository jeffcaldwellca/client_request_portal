<?php
function generatePortfolio(){
  global $mysqli;
  global $search;

  if($search){
    $sql = "SELECT title, description, demo_url, screenshot_url, action_url, action_text FROM portfolio WHERE tags LIKE '%{$search}%'";
  }else{
    $sql = "SELECT title, description, demo_url, screenshot_url, action_url, action_text FROM portfolio";
  }
  if(!$result = $mysqli->query($sql)){
      die('There was an error running the query [' . $mysqli->error . ']');
  }

  while($row = $result->fetch_assoc()){
    echo '<div class="col-4">';
    echo '<div class="card" style="width:18rem;margin:30px;border:none;padding:10px;">';
    echo '<img class="card-img-top" src="screenshots/' . $row['screenshot_url'] .'" alt="'. $row['title'] .'">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">'. $row['title'] .'</h5>';
    echo '<p class="card-text" style="min-height:75px;max-height:75px;overflow:hidden;">'. $row['description'] .'</p>';
    echo '<div class="text-center">';
    echo '<a href="'. $row['demo_url'] .'" class="btn btn-danger">Demo</a> <a href="mailto:'. $row['action_url'] .'" class="btn btn-primary">'. $row['action_text'] .'</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

  }
}

function generateNavigation(){
  global $mysqli;

  $sql = "SELECT id, link_tag, link_name FROM nav";
  $result = $mysqli->query($sql);

  while($row = $result->fetch_assoc()){
    if(isset($_GET['id']) && $_GET['id'] == $row['id']){
      $active = "active";
    }else{
      $active = "";
    }
    echo '<li id="nav-item"><a href="index.php?id='. $row['id'] .'&q='. $row['link_tag'] .'" class="nav-link border-bottom '. $active .'">'. $row['link_name'] .'</a></li>';
  }
}

?>
