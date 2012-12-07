<?php

// -- USER SETUP: PLEASE CHANGE BELOW -- //

//Local Network Monitor Database Details should be entered below
$dbconn = pg_connect("host=localhost dbname=databasehere user=usernamehere password=passhere port=5432")
    or die('Could not connect: ' . pg_last_error());

//Enter the URL of the local network monitor (include trailing slash)
$URL = "http://localhost/lnm/";


// -- DO NOT EDIT AFTER THIS LINE -- //

session_start(); //Start the PHP session
preg_match('#(\w*)\.php#',$_SERVER['PHP_SELF'],$match); //Get page name

/*
 Checks user is logged in, otherwise returns them to home page
*/
$logged_in = false;
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
	$logged_in = true;
} else {
	session_destroy();
	if ($match[0] != 'index.php'){ //If page is index, no need to redirect
		header('Location: '.$URL.''); // sends them to the login page if they are not logged in
	}
}

/*

Adds/Deletes the device from map

*/
function addToMap($id,$deviceid,$x,$y){
	$query = sprintf("UPDATE lnm.device SET x_coordinate='%s', y_coordinate='%s',map_id='%s' WHERE id='%s'" , $x,$y,$id,$deviceid);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
}

function deleteFromMap($deviceid){
	$query = sprintf("UPDATE lnm.device SET x_coordinate=NULL, y_coordinate=NULL WHERE id='%s'" , $deviceid);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
}
/*

Checks if menu page should be highlighted
*/
function checkPage($page){
	preg_match('#(\w*)\.php#',$_SERVER['PHP_SELF'],$current);
	if ($current[0] == $page){
		return "class=\"active\"";
	}
}

/*
 Draws a map on screen with all devices+details associated with map id
*/
function showMap($id){
	$query = sprintf("SELECT name,width,height,path FROM lnm.map WHERE id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	$row = pg_fetch_row($result);
	$map = '<div style="width: '.$row[1].'px; height: '.$row[2].'px; position: relative;"><img id="map" name="map" style="position: relative;" src="'.$row[3].'" alt="'.$row[0].'" />';
	#Map online devices
	$query = sprintf("SELECT d.id,d.name,d.x_coordinate,d.y_coordinate FROM lnm.device d INNER JOIN lnm.connected c ON (d.macAddress = c.macAddress) WHERE map_id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	while($line = pg_fetch_row($result)) {
		$top = $line[3] - 7;
		$left = $line[2] - 7;
		$map .= '<img id="'.$line[0].'" style="position: absolute; top: '.$top.'px; left: '.$left.'px;" src="img/green.png" usemap="#'.$line[0].'" /><map name="'.$line[0].'"><area shape="rect" coords="0,0,14,14" href="device.php?edit='.$line[0].'" alt="'.$line[1].'" title="'.$line[1].'"></map>';
	}
	#Map offline devices
	$query = sprintf("SELECT id,name,x_coordinate,y_coordinate FROM lnm.device WHERE macAddress IN (SELECT macAddress FROM lnm.device EXCEPT SELECT macAddress FROM lnm.connected) AND map_id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	while($line = pg_fetch_row($result)) {
		$top = $line[3] - 7;
		$left = $line[2] - 7;
		$map .= '<img id="'.$line[0].'" style="position: absolute; top: '.$top.'px; left: '.$left.'px;" src="img/red.png" usemap="#'.$line[0].'" /><map name="'.$line[0].'"><area shape="rect" coords="0,0,14,14" href="device.php?edit='.$line[0].'" alt="'.$line[1].'" title="'.$line[1].'"></map>';
	}
	$map.= '</div>';
	return $map;
}

/*
 Draws a clickable map on screen with all devices+details associated with map id
 POST returns map_x and map_y coordinates
*/
function showClickableMap($id,$x=NULL,$y=NULL){
	$query = sprintf("SELECT name,width,height,path FROM lnm.map WHERE id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	$row = pg_fetch_row($result);
	$map = '<div style="width: '.$row[1].'px; height: '.$row[2].'px; position: relative;"><input type="image" id="map" name="map" style="position: relative;" src="'.$row[3].'" alt="'.$row[0].'" />';
	#Map online devices
	$query = sprintf("SELECT d.id,d.name,d.x_coordinate,d.y_coordinate FROM lnm.device d INNER JOIN lnm.connected c ON (d.macAddress = c.macAddress) WHERE d.map_id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	while($line = pg_fetch_row($result)) {
		$top = $line[3] - 7;
		$left = $line[2] - 7;
		$map .= '<img id="'.$line[0].'" style="position: absolute; top: '.$top.'px; left: '.$left.'px;" src="img/green.png" usemap="#'.$line[0].'" /><map name="'.$line[0].'"><area shape="rect" coords="0,0,14,14" href="device.php?edit='.$line[0].'" alt="'.$line[1].'" title="'.$line[1].'"></map>';
	}
	#Map offline devices
	$query = sprintf("SELECT id,name,x_coordinate,y_coordinate FROM lnm.device WHERE macAddress IN (SELECT macAddress FROM lnm.device EXCEPT SELECT macAddress FROM lnm.connected) AND map_id = '%s'" , $id);
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	while($line = pg_fetch_row($result)) {
		if ($line[3] && $line[2]){
			$top = $line[3] - 7;
			$left = $line[2] - 7;
			$map .= '<img id="'.$line[0].'" style="position: absolute; top: '.$top.'px; left: '.$left.'px;" src="img/red.png" usemap="#'.$line[0].'" /><map name="'.$line[0].'"><area shape="rect" coords="0,0,14,14" href="device.php?edit='.$line[0].'" alt="'.$line[1].'" title="'.$line[1].'"></map>';
		}
	}
	if ($x && $y){
		$top = $y - 7;
		$left = $x - 7;
		$map .= '<img id="new" style="position: absolute; top: '.$top.'px; left: '.$left.'px;" src="img/red.png" usemap="#new" /><map name="new"><area shape="rect" coords="0,0,14,14" alt="new" title="New Device"></map>';
	}
	$map.= '</div>';
	return $map;
}

/**
 * Include the PHP functions of the page
 */
$page = str_replace(".php", "_functions.php", $match[0]);
require_once("features/".$page);

?>
