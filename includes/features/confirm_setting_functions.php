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
//check if the form is set
if(isset($_GET['apply'])){
	//if set, update result to db
	$enabled='True';			
	if(!($_GET['start_loop']=='Enable scanning')){
		$enabled='False';
	}
	//check if the setting table is empty
	$query='select * from lnm.Settings;';
	$result=pg_query($query);
	if(!$result){
		$query="insert into lnm.Settings values($enabled);";
		pg_query($qeury) or die('Query failed: ' . pg_last_error());			
	}
	else{
		$query="update lnm.Settings set enable_scanning=$enabled;";
		pg_query($query) or die('Query failed: ' . pg_last_error());
	}

	
}

?>