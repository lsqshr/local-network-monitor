<?php
$title = 'Administration :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');


//If user is not logged in, show form
if(!$logged_in) { ?>

<div class="info">
<form action="" method="post" class="form">
<h2>Login to Local Network Monitor</h2>
<p>Please login to proceed to administration</p>
<p class="col_100">
  <label for="username">Username:</label><br/>
  <input type="text" name="username" id="username"/>
</p>
<p class="col_100">
  <label for="passwd">Password:</label><br/>
  <input type="password" name="passwd" id="passwd" />
</p>
<p>
<button type="submit" class="button" name="submit" id="submit" value="Login">Submit</button>
</p>
</form>
</div>

<?php
} else if($logged_in) { //If logged in, show administration page instead
?>

<div class="info">
  <article class="hero clearfix">
    <?php require_once("includes/sidebar.php");/*get side bar*/ ?>

    <div class="col_66">
      <h1>Local Network Monitor Administration</h1>
      <p><?php echo '<p><h3>Welcome back ' . $name . '!</h3></p>'; ?>
      <h2>Network Statistics</h2>
        <ul>
            <li><strong>Number of Devices Online:</strong> 233</li>
            <li><strong>Number of Registered Devices:</strong> 1462</li>
            <li><strong>Number of Locations:</strong> 22</li>
            <li><strong>Network Status:</strong> No conflicts, 0.28ms</li>
        </ul>
    </div>
  </article>
</div>

<?php }

require_once('includes/footer.php'); //Get footer

?>
