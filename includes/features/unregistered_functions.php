<?php

$query = "select * from unregistered();";
$result = pg_query($query)
    or die('Query failed: ' . pg_last_error());

$unregistered_table = "<table class=\"registered\" border=\"1\" cellpadding=\"3\">\n";
$unregistered_table .= "<tr><th>Mac Address</th><th>IP Address</th><th>Last Seen</th></tr>\n";

while($line = pg_fetch_row($result)) {
	
    $unregistered_table .= "<tr>";
    $unregistered_table .= "<td>$line[2]</td><td>$line[3]</td><td>$line[4]</td>";
    $unregistered_table .= "</tr>\n";
}
$unregistered_table .= "</table>\n";

pg_free_result($result);
//pg_close($dbconn);

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
	//echo $_GET["sort"]
}

?>