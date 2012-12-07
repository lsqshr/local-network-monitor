<?php
$query = "SELECT id, name, width, height, path FROM lnm.map ORDER BY NAME;";
$maps = pg_query($query)
    or die('Query failed: '. pg_last_error());
    
/*Generate a list of map names*/
$maplist="";
$maplist.="<select id=\"map_name\">\n";
$maplist.= "<option value='' disabled='disabled' selected='selected'>Select a Map</option>\n";
while($line =pg_fetch_row($maps)){
    $map_name=$line[1];
    $map_id=$line[0]; 
	if (isset($_GET['id'])){
		if ($_GET['id'] == $map_id){
    		$maplist.="<option value='$map_id' selected='selected'>$map_name</option>\n";
		} else {
			$maplist.="<option value='$map_id'>$map_name</option>\n";
		}
	} else if (isset($_GET["edit"])){
		$n = fillDevice();
		if ($n[4] == $map_id){
    		$maplist.="<option value='$map_id' selected='selected'>$map_name</option>\n";
		} else {
			$maplist.="<option value='$map_id'>$map_name</option>\n";
		}
	} else {
		$maplist.="<option value='$map_id'>$map_name</option>\n";
	}
}
$maplist.="</select>";
?>
