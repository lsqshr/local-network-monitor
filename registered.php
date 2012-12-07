<?php
$title = 'Registered Devices :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>
<div class="info">
  <article class="hero clearfix">
    <div class="col_100">
        <h1>Registered Devices</h1>
        <div class="registered">Below displays all registered devices that are being monitored.<br  /><br  />
        	<strong>Search Registered Devices</strong>
            <form method="get" id="mainForm" action="registered.php">
            <div>
                Device Name/Host Name: <input type="text" id="s" name="search"/></label>
                <button class="submitForm" type="submit" name="startSearch" id="startSearch" value="true">SEARCH</button>

           </form>
           </div>
<br />
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
            <div>
				<!-- disabled the button to refresh the connected list
                 <form method="post" action="">
                    <button type="submit" id="refresh_list" name="refresh_list" class="submitForm">Refresh List</button>
                </form>
                -->
            </div>
        <h2>Connected Devices</h2>
        <div class="success center"><?php echo $connectedtable; ?></div>
        <h2>Unconnected Devices</h2>
        <div class="message center"><?php echo $unconnectedtable; ?></div>
    </div>
  </article>
</div>


<?php

require_once('includes/footer.php');

?>
