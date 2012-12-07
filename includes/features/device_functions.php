<?php

$query = "SELECT id, roomName, building, level, roomNo FROM lnm.location ORDER BY building, level, roomNo ASC;";
$locations = pg_query($query)
    or die('Query failed: ' . pg_last_error());

$success = false;
$message = "";

/*Delete device section */

if (isset($_GET["delete"])) {
	$id = $_GET["delete"]; 
	$query = "DELETE FROM lnm.device WHERE id='$id';";
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	header('/registered.php'); 
	exit();
}

/*Fill device information */

function fillDevice(){
	//get row from database for device with given id
	$device_id=$_GET['edit'];
	$query = sprintf("SELECT name,macAddress,isMobile,location,map_id FROM lnm.device WHERE id='%s'" , pg_escape_string($device_id));
	$result2 = pg_query($query)
	or die('Query failed: ' . pg_last_error());
	$line = pg_fetch_row($result2);
	
	return $line;
}

/*
 Add/Edit Device
*/
if (isset($_POST['submit'])) //
{
	//get strings from form
    $location = pg_escape_string($_POST['location']);
    $name = pg_escape_string($_POST['name']);
    $macAddress = pg_escape_string($_POST['macAddress']);
    $isMobile = pg_escape_string($_POST['mobile']);
	$maplocation = false;
	if (isset($_POST['map']) && isset($_POST['x']) && isset($_POST['y'])){
		$map = pg_escape_string($_POST['map']);
		$x = pg_escape_string($_POST['x']);
		$y = pg_escape_string($_POST['y']);
		$maplocation = true;
	}
	//see if this device has been inserted before
	pg_query("BEGIN;");
	
	$query="SELECT *
	FROM lnm.device
	where macAddress='$macAddress' or name='$name';";
	$result=pg_query($query);
	$valid=true;
	echo $location;
	if(empty($location) && $isMobile=='0'){
		$valid=false;
		$message.="Location is required for non-mobile devices.<br/>";
		$success=false;
	}
	if(pg_fetch_row($result) && !(isset($_GET["edit"]))){
		$valid=false;
		$message.="Device with the same name or mac address has been registered before.<br/>";
		$success=false;
	}
	if(empty($macAddress)){
		$valid=false;
		$message.="Mac address is required!<br/>";
		$success=false;
	}
	if($valid){
		if(!$location){
			$location='NULL';
		}
		if (isset($_GET["edit"])){
			$deviceid = $_GET["edit"];
			$query = "UPDATE lnm.device SET name='$name', isMobile=$isMobile, location=$location, macAddress='$macAddress' WHERE id='$deviceid';";
			$message.="Device edited successfully!";
		} else {
			$query = "INSERT INTO lnm.device(name, macAddress, isMobile, location) VALUES ('$name', '$macAddress', $isMobile, $location);";
			$message.="Device added successfully!";
		}
		$result = pg_query($query)
			or die('Query failed: ' . pg_last_error());
		
        $success = true;
		
		//If a map location was selected for the device
		if ($maplocation){
			$query = "SELECT id FROM lnm.device WHERE macAddress = '$macAddress';";
			$result = pg_query($query)
				or die('Query failed: ' . pg_last_error());
			$line = pg_fetch_row($result);
			//Add device to map
			addToMap($map,$line[0],$x,$y);
		}
	}
        
	
	pg_query("COMMIT;");
}

/*
 Generates a list of locations

*/
function showLocations($location = NULL){
	$query = "SELECT id, roomName, building, level, roomNo FROM lnm.location ORDER BY building, level, roomNo ASC;";
	$locations = pg_query($query)
	or die('Query failed: ' . pg_last_error());
	$list = "";
	$list .= "<select name=\"location\">\n";
	$list .= "<option value=''>Select Location</option>\n";
	while($line = pg_fetch_row($locations)) {
		$line[1] = trim($line[1]);
		if (empty($line[1])){
			$line[1] = $line[2] . " - "  . $line[3] . " - " . $line[4];
		}
		$list .= "<option";
		if ($line[0] == $location){ 
			$list .= " selected";
		}
		$list .= " value='$line[0]'>$line[1]</option>\n";
	}
	$list .= "</select>";
	return $list;
}
    
require_once("get_map_names.php");

//pg_close($dbconn);

?>
