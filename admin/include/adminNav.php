<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="#">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <?php if($_SESSION["level"] == 2) { ?>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <?php } ?>
  <li class="nav-item">
    <a class="nav-link disabled" href="logout.php">Logout</a>
  </li>
</ul>
