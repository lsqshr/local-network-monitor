<?php
$title = 'Add Device :: Local Network Monitor';
require_once('includes/functions.php');
require_once('includes/header.php');
$result = NULL;
if(isset($_GET["edit"])) {
	$result = fillDevice();
} else if (isset($_POST['map_x'])){
	$result = array();
	$result[0] = $_POST['name'];
	$result[1] = $_POST['macAddress'];
	$result[2] = $_POST['mobile'];
	$result[3] = $_POST['location'];
	$result[4] = NULL;
	
}
if ($success){ 
	echo "<p></p><div class=\"success center\">$message</div>"; 
} else if (isset($_POST['submit']) && !$success){
	echo "<p></p><div class=\"warning center col_100\">$message</div>"; 
}
?>
<script>
	$(function(){
		  // bind change event to select
		  $('#map_name').bind('change', function () {
			  var id = $(this).val(); // get selected value
			  if (id) { // require a URL
				  window.location = 'device.php?id=' + id + '';
			  } else {
				  window.location = 'device.php';
			  }
		  });
	});
</script>
<div class="info">
<article class="hero clearfix">
<?php require_once("includes/sidebar.php");/*get side bar*/ ?>
<div class="col_75">
<form action="" method="post" class="form">
<?php if (isset($_GET["edit"])){ echo '<h2>Edit Device</h2>'; } else { echo '<h2>Add New Device</h2><p>This is where new hospital devices should be added.</p>'; } ?>
<p>* fields are mandatory</p>
<p class="col_100">
<label for="name">Device Name *:</label><br/>
<input type="text" name="name" id="name" value="<?php echo $result[0]; ?>"/>
</p>
<p class="col_100">
<label for="macAddress">Mac Address *:</label><br/>
<input type="text" name="macAddress" id="macAddress" value="<?php echo $result[1]; ?>" />
</p>
<p class="col_100">
<label for="location">Location:</label><br/>
<?php echo showLocations($result[3]); ?>
<a href="location.php">Add Location</a>
</p>
<p class="col_100">
<label for="mobile">Mobile Device? *</label><br/>
<select name="mobile">
<?php if (!$result){ echo "<option value='0' selected='selected'>Select</option><option value='false'>No</option><option value='true'>Yes</option>"; }
else if ($result[2] == 'f' || $result[2] == 'false'){ echo "<option value='false' selected='selected'>No</option><option value='true'>Yes</option>"; }
else { echo "<option value='false'>No</option><option value='true' selected='selected'>Yes</option>"; } ?>
</select>
</p>
<!--start to deal with the map-->
<p class="col_100">
<label for="map">Map:</label><br/>
<?php echo $maplist;?>
</p>
<p>
<?php if (isset($_GET['id'])){
	echo '<label for="map">Select device location:</label><br/>';
	if(isset($_POST['map_x'])){
		echo '<input type="hidden" name="map" value="'.$_GET["id"].'">';
		echo '<input type="hidden" name="x" value="'.$_POST["map_x"].'">';
		echo '<input type="hidden" name="y" value="'.$_POST["map_y"].'">';
		echo showClickableMap($_GET['id'],$_POST['map_x'],$_POST['map_y']);
		echo 'Device location selected';
	} else {
		echo showClickableMap($_GET['id']);
	}
}	

if ($result[4]){
	echo '<label for="map">Select device location:</label><br/>';
	if(isset($_POST['map_x'])){
		echo '<input type="hidden" name="map" value="'.$result[4].'">';
		echo '<input type="hidden" name="x" value="'.$_POST["map_x"].'">';
		echo '<input type="hidden" name="y" value="'.$_POST["map_y"].'">';
		deleteFromMap($_GET["edit"]);
		echo showClickableMap($result[4],$_POST['map_x'],$_POST['map_y']);
		echo 'Device location selected';
	} else {
		echo showClickableMap($result[4]);
	}
}

?>
</p>
<p>
<?php if (isset($_GET["edit"])){ ?>
<button type="submit" class="button" name="submit" id="submit" value="Edit Device">Edit Device</button>
<?php } else { ?>
<button type="submit" class="button" name="submit" id="submit" value="Add Device">Add Device</button>
<?php } ?>
</p>
</form>
</div>
</article>
</div>



<?php
require_once('includes/footer.php');
?>
