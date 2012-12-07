<?php
$title = 'Add/Edit Building :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>

<div class="info">
  <article class="hero clearfix">
    <?php require_once("includes/sidebar.php");/*get side bar*/ ?>

    <div class="col_66">
        <form action="" method="post" class="form">
        <h2>Add New Building</h2>
        <p>Hospital buildings should be added below, to be used for locations.</p>
        <p class="col_100">
          <label for="name">Building Name:</label><br/>
          <input type="text" name="name" id="name"/>
        </p>
        <p>
        <button type="submit" class="button" name="submit" id="submit" value="Add Building">Add Building</button>
        </p>
        </form>
    </div>
  </article>
</div>

<?php

require_once('includes/footer.php');

?>
