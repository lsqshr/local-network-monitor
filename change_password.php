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
    <?php require_once("includes/sidebar.php"); /*get side bar*/?>

    <div class="col_66">
      	<h1>Local Network Monitor Administration</h1><br><br><br>
	<form name="change_password" method="POST" action="">
		current password   <input type="text" name="current_password"/><br><br>
		new password   <input type="text" name="new_password"/><br><br>
		confirm password   <input type="text" name="confirm_password"/><br><br>
		<input name="submit" type="submit" value="submit">
	</form>
    </div>
  </article>
</div>


<?php

require_once('includes/footer.php'); //Get footer

?>
