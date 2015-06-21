<?php
	require('includes/connection.inc.php');	
	require('includes/functions.inc.php');
	require_once("includes/session.inc.php");
	
	if (isset($_POST['submit'])) { //Form has been submitted
		$errors = array();// perform validations on the data
		$required_fields = array('username', 'password');
		$errors = array_merge($errors, check_required_fields($required_fields, $_POST));
		$fields_with_lengths = array('username' => 30, 'password' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));
		$username =trim(mysql_prep($_POST['username']));
		$password =trim(mysql_prep($_POST['password']));
		$hashed_password = sha1($password);
		
		if(empty($errors)) {
			// Check to see if username and hashed password exist there.
			$query = "SELECT id, privilege_id, username, firstname ";
			$query .="FROM users ";
			$query .="WHERE username='{$username}' ";
			$query .="AND password='{$hashed_password}'";
			$result_set = mysql_query($query);
				if(mysql_num_rows($result_set) == 1) {
				// Username/Password autenticated
				// and only one match
					$found_user = mysql_fetch_array($result_set);
					$_SESSION['user_id'] = $found_user['id'];
					$_SESSION['username'] = $found_user['username'];
					$_SESSION['privilege_id'] = $found_user['privilege_id'];
					
					redirect_to("admin.php");
				} else {
					$message = "Username/Password combination inncorrect.";
				}
		} else {
			if(count($errors) ==1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There was ".count($errors)." errors in the form";
			}
		}
	
	} else { // Form has not been submitted
	if(isset($_GET['logout']) && $_GET['logout']==1) {
		$message = "You are logged out";
	}
		$username = "";
		$password = "";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Tom Walsh : : Web Site Admin: Login</title>
		<link href="../css/services.css" rel="stylesheet" type="text/css" media="screen" />
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<meta name="Description" content="See graphic design work by Zach Walsh and decide if my design services are right for you." />
		<meta name="Keywords" content="Graphic Design, Web Design, Web Site, Web Builder, Web Programming, Web Programmer, HTML, CSS, PHP, Logos, Print Design, Business Card Design, Letterhead Design, Stationery Design, Branding, Positioning, Portfolio, Chicago, Illinois, IL" /> 

		<script src="../js/css_browser_selector.js" type="text/javascript"></script>
		

	</head>
	<body>

		<!-- START MAIN CONTAINER -->
		<div id="mainContainer">


			<!-- START HEADLINE -->
			<div id="archiveContainer">
				<h1>
					Tom Walsh: Admin Login
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
			
			</div>
			<h3>Archive Login</h3>
			<?php if (!empty($message)) {echo "<p class=\"errors\">".$message."</p>";} ?>
			<?php if (!empty($errors)) {display_errors($errors);} ?>
			<?php if (isset($_GET['logout']) && ($_GET['logout'] = "true")){echo "<p class=\"errors\">You are logged out.</p>";}else{ echo "";} ?>
			<form action="login.php" method="post">
				<p>Username<br />
				<input type="text" name="username" />
				</p>
				<p>Password<br />
				<input type="password" name="password" />
				</p>
				<input type="submit" name="submit" id="submit" value="Login" />
			</form>



			<!-- START BOTTOM MENU -->
			<div id="bottommenuContainer">
			<hr />
			</div>
			<!-- END BOTTOM MENU -->
			<p class="legal"></p>
			


		</div>
		<!-- END MAIN CONTAINER -->


	</body>
</html>