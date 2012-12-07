<?php

$submitted = false;

if(isset($_POST['submit'])) { //check if login form has been submitted
	$submitted = true; //mark as submitted
	$username = pg_escape_string($_POST['username']); //get username
	$passwd = pg_escape_string($_POST['passwd']); //get password
	
	if(!empty($username) && !empty($passwd)) { // validate form
		$query = "SELECT COUNT(*) FROM lnm.account WHERE username='$username' AND passwd='$passwd';";
		$result = pg_query($query)
			or die('Query failed: ' . pg_last_error());

		$line = pg_fetch_row($result); //Get query result
		if($line[0]) { //If query returned a result
			session_start(); //Start session
			$_SESSION['username'] = $username; //Set session to username
			$logged_in = true; //Log in user
		} else {
			$login_success = false; //No query result, user details incorrect
		}
		pg_free_result($result); //Free data
	} else {
		$login_success = false; //One or more fields empty, return error
	}
}

if($logged_in) { //check if logged in
	$query = "SELECT fullname FROM lnm.Account WHERE username='$username';"; //Do query for full name
	$result = pg_query($query)
		or die('Query failed: ' . pg_last_error());
	$line = pg_fetch_row($result);
	$name = $line[0]; //Store result as name
	pg_free_result($result);
}

if(!$logged_in && ($submitted && !$login_success)) { //Error message on failed login attempt
	echo '<p></p><div class="warning center">Username/Password combination you entered is incorrect!</div>';
}

?>