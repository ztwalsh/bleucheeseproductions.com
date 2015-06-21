<?php
// 1. Create a database connection
$connection = mysql_connect('localhost', 'wallytes_admin', 'Ztwrz841');
if (!$connection) {
	die("Database connection failed: ".mysql_error());
}

// 2. Select Database to use
$db_select = mysql_select_db('wallytes_bleucheese', $connection);
if (!$db_select) {
	die("Database selection failed: ".mysql_error());
}
?>