<?php

$title = 'Unregistered Devices :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>

<div class="info">
  <article class="hero clearfix">
    <div class="col_100">
        <h1>Unregistered Devices</h1>
        <div class="registered">Below displays all conflicting IP addresses that connect to the local network.</div>
	
            <div class="col_100 right">
			<form method="get" id="mainForm" action="registered.php">
              Sort By: </label>
              <select name="sort" onchange="this.form.sortChange()">
                <option value='name' selected>Name</option>
                <option value='location'>Location</option>
              </select>

              Devices per page: </label>
              <select name="show" onchange="this.form.submit()">
                <option value='20' selected>20</option>
                <option value='50'>50</option>
                <option value='100'>100</option>
              </select>
              Filter Devices: </label>
              <select name="filter" onchange="this.form.submit()">
                <option value='0' selected>Show All</option>
                <option value='1'>Connected</option>
                <option value='0'>Unconnected</option>
              </select>
              
            </form>
            </div>
        <h2>Unregistered Devices</h2>
        <div class="success center"><?php echo $unregistered_table; ?></div>
        
    </div>
  </article>
</div>


<?php

require_once('includes/footer.php');

?>
