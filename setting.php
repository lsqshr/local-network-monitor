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
      <form name="setting" method="GET" action="confirm_setting.php">
	<input name="start_loop" type="checkbox" value="Enable scanning" <?php echo $is_scanning ?> />  Enable scanning <br><br><br>
	<input class="button" name="apply" type="submit" value="apply changes" onclick=alert("Your changes have been applied")/>
	
      </form>
    </div>
  </article>
</div>


<?php

require_once('includes/footer.php'); //Get footer

?>
