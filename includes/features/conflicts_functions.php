<?php

$query = "SELECT ipAddress,COUNT(ipAddress) FROM lnm.connected
GROUP BY ipAddress HAVING COUNT(ipAddress) > 1";
$result = pg_query($query)
    or die('Query failed: ' . pg_last_error());

$conflicts_table = "<table class=\"registered\" border=\"1\" cellpadding=\"3\">\n";
$conflicts_table .= "<tr><th>Device Name</th><th>Mac Address</th><th>IP Address</th></tr>\n";

//For each conflicting ip
while($line = pg_fetch_row($result)) {
	$query2 = sprintf("SELECT d.name,d.macaddress,c.ipaddress FROM lnm.connected c INNER JOIN lnm.device d ON (c.macaddress = d.macaddress) WHERE c.ipaddress = '%s' ORDER BY name DESC;", $line[0]);
	$result2 = pg_query($query2)
		or die('Query failed: ' . pg_last_error());
	//For each device with the conflicting ip
	while($device = pg_fetch_row($result2)){
		$conflicts_table .= "<tr>";
		$conflicts_table .= "<td>$device[0]</td><td>$device[1]</td><td>$device[2]</td>";
		$conflicts_table .= "</tr>\n";
	}
}
$conflicts_table .= "</table>\n";

$query = "SELECT ipAddress,COUNT(ipAddress) FROM lnm.connected
GROUP BY ipAddress HAVING COUNT(ipAddress) > 1";
$result = pg_query($query)
    or die('Query failed: ' . pg_last_error());

$conflicts2_table = "<table class=\"registered\" border=\"1\" cellpadding=\"3\">\n";
$conflicts2_table .= "<tr><th>Mac Address</th><th>IP Address</th></tr>\n";

//For each conflicting ip
while($line = pg_fetch_row($result)) {
	$query2 = sprintf("SELECT macaddress,ipaddress FROM lnm.connected WHERE ipaddress = '%s' AND macaddress NOT IN (SELECT macaddress FROM lnm.device) ORDER BY macaddress DESC;", $line[0]);
	$result2 = pg_query($query2)
		or die('Query failed: ' . pg_last_error());
	//For each device with the conflicting ip
	while($device = pg_fetch_row($result2)){
		$conflicts2_table .= "<tr>";
		$conflicts2_table .= "<td>$device[0]</td><td>$device[1]</td>";
		$conflicts2_table .= "</tr>\n";
	}
}
$conflicts2_table .= "</table>\n";

pg_free_result($result);
//pg_close($dbconn);

?>