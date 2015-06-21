<?php
	include("includes/connection.inc.php");
	require_once("includes/functions.inc.php");
	
	//Four steps to closing a session (logout)
	
	//1. find session
	session_start();
	
	//2. unset all session variables
	$_SESSION = array();
	
	//3. Destroy session cookie
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	
	//4. destroy session
	session_destroy();
	
	redirect_to('login.php?logout=true');
?>