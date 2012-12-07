<?php

$query = "SELECT name FROM lnm.building ORDER BY name ASC;";
$buildings = pg_query($query)
    or die('Query failed: ' . pg_last_error());

$success = false;

/*
 Submit location
*/
if (isset($_POST['submit'])) {
    $name = pg_escape_string($_POST['name']);
    $building = pg_escape_string($_POST['building']);
    $level = pg_escape_string($_POST['level']);
    $number = pg_escape_string($_POST['number']);
	
	if(!empty($building) && !empty($level) && !empty($number)){
		$success = true;
		$query = "INSERT INTO lnm.location(roomName, building, level, roomNo) VALUES ('$name', '$building', '$level', '$number');";
		$result = pg_query($query)
			or $success=false;
		
	}
}

/*
 Generates a list of buildings

*/
$list = "";
$list .= "<select name=\"building\">\n";
$list .= "<option value=''>Select Building</option>\n";
while($line = pg_fetch_row($buildings)) {
	$list .= "<option value='$line[0]'";
	$list .= ">$line[0]</option>\n";
}
$list .= "</select>";

pg_close($dbconn);

require_once('includes/header.php');

if ($success){ 
	echo '<p></p><div class="success center">Location successfully added!</div>'; 
} else if (isset($_POST['submit']) && !$success){
	echo '<p></p><div class="warning center col_100">Location information missing or same location has been registered before. Please try again.</div>'; 
}

?>
