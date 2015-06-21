<?php
	include("includes/connection.inc.php");
	require_once("includes/functions.inc.php");
	
	if (intval($_GET['entry']) == 0) {
		redirect_to("admin.php");
	}
	
	$entry = mysql_prep($_GET['entry']);
	
	$delete_entry = "DELETE FROM work WHERE id={$entry} LIMIT 1";
	$delete_query = mysql_query($delete_entry);
	
	if (mysql_affected_rows() ==1) {
		redirect_to("admin.php");
	} else {
		// Deletion Failed
		echo "<p>Subject Deletion Failed</p>";
		echo "<p>".mysql_error()."</p>";
		echo "<p><a href=\"admin.php\">Return to Admin</a></p>";
	}
?>