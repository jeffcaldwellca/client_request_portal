<ul class="nav nav-tabs border-white">
  <li class="nav-item">
    <a class="nav-link <?php if($_SESSION["page"] == "admin"){ ?> active <?php } ?>" href="admin.php">Make a Request</a>
  </li>
  <?php if($_SESSION["level"] == 2) { ?>
  <li class="nav-item">
    <a class="nav-link <?php if($_SESSION["page"] == "add"){ ?> active <?php } ?>" href="add.php">Add Portfolio</a>
  </li>
  <?php } ?>
  <li class="nav-item">
    <a class="nav-link disabled" href="logout.php">Logout</a>
  </li>
</ul>
