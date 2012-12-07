<?php
$title = 'Add Location :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>

<div class="info">
  <article class="hero clearfix">
    <?php require_once("includes/sidebar.php"); /*get side bar*/?>

    <div class="col_66">
        <form action="" method="post" class="form">
        <h2>Add New Location</h2>
        <p>This is where all hospital rooms should be added.</p>
        <p class="col_100">
          <label for="name">** Room Name:</label><br/>
          <input type="text" name="name" id="name"/>
        </p>
        <p class="col_100">
          <label for="building">Building:</label><br/>
          <?php echo $list; ?>
          <a href="building.php">Add Building</a>
        </p>
        <p class="col_100">
          <label for="level">Room Level:</label><br/>
          <select name="level">
			<option value='0'>0</option>
			<option value='1'>1</option>
            <option value='2'>2</option>
            <option value='3'>3</option>
            <option value='4'>4</option>
            <option value='5'>5</option>
            <option value='6'>6</option>
            <option value='7'>7</option>
            <option value='8'>8</option>
            <option value='9'>9</option>
		  </select>
        </p>
        <p class="col_100">
          <label for="number">Room Number:</label><br/>
          <input type="text" name="number" id="number" />
        </p>
        <p>
        <button type="submit" class="button" name="submit" id="submit" value="Add Location">Add Location</button>
        </p>
        </form>
        <p>** Optional</p>
    </div>
  </article>
</div>

<?php

require_once('includes/footer.php');

?>
