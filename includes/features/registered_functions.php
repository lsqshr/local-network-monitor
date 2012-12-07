<?php

//Search database for all devices with entered search key
//query:connected devices
//query2: unconnected devices
if (isset($_GET["search"]))
{
	$search = $_GET["search"];
	$query = "SELECT d.id, d.name, c.hostName, c.macAddress, c.ipAddress, d.location, d.isMobile, d.map_id
		FROM lnm.device d INNER JOIN lnm.connected c ON (d.macAddress = c.macAddress) WHERE d.name 
		ILIKE '%$search%' ORDER BY d.name, c.hostName ASC;";
	
	$query2 = "SELECT * FROM lnm.device WHERE macAddress IN 
	(SELECT macAddress FROM lnm.device EXCEPT SELECT macAddress FROM lnm.connected) 
	AND name ILIKE '%$search%' ORDER BY name ASC;";           
}
else //if no search key then return all
{
	$query = "SELECT d.id, d.name, c.hostName, c.macAddress, c.ipAddress, d.location, d.isMobile,d.map_id
		FROM lnm.device d INNER JOIN lnm.connected c ON (d.macAddress = c.macAddress) ORDER BY d.name, c.hostName ASC;";
	$query2 = "SELECT * FROM lnm.device WHERE macAddress IN (SELECT macAddress FROM lnm.device 
		EXCEPT SELECT macAddress FROM lnm.connected) ORDER BY name ASC;";
}


//Display Tables
//Connected Table
$result = pg_query($query) 
	or die('Query failed: ' . pg_last_error());
$connectedtable = "<table class=\"registered\" border=\"1\" cellpadding=\"3\">\n";
$connectedtable .= "<tr><th>Device Name</th><th>Mac Address</th><th>IP Address</th><th>Location</th><th>Mobile?</th><th>Options</th></tr>\n";

while($line = pg_fetch_row($result))
{	
	//get the location of this registered device, if it has one
	$cur_location="";
	if(!empty($line[5])){
		$query = "SELECT * FROM lnm.location WHERE id=$line[5];";
		$location = pg_query($query)
			or die('Query failed: ' . pg_last_error());
		$l = pg_fetch_row($location);
		if (empty($l[1])){
			$cur_location= $l[2] . " - "  . $l[3] . " - " . $l[4];
		}
		else{
			$cur_location= $l[1];
		}
	}
				
	if ($line[6] == 't'){
		$line[6] = "img/tick.png";
	} else {
		$line[6] = "img/error.png";
	}
	$connectedtable .= "<tr>";
	if(!empty($cur_location)){
		$connectedtable .= "<td><a href='device.php?edit=$line[0]'>$line[1]</a></td>
		<td>$line[3]</td><td>$line[4]</td>
		<td><a href='location.php?details=$l[0]'>$cur_location</a></td>
		<td><img src='$line[6]' /></td>";
		if ($line[7]){
		$connectedtable .= "<td><a href='map.php?id=$line[7]'>Show Map</a>";
		} else {
		$connectedtable .= "<td><a href='map.php'>Add to Map</a>";
		}
		$connectedtable .= "  <a href='device.php?delete=$line[0]' onclick=\"return confirm('Are you sure you want to delete this device?')\">Delete</a></td>";
	}
	else{
		$connectedtable .= "<td><a hzref='device.php?edit=$line[0]'>$line[1]</a></td>
		<td>$line[3]</td>
		<td>$line[4]</td>
		<td>---</td>
		<td><img src='$line[6]' /></td>";
		if ($line[7]){
		$connectedtable .= "<td><a href='map.php?id=$line[7]'>Show Map</a>";
		} else {
		$connectedtable .= "<td><a href='map.php'>Add to Map</a>";
		}
		$connectedtable .= "  <a href='device.php?delete=$line[0]' onclick=\"return confirm('Are you sure you want to delete this device?')\">Delete</a></td>";
	}
	$connectedtable .= "</tr>\n";
}
$connectedtable .= "</table>\n";


//Unconnected Table
$result = pg_query($query2) 
	or die('Query failed: ' . pg_last_error());
$unconnectedtable = "<table class=\"registered\" border=\"1\" cellpadding=\"3\">\n";
$unconnectedtable .= "<tr><th>Device Name</th><th>Mac Address</th><th>IP Address</th><th>Location</th><th>Mobile?</th><th>Options</th></tr>\n";

while($line = pg_fetch_row($result))
{
	$cur_location="";
	if($line[5]){
		$query = "SELECT * FROM lnm.location WHERE id=$line[5];";
		$location = pg_query($query)
			or die('Query failed: ' . pg_last_error());
		$l = pg_fetch_row($location);
		if (empty($l[1])){
			$cur_location = $l[2] . " - "  . $l[3] . " - " . $l[4];
		}
		else{
			$cur_location=$l[1];
		}
	}
	
	if ($line[3] == 't'){
		$line[3] = "img/tick.png";
	} else {
		$line[3] = "img/error.png";
	}
	$unconnectedtable .= "<tr>";
	if(!empty($cur_location)){
		$unconnectedtable .= "<td><a href='device.php?edit=$line[0]'>$line[1]</a></td>
						  <td>$line[2]</td>
						  <td>---</td>
						  <td><a href='location.php?details=$l[0]'>$cur_location</a></td>
						  <td><img src='$line[3]' /></td>";
		if ($line[5]){
		$unconnectedtable .= "<td><a href='map.php?id=$line[5]'>Show Map</a>";
		} else {
		$unconnectedtable .= "<td><a href='map.php'>Add to Map</a>";
		}
		$unconnectedtable .= "  <a href='device.php?delete=$line[0]' onclick=\"return confirm('Are you sure you want to delete this device?')\">Delete</a></td>";
	}
	else{
		$unconnectedtable .= "<td><a href='device.php?edit=$line[0]'>$line[1]</a></td>
						  <td>$line[2]</td>
						  <td>---</td>
						  <td>---</td>
						  <td><img src='$line[3]' /></td>";
		if ($line[5]){
		$unconnectedtable .= "<td><a href='map.php?id=$line[5]'>Show Map</a>";
		} else {
		$unconnectedtable .= "<td><a href='map.php'>Add to Map</a>";
		}
		$unconnectedtable .= "  <a href='device.php?delete=$line[0]' onclick=\"return confirm('Are you sure you want to delete this device?')\">Delete</a></td>";
	}
	$unconnectedtable .= "</tr>\n";
}

$unconnectedtable .= "</table>\n";

pg_free_result($result);

function sortChange()
{
	if(isset($_GET["sort"]))
	{
		$sort=$_GET["sort"];
		if($sort=="location")
		{
			$query = "SELECT d.id, d.name, c.hostName, c.macAddress, c.ipAddress, d.location, d.isMobile FROM lnm.device d 
				INNER JOIN lnm.connected c ON (d.macAddress = c.macAddress) 
				ORDER BY d.location;";
			echo "location";
			
		}
	}
}



if (isset($_POST["refresh_list"])){
	startNetworkScan();
	$notification= "<div class=\"notification\"><font color=\"red\">Network Scan has been started, the device list will be updated after several minutes.</font></div>";
	echo $notification;
}
				
?>
