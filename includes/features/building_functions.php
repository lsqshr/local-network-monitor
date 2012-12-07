<?php

/*
 Submit building
*/
$success = false;

if (isset($_POST['submit'])) {
    $name = pg_escape_string($_POST['name']);
	
	if(!empty($name)){
		$success = true;
		$query = "INSERT INTO lnm.building(name) VALUES ('$name');";
		$result = pg_query($query)
			or $success = false;
	}
}

pg_close($dbconn);

if ($success){ 
	echo '<p></p><div class="success center">Building successfully added!</div>'; 
} else if (isset($_POST['submit']) && !$success){
	echo '<p></p><div class="warning center col_100">Building name empty or already exists. Please try again.</div>'; 
}

?>
