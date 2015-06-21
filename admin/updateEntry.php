<?php
	require('includes/connection.inc.php');
	require('includes/functions.inc.php');
	require_once("includes/session.inc.php");
	confirm_logged_in();
	find_selected_page();
	
	
	if (!isset($_GET['entry'])) {
		redirect_to("admin.php");
	}
	if (isset($_POST['submit'])) {
		$errors = array();
		
		$required_fields = array ('subject_id', 'title');
		foreach ($required_fields as $fieldname) {
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_int($_POST[$fieldname]))) {
				$errors[] = $fieldname;
			}		
		}
		$fields_with_lengths = array('title' => 60);
		foreach($fields_with_lengths as $fieldname => $maxlength) {
			if  (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) {
				$errors[] = $fieldname;
			}
		}
		
		if (empty($errors)) {
			// Perform Update
			$id = $_GET['entry'];
			$subject_id = mysql_prep($_POST['subject_id']);
			$title = mysql_prep($_POST['title']);
			$link = mysql_prep($_POST['link']);
			$description = mysql_prep($_POST['description']);
			
			$query = "UPDATE work SET 
					subject_id = '{$subject_id}', 
					title = '{$title}', 
					link = '{$link}', 
					description = '{$description}' 
					WHERE id={$id}";
					
			$result = mysql_query($query, $connection);
			if (mysql_affected_rows() == 1) {
				// Success
				$message = "Entry has been updated.";
			} else {
				// Failed
				$message = "The subject update failed";
				$message .= "<br />".mysql_error();
			}
			
		} else {
			//Errors Occurred
			$message = "There were ". count($errors)." errors in the form.";
		}
		
	}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 TRANSITIONAL//EN">
<html>

	<head>
		<title>Tom Walsh : : Web Site Admin</title>
		<link href="../css/services.css" rel="stylesheet" type="text/css" media="screen" />

		<script src="../js/css_browser_selector.js" type="text/javascript"></script>
		<script src="../js/dropDown.js" type="text/javascript"></script>

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
			<div class="mainLeft">
			
			<?php
				if (!empty($message)) {
					echo "<p class=\"errors\">".$message."</p>";
				}
			?>
			
			<?php
				if (!empty($errors)) {
					echo "<p class=\"errors\">";
					echo "Please review the following fields:<br />";
					foreach($errors as $error) {
						echo " - ".$error."<br />";
					}
					echo "</p>";
				}
			?>
			
			<form action="updateEntry.php?entry=<?php echo urlencode($_GET['entry']); ?>" method="post">
							<?php
							
							?>
			
							<p>Select Category<br />
							<select name="subject_id" id="subject_id">
								<option>Select Category</option>
								<?php
								$category_query = "SELECT * FROM subjects";
								$category_results = mysql_query($category_query) or die(mysql_error());
								
									while($row = mysql_fetch_array($category_results)) {
										echo "<option value=\"".$row['id']."\""; 
										if ($select_page['subject_id'] == $row['id']) {
										echo " selected>";
									} else {
										echo ">";
									}
										echo $row['subjects'];
										echo "</option>";
									}
								?>
							</select>
							</p>
							
							<p>Title<br />
							<span class="input"><input type="text" name="title" id="title" value="<?php echo $select_page['title']; ?>" /></span>
							</p>
							
							<p>Web Link<br />
							<span class="input"><input type="text" name="link" id="link" value="<?php echo $select_page['link']; ?>" /></span>
							</p>
							
							<p>Description<br />
							<textarea name="description" id="description"><?php echo $select_page['description']; ?></textarea><br /><br />
							<input type="submit" value="Update This Entry" name="submit" />
							</p>
							
						</form>
			</div>
			<div class="mainRight">
			<?php
			
			echo "<img src=\"../images/projects/".$select_page['artwork']."\" alt=\"".$select_page['title']."\" /><p>&nbsp;</p>";
			?>
			</div>
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