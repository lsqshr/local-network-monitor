<?php

session_start();

$_SESSION = array();

session_destroy();
require_once('includes/paths.php');
header("Location: /");

?>