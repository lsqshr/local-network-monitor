<?php
	require_once("get_map_names.php");

	//get devices not marked on the map
	$query="SELECT id,name from lnm.device where map_id is null;";
	$result = pg_query($query)
			or die('Query failed: ' . pg_last_error());
	//generate the devices table
	$devicelist="";
	$devicelist.="<select id=\"device_name\">\n";
	$devicelist.= "<option value='' disabled='disabled' selected='selected'>Select a device</option>\n";
	while($line =pg_fetch_row($result)){
		$device_name=$line[1];
		$device_id=$line[0]; 
		if (isset($_GET['device'])){
			if ($_GET['device'] == $device_id){
				$devicelist.="<option value='$device_id' selected='selected'>$device_name</option>\n";
			} else {
				$devicelist.="<option value='$device_id'>$device_name</option>\n";
			}
		} else {
			$devicelist.="<option value='$device_id'>$device_name</option>\n";
		}
	}
	$devicelist.="</select>";
	/*
	$device_not_marked_table="<table leftmargin=\"50\" border=\"1\">
								<tr>
									<td>device name</td>
									<td>action</td>
								</tr>";
	while($line=pg_fetch_row($result)){
		$device_id=$line[0];
		$device_name=$line[1];
		$device_not_marked_table.="<tr>
									<td>$device_name</td>
									<td><a href='device.php?edit=$line[0]'>Edit</a></td>
								   </tr>";
	}
	$device_not_marked_table.="</table>";
	*/
	

?>
