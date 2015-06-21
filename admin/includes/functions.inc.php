<?php
	
	
	
	
	
	
	
	// MYSQL PREP	
	function mysql_prep($value) {
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysql_real_escape_string");
		
		if($new_enough_php) {
		// PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
			if($magic_quotes_active){$value = stripslashes($value);}
			$value = mysql_real_escape_string($value);
		} else { //before PHP v4.3.0
			// if magic quotes aren't alreadyon then add slashes manually
			if(!$magic_quotes_active) { $value = addslashes($value);}
			// if magic quotes are active, then the slashes already exists
		}
		return $value;
	}
	
	
	
	
	
	
	
	// CONFIRM QUERY	
	function confirm_query($result_set){
		if (!$result_set) {
			die("Database query failed: ".mysql_error());
		}
	}
	
	
	
	
	
	
	
	// BUILD ADMIN MENU
	$subjects_query = "SELECT * FROM subjects ORDER BY id";
	$subjects_results = mysql_query($subjects_query) or die(mysql_error());
	
	function admin_menu () {
	global $subjects_results;
		
		$currentPage = basename($_SERVER['SCRIPT_NAME']);
		
		echo "<ul id=\"sddm\">";
		echo "<li><a href=\"admin.php\" onmouseover=\"mopen('m1')\" onmouseout=\"mclosetime()\"";
		if ($currentPage == "admin.php") {
			echo " id=\"selected\"";
		}
		echo ">Recent Work</a>";
		echo "<div id=\"m1\" onmouseover=\"mcancelclosetime()\" onmouseout=\"mclosetime()\">";

			while($row = mysql_fetch_array($subjects_results)) {
				echo "<a href=\"admin.php?subject=".$row['id']."\">".$row['subjects']."</a>";
			}
			
		echo "</div></li>";
		echo "<li><a href=\"newEntry.php\"";
		if ($currentPage == "newEntry.php") {
			echo " id=\"selected\"";
		}
		echo ">New Entry</a></li>";
		
		
		echo "<li><a href=\"newUser.php\"";
		if ($currentPage == "newUser.php") {
			echo " id=\"selected\"";
		}
		echo ">New User</a></li>";
		
		echo "<li><a href=\"logout.php\">Logout</a></li>";
		echo "</ul>";
	}	
	
	
	
	
	// REDIRECT
	function redirect_to($location = NULL) {
		if ($location != NULL) {
			header("Location: ".$location."");
			exit;
		}
	}
	
	
	
	
	
	// CHECK REQUIRED FIELDS
	function check_required_fields($required_array) {
		$field_errors = array();
		foreach($required_array as $fieldname) {
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_numeric($_POST[$fieldname]))) {
			$field_errors[] = $fieldname;
			}
		}
		return $field_errors;
	}
	
	
	
	
	
	// CHECK MAX FIELD LENGTHS
	function check_max_field_lengths($field_length_array) {
		$field_errors = array();
		foreach($field_length_array as $fieldname => $maxlength) {
			if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
				$field_errors[] = $fieldname;
			}
		}
		return $field_errors;
	}
	
	
	
	
	
	// DISPLAY ERRORS
	function display_errors($error_array) {
		echo "<p class=\"errors\">";
		echo "Please review the following fields:<br />";
		foreach($error_array as $error) {
			echo " - ".$error."<br />";
		}
		echo "</p>";
	}
	
	
	
	// GET PAGE BY ID
	function get_page_by_id($page_id){
		global $connection;
		$query =	"SELECT * ";
		$query .=		"FROM work ";
		$query .=		"WHERE id=".$page_id;
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		
		//REMEMBER:
		// If no rows are returned, fetch_array will return false
		if ($page = mysql_fetch_array($result_set)) {
			return $page;
		} else {
			return NULL;
		}
	}
	
	
	
	
	
	// FIND SELECTED PAGE
	function find_selected_page(){
	global $select_page;
		if (isset($_GET['entry'])) {
			$select_page = get_page_by_id($_GET['entry']);
		} else {
			$select_page = NULL;
		}
	}
	




