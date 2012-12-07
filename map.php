<?php
$title = 'Add Device :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
?>
<script>
	$(function(){
		  // bind change event to select
		  $('#map_name').bind('change', function () {
			  var id = $(this).val(); // get selected value
			  if (id) { // require a URL
				  window.location = 'map.php?id=' + id + '';
			  } else {
				  window.location = 'map.php';
			  }
		  });
		  $('#device_name').bind('change', function () {
			  var id = $.getUrlVars()['id'] //Gets device id
			  var deviceid = $(this).val(); // get selected value
			  if (deviceid) { // require a URL
				  window.location = 'map.php?id=' + id[0] + '&device=' + deviceid + '';
			  } else {
				  window.location = 'map.php';
			  }
		  });
	});
</script>
<div class="info">
  <article class="hero clearfix">
    <?php require_once("includes/sidebar.php");/*get side bar*/?>
    <h1>Devices Map</h1>
    <div class="col_75">
    	<p>
        Select a map to view:
        <?php echo $maplist;?>
        <a href="map_upload.php?add=true">Add Map</a>
        <a href="map_upload.php?edit=true">Edit Map</a>
        </p>
        <?php if (!isset($_GET['id'])){ ?>
        <p><div align="center" style="font-weight:bold">You should select a map to continue.</div></p>
		<?php } else { ?>
    	<p>
        Add a device not on map:
        <?php echo $devicelist;?>
        </p>
        <p>
        <?php if (isset($_GET['device'])){
			echo '<form action="" method=post>';
			echo '<h2>Click on map to add this device</h2>';
			if('POST' == $_SERVER['REQUEST_METHOD']){
				addToMap($_GET['id'],$_GET['device'],$_POST['map_x'],$_POST['map_y']);
				echo showClickableMap($_GET['id']);
			} else {
				echo showClickableMap($_GET['id']);
			}
			echo '</form>';
			echo '<p><form action="" method="get" class="form"> <button type="submit" class="button" name="id" id="id" value="'.$_GET['id'].'">Finished Adding Device</button></form></p>';
		} else {
            echo showMap($_GET['id']);
        } ?>
        </p>
        
        <?php } ?>
        </p>
	</div>
  </article>
</div>

<?php

require_once('includes/footer.php');

?>
