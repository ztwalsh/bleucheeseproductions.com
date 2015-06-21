<?php
	require('includes/connection.inc.php');
	require('includes/functions.inc.php');
	require_once("includes/session.inc.php");
	confirm_logged_in();

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
			<?php
				if(isset($_GET['id']) && $_GET['id'] = "success") {
					echo "<p class=\"warning\">Your new entry has been successfully added.</p>";
				} else {
					echo "";
				}
			?>
			<form action="createEntry.php" method="post" enctype="multipart/form-data">
			
							Select Category<br />
							<select name="subject">
								<option>Select Category</option>
								<?php
								$category_query = "SELECT * FROM subjects";
								$category_results = mysql_query($category_query) or die(mysql_error());
								
									while($row = mysql_fetch_array($category_results)) {
										echo "<option value=".$row['id'].">";
										echo $row['subjects'];
										echo "</option>";
									}
								?>
							</select>
							<p>&nbsp;</p>
							
							Work Sample<br />
							<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
							<span class="input"><input type="file" name="image" id="image" /></span>
							<p>&nbsp;</p>
							
							Title<br />
							<span class="input"><input type="text" name="title" /></span>
							<p>&nbsp;</p>
							
							Web Link<br />
							<span class="input"><input type="text" name="link" /></span>
							<p>&nbsp;</p>
							
							Description<br />
							<textarea name="description"></textarea><br /><br />
							<input type="submit" value="Add Your Entry" name="upload" id="upload" />
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