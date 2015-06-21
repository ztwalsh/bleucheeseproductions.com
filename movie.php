<?php
	require('includes/connection.inc.php');	
	require('includes/functions.inc.php');

	if ($_GET['id'] < 57) {
		header('Location: movie.php?id=57');
		exit;
	} elseif ($_GET['id'] > 113) {
		header('Location: movie.php?id=57');
		exit;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

	<head>
		<title>Tom Walsh: Bleu Cheese Productions</title>
		<link href="css/services.css" rel="stylesheet" type="text/css" media="screen" />
		<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
		<meta name="Description" content="" />
		<meta name="Keywords" content="" /> 

		<script src="../js/css_browser_selector.js" type="text/javascript"></script>
		<script src="js/dropDown.js" type="text/javascript"></script>
		

	</head>
	<body>

		<!-- START MAIN CONTAINER -->
		<div id="mainContainer">


			<!-- START HEADLINE -->
			<div id="archiveContainer">
				<h1>
					Tom Walsh
				</h1>
				<h2>
					Art Direction, Graphic Design, Concept Visualization, Film/Video Direction
				</h2>
			</div>
			<!-- END HEADLINE -->


			<!-- START LOGO CONTAINER -->
			<div id="logoContainer">
			<a href="index.php"><img src="images/mainLogo.jpg" alt="Bleu Cheese Productions"/></a>
			</div>
			<!-- END LOGO CONTAINER -->


			<!-- START MAIN MENU -->
			<div id="menuContainer">
				<p><a href="javascript:window.close();">Close Window</a></p>

			</div>
			<!-- END MAIN MENU -->
			
			<?php
				if ($_GET['id'] == 57) {
					$movie_row = "Gerber_1.mov";
				} elseif ($_GET['id'] == 58) {
					$movie_row = "Gerber_2.mov";
				} elseif ($_GET['id'] == 59) {
					$movie_row = "Gerber_3.mov";
				} elseif ($_GET['id'] == 60) {
					$movie_row = "Gerber_4.mov";
				} elseif ($_GET['id'] == 61) {
					$movie_row = "Gerber_5.mov";
				} elseif ($_GET['id'] == 113) {
					$movie_row = "Gerber_6.mov";
				}
					

								echo		"<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" height=\"260\" width=\"350\">";
								echo		"<param name=\"src\" value=\"movies/".$movie_row."\" />";
								echo		"<param name=\"autoplay\" value=\"true\" />";
								echo		"<param name=\"controller\" value=\"true\" />";
								echo		"<param name=\"wmode\" value=\"transparent\">";
								echo		"<embed height=\"260\" pluginspage=\"http://www.apple.com/quicktime/download/\" src=\"movies/".$movie_row."\" type=\"video/quicktime\" width=\"350\" controller=\"true\" autoplay=\"true\"></embed>";
								echo		"</object>";
								
			?>			


		</div>
		<!-- END MAIN CONTAINER -->

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2303348-1";
urchinTracker();
</script>
	</body>
</html>