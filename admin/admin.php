<?php
	require('includes/connection.inc.php');	
	require('includes/functions.inc.php');
	require_once("includes/session.inc.php");
	confirm_logged_in();
	
	if(!isset($_GET['subject'])) {
		header('Location: admin.php?subject=1&sample=0');
		exit;
	}
		// HOME PAGE
		// set maximum number of records per page
	define('SHOWMAX', 1);
		// prepare SQL to get total records
	$getTotal = 'SELECT COUNT(*) FROM work WHERE subject_id='.$_GET['subject'];
		// submit query and store result as $totalPix
	$total = mysql_query($getTotal);
	$sample_count = mysql_fetch_row($total);
	$totalSamples = $sample_count[0];
		// set the current page
	$curPage = $_GET['sample'];
		// calculate the start row of the subset
	$startRow = $curPage * SHOWMAX;
		// prepare SQL to retrieve subset of image details
	$sample_info = "SELECT * FROM work WHERE subject_id=".$_GET['subject']." ORDER BY id ASC LIMIT $startRow, ".SHOWMAX;
		// submit the query (MySQL original)
	$sample_results = mysql_query($sample_info) or die(mysql_error());
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Tom Walsh: Bleu Cheese Productions: Web Site Admin</title>
		<link href="../css/services.css" rel="stylesheet" type="text/css" media="screen" />
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<meta name="Description" content="" />
		<meta name="Keywords" content="" /> 

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


<h4>View More Samples&nbsp;&nbsp;
			<?php
			// Previous Record if it Exists
				if ($curPage > 0) {
					echo '<a href="admin.php?subject='.$_GET['subject'].'&sample='.($curPage-1).'"><img src="../images/dkleft.jpg" alt="arrow left" /></a> &nbsp;&nbsp;';
				} else {
					echo '<img src="../images/ltleft.jpg" alt="arrow left" /> &nbsp;&nbsp; ';
				}
				// Next Record if it Exists
				if ($startRow+SHOWMAX < $totalSamples) {
					echo '<a href="admin.php?subject='.$_GET['subject'].'&sample='.($curPage+1).'"><img src="../images/dkright.jpg" alt="arrow left" /></a>';
				}
				else {
					echo '<img src="../images/ltright.jpg" alt="arrow left" />';
				}
			?>
			</h4>



			<?php
				while($sample_row = mysql_fetch_array($sample_results)) {
					echo "<div class=\"mainRow\">";
						echo "<div class=\"mainLeft\">";
						
						echo "<p class=\"errors\"><a href=\"updateEntry.php?entry=".$sample_row['id']."\">EDIT ENTRY</a></p>";
						echo "<p class=\"errors\"><a href=\"deleteEntry.php?entry=".$sample_row['id']."\" onclick=\"return confirm('Are you sure you want to delete ".$sample_row['title']."?');\">DELETE ENTRY</a></p>";
						
						echo "<h3>".$sample_row['title']."</h3>";
						echo $sample_row['description'];
						if($sample_row['link'] == !NULL) {
							echo "<p><a href=\"".$sample_row['link']."\" target=\"_blank\">See the Site</a></p><p>&nbsp;</p>";
						} else {
							echo "";
						}
						echo "</div>";
						
						echo "<div class=\"mainRight\">";
						
						if ($sample_row['artwork'] == NULL) {
							echo "<img src=\"../images/projects/comingSoon.jpg\" alt=\"".$sample_row['title']."\" /><p>&nbsp;</p>";
						} else {
							echo "<img src=\"../images/projects/".$sample_row['artwork']."\" alt=\"".$sample_row['title']."\" /><p>&nbsp;</p>";
						}
						echo "</div>";
					echo "</div>";
				}
			?>
			


		</div>
		<!-- END MAIN CONTAINER -->

	</body>
</html>