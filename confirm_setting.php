<?php
$title = 'Settings :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>

<html>
<head>
	<title>Setting</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<div class="info">
  <article class="hero clearfix">
    <div class="col_25">
      <h2>Admin Menu</h2>
        <ul>        	
	    <li><a href="device.php">Add/Edit Device</a></li>
            <li><a href="location.php">Add/Edit Location</a></li>
            <li><a href="building.php">Add/Edit Building</a></li>
            <li><a href="user.php">Add/Edit User</a></li>
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div>

    <div class="col_66">
      <h1>Local Network Monitor Administration</h1>
      <div>Your changes has been applied!</div>
    </div>
  </article>
</div>


<?php

require_once('includes/footer.php'); //Get footer

?>
