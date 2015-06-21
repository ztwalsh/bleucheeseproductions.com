<?php
	require('includes/connection.inc.php');
	require('includes/functions.inc.php');
	require_once("includes/session.inc.php");
	confirm_logged_in();
	
	if (isset($_POST['submit'])) { //Form has been submitted
		$errors = array();// perform validations on the data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));
		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
		$username =trim(mysql_prep($_POST['username']));
		$password =trim(mysql_prep($_POST['password']));
		$firstname =trim(mysql_prep($_POST['firstname']));
		$privilege_id =trim(mysql_prep($_POST['privilege_id']));
		$hashed_password = sha1($password);
		
		if(empty($errors)) {
			$query = "INSERT INTO users (
						privilege_id, firstname, username, password
						) VALUES (
						'{$privilege_id}', '{$firstname}', '{$username}', '{$hashed_password}'
						)";
			$result = mysql_query($query, $connection);
			if ($result) {
				$message = "The user was successfully created";
			} else{
				$message = "The user could not be created";
				$message .= "<br />".mysql_error();
			}
		} else {
			if(count($errors) ==1) {
				$message = "There was 1 error in the form.";
			} else{
				$message = "There was ".count($errors)." errors in the form";
			}
		}
	
	} else { // Form has not been submitted
		$username = "";
		$password = "";
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>

	<head>
		<title>Tom Walsh : : Web Site Admin</title>
		<link href="../css/services.css" rel="stylesheet" type="text/css" media="screen" />

		<script src="../js/css_browser_selector.js" type="text/javascript"></script>
		

	</head>
	<body>

		<!-- START MAIN CONTAINER -->
		<div id="mainContainer">


			<!-- START HEADLINE -->
			<div id="archiveContainer">
				<h1>
					Tom Walsh: Admin
				</h1>
				<h2>
					Art Direction, Graphic Design, Concept Visualization, Film/Video Direction
				</h2>
			</div>
			<!-- END HEADLINE -->
			
			
			
			<!-- START LOGO CONTAINER -->
			<div id="logoContainer">
			<a href="index.php"><img src="../images/mainLogo.jpg" alt="Bleu Cheese Productions"/></a>
			</div>
			<!-- END LOGO CONTAINER -->



			<!-- START MAIN MENU -->
			<div id="menuContainer">
				<div class="menuHolder">
					<?php
					admin_menu();
				?>
				</div>	
			
			</div>
			<!-- END MAIN MENU -->

			<div id="mainRow">
			<?php if (!empty($message)) {echo "<p class=\"errors\">".$message."</p>";} ?>
			<?php if (!empty($errors)) {display_errors($errors);} ?>
			<form action="newUser.php" method="post">
			
							<p>Privileges<br />
							<select name="privilege_id">
								<option value="0">Select Privilege Level</option>
								<option value="1">Master</option>
								<option value="2">Manager</option>
							</select>
							</p>
							
							<p>First Name<br />
							<input type="text" name="firstname" />
							</p>
							
							<p>Username<br />
							<input type="text" name="username" />
							</p>
							
							<p>Password<br />
							<input type="password" name="password" />
							</p>
							<input type="submit" name="submit" id="submit" value="Create New User" />
							<p>&nbsp;</p>
														
						</form>
			</div>



			<!-- START BOTTOM MENU -->
			<div id="bottommenuContainer">
			<hr><br />
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			</div>
			<!-- END BOTTOM MENU -->


		</div>
		<!-- END MAIN CONTAINER -->


	</body>
</html>