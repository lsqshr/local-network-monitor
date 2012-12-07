<?php
$is_scanning='checked="checked"';
$query='select * from lnm.Settings;';
$result=pg_query($query) or die('Query failed: ' . pg_last_error());
if($result){
	$row=pg_fetch_row($result);
	if((string)$row[0]=='f'){
		$is_scanning='';		
	}

}
else{
	$is_scanning='';	
}
?>