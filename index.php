<?php
	require('includes/connection.inc.php');	
	require('includes/functions.inc.php');
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

		<script src="js/css_browser_selector.js" type="text/javascript"></script>
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
				<div class="menuHolder">
					<?php
						archive_menu();
					?>				
				</div>
			</div>
			<!-- END MAIN MENU -->

			<img src="images/homeImage.jpg" alt="Communicating a product benefit. Creating strong brand image. Visualizing a product idea or concept. That's what I do best."/>
			


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