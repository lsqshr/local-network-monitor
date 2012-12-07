<?php
if(isset($_POST['submit'])){
	$current_username=pg_escape_string($_SESSION['username']);//get the current user's username to take password
	$query="select passwd from lnm.account where username='$current_username'";
	$result=pg_query($query) or die('Query failed: ' . pg_last_error());
	$row=pg_fetch_row($result);
	$current_passwd=pg_escape_string($row[0]); 
	$current_input_passwd=pg_escape_string($_POST['current_password']); 
	$new_password=pg_escape_string($_POST['new_password']);
	$confirm_password=pg_escape_string($_POST['confirm_password']);
	if(!empty($current_input_passwd)&&!empty($new_password)&&!empty($confirm_password)){
		if(!($current_input_passwd==$current_passwd)){
			echo '<p></p><div class="warning center col_100">Your input current password is incorrect.. Please try again.
				</div>'; 
		}
		elseif(!($new_password==$confirm_password)){
			echo '<p></p><div class="warning center col_100">The new password does not match the confirm one. Please try again.</div>'; 
		}
		else{
			$query="update lnm.account set passwd='$new_password' where username='$current_username'";
			pg_query($query) or die('Query failed: ' . pg_last_error());
			echo '<p></p><div class="success center">Password has been changed successfully added!</div>'; 
		}
	}
	else{
		echo '<p></p><div class="warning center col_100">Information missing. Please try again.</div>'; 
	}

}





?>
