<?php
	require('includes/connection.inc.php');	
	require('includes/functions.inc.php');
	
	if (function_exists('nukeMagicQuotes')) {
	nukeMagicQuotes();
	}

// process the email
if (array_key_exists('send', $_POST)) {
	$to = 'trtzw@sbcglobal.net'; // use your own email address
	$subject = 'Request for an Estimate';
  
	// list expected fields
	$expected = array('name', 'lastname', 'email', 'phone', 'address1', 'address2', 'city', 'state', 'description');
	// set required fields
	$required = array('name', 'lastname', 'email', 'address1', 'city', 'state', 'description');
	// create empty array for any missing fields
	$missing = array();
  
	// assume that there is nothing suspect
	$suspect = false;
	// create a pattern to locate suspect phrases
	$pattern = '/Content-Type:|Bcc:|Cc:/i';
  
	// function to check for suspect phrases
	function isSuspect($val, $pattern, &$suspect) {
		// if the variable is an array, loop through each element
		// and pass it recursively back to the same function
		if (is_array($val)) {
			foreach ($val as $item) {
				isSuspect($item, $pattern, $suspect);
				}
			}
		else {
			// if one of the suspect phrases is found, set Boolean to true
			if (preg_match($pattern, $val)) {
				$suspect = true;
				}
			}
		}
  
	// check the $_POST array and any sub-arrays for suspect content
	isSuspect($_POST, $pattern, $suspect);
  
	if ($suspect) {
		$mailSent = false;
		unset($missing);
		}
	else {
		// process the $_POST variables
		foreach ($_POST as $key => $value) {
			// assign to temporary variable and strip whitespace if not an array
			$temp = is_array($value) ? $value : trim($value);
			// if empty and required, add to $missing array
			if (empty($temp) && in_array($key, $required)) {
				array_push($missing, $key);
				}
			// otherwise, assign to a variable of the same name as $key
		elseif (in_array($key, $expected)) {
			${$key} = $temp;
			}
		}
	}

 // validate the email address
  if (!empty($email)) {
    // regex to ensure no illegal characters in email address 
	$checkEmail = '/^[^@]+@[^\s\r\n\'";,@%]+$/';
	// reject the email address if it doesn't match
	if (!preg_match($checkEmail, $email)) {
	  array_push($missing, 'email');
		}
	}
 
  // go ahead only if not suspect and all required fields OK
  if (!$suspect && empty($missing)) {
	// build the message
	$message = "Name: $name $lastname\n\n";
	$message .= "Email: $email\n\n";
	$message .= "Phone: $phone\n\n";
	$message .= "Address 1: $address1\n\n";
	$message .= "Address 2: $address2\n\n";
	$message .= "City: $city, $state\n\n";
	$message .= "Job Description: $description";

	// limit line length to 70 characters
	$message = wordwrap($message, 70);
  
	// send it  
	$mailSent = mail($to, $subject, $message);
	if ($mailSent) {
		// $missing is no longer needed if the email is sent, so unset it
		unset($missing);
		}
	}
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
				<div class="menuHolder">
					<?php
						archive_menu();
					?>				
				</div>
			</div>
			<!-- END MAIN MENU -->
			*Required Fields
			<form action="contact.php" method="post">
			<?php
			if ($_POST && isset($missing) && !empty($missing)) {
			?>
			<span class="warning">Please Complete the Missing Item(s).</span><br />
			<?php
			}
			elseif ($_POST && !$mailSent) {
			?>
			<span class="warning">Sorry, there was a problem sending your message. Please try later.</span>
			<?php
			}
			elseif ($_POST && $mailSent) {
			?>
			<span>Your message has been sent. I will get back to you as soon as possible.</span>
			<?php } ?>


				<div id="estimateLeftContainer">


				<p class="subHead1">*First Name <?php
				if (isset($missing) && in_array('name', $missing)) { ?>
				<span class="warning">Please enter your first name</span><?php } ?><br />
				
				<input name="name" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['name']).'"';} ?> />
				</p>

				<p class="subHead1">*Last Name <?php
				if (isset($missing) && in_array('lastname', $missing)) { ?>
				<span class="warning">Please enter your last name</span><?php } ?> <br />

				<input name="lastname" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['lastname']).'"';} ?> />
				</p>

				<p class="subHead1">*Email Address <?php
				if (isset($missing) && in_array('email', $missing)) { ?>
				<span class="warning">Please enter a valid email address</span><?php } ?><br />

				<input name="email" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['email']).'"';} ?> />
				</p>

				<p class="subHead1">Phone Number<br />

				<input name="phone" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['phone']).'"';} ?> />
				</p>

				</div>

				<div id="estimateRightContainer">

					<div id="estimateInnerLeftContainer">

					<p class="subHead1">*Address 1 <?php
				if (isset($missing) && in_array('address1', $missing)) { ?>
				<span class="warning">Please enter your address</span><?php } ?><br />

					<input name="address1" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['address1']).'"';} ?> />
					</p>

					<p class="subHead1">Address 2<br />

					<input name="address2" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['address2']).'"';} ?> />
					</p>

					<p class="subHead1">*City <?php
				if (isset($missing) && in_array('city', $missing)) { ?>
				<span class="warning">Please enter your city</span><?php } ?><br />

					<input name="city" <?php if (isset($missing)) {
				echo 'value="'.htmlentities($_POST['city']).'"';} ?> />
					</p>

					<p class="subHead1">State<br />
					<select name="state">
			<option value="No reply" 
			<?php
			if (!$_POST || $_POST['state'] == 'No reply') { ?>
			selected="selected"
			<?php } ?>
			>Select a State</option>
			
			<option value="Alabama"
			<?php
			if (isset($missing) && $_POST['state'] == 'Alabama') { ?>
			selected="selected"
			<?php } ?>
			>Alabama</option>
			
			<option value="Alaska"
			<?php
			if (isset($missing) && $_POST['state'] == 'Alaska') { ?>
			selected="selected"
			<?php } ?>
			>Alaska</option>
			
			<option value="Arizona"
			<?php
			if (isset($missing) && $_POST['state'] == 'Arizona') { ?>
			selected="selected"
			<?php } ?>
			>Arizona</option>
			
			<option value="Arkansas"
			<?php
			if (isset($missing) && $_POST['state'] == 'Arkansas') { ?>
			selected="selected"
			<?php } ?>
			>Arkansas</option>
			
			<option value="California"
			<?php
			if (isset($missing) && $_POST['state'] == 'California') { ?>
			selected="selected"
			<?php } ?>
			>California</option>
			
			<option value="Colorado"
			<?php
			if (isset($missing) && $_POST['state'] == 'Colorado') { ?>
			selected="selected"
			<?php } ?>
			>Colorado</option>
			
			<option value="Connecticut"
			<?php
			if (isset($missing) && $_POST['state'] == 'Connecticut') { ?>
			selected="selected"
			<?php } ?>
			>Connecticut</option>
			
			<option value="Delaware"
			<?php
			if (isset($missing) && $_POST['state'] == 'Delaware') { ?>
			selected="selected"
			<?php } ?>
			>Delaware</option>
			
			<option value="Florida"
			<?php
			if (isset($missing) && $_POST['state'] == 'Florida') { ?>
			selected="selected"
			<?php } ?>
			>Florida</option>
			
			<option value="Georgia"
			<?php
			if (isset($missing) && $_POST['state'] == 'Georgia') { ?>
			selected="selected"
			<?php } ?>
			>Georgia</option>
			
			<option value="Hawaii"
			<?php
			if (isset($missing) && $_POST['state'] == 'Hawaii') { ?>
			selected="selected"
			<?php } ?>
			>Hawaii</option>
			
			<option value="Idaho"
			<?php
			if (isset($missing) && $_POST['state'] == 'Idaho') { ?>
			selected="selected"
			<?php } ?>
			>Idaho</option>
			
			<option value="Illinois"
			<?php
			if (isset($missing) && $_POST['state'] == 'Illinois') { ?>
			selected="selected"
			<?php } ?>
			>Illinois</option>
			
			<option value="Indiana"
			<?php
			if (isset($missing) && $_POST['state'] == 'Indiana') { ?>
			selected="selected"
			<?php } ?>
			>Indiana</option>
			
			<option value="Iowa"
			<?php
			if (isset($missing) && $_POST['state'] == 'Iowa') { ?>
			selected="selected"
			<?php } ?>
			>Iowa</option>
			
			<option value="Kansas"
			<?php
			if (isset($missing) && $_POST['state'] == 'Kansas') { ?>
			selected="selected"
			<?php } ?>
			>Kansas</option>
			
			<option value="Kentucky"
			<?php
			if (isset($missing) && $_POST['state'] == 'Kentucky') { ?>
			selected="selected"
			<?php } ?>
			>Kentucky</option>
			
			<option value="Louisiana"
			<?php
			if (isset($missing) && $_POST['state'] == 'Louisiana') { ?>
			selected="selected"
			<?php } ?>
			>Louisiana</option>
			
			<option value="Maine"
			<?php
			if (isset($missing) && $_POST['state'] == 'Maine') { ?>
			selected="selected"
			<?php } ?>
			>Maine</option>
			
			<option value="Maryland"
			<?php
			if (isset($missing) && $_POST['state'] == 'Maryland') { ?>
			selected="selected"
			<?php } ?>
			>Maryland</option>
			
			<option value="Massachusetts"
			<?php
			if (isset($missing) && $_POST['state'] == 'Massachusetts') { ?>
			selected="selected"
			<?php } ?>
			>Massachusetts</option>
			
			<option value="Michigan"
			<?php
			if (isset($missing) && $_POST['state'] == 'Michigan') { ?>
			selected="selected"
			<?php } ?>
			>Michigan</option>
			
			<option value="Minnesota"
			<?php
			if (isset($missing) && $_POST['state'] == 'Minnesota') { ?>
			selected="selected"
			<?php } ?>
			>Minnesota</option>
			
			<option value="Mississippi"
			<?php
			if (isset($missing) && $_POST['state'] == 'Mississippi') { ?>
			selected="selected"
			<?php } ?>
			>Mississippi</option>
			
			<option value="Missouri"
			<?php
			if (isset($missing) && $_POST['state'] == 'Missouri') { ?>
			selected="selected"
			<?php } ?>
			>Missouri</option>
			
			<option value="Montana"
			<?php
			if (isset($missing) && $_POST['state'] == 'Montana') { ?>
			selected="selected"
			<?php } ?>
			>Montana</option>
			
			<option value="Nebraska"
			<?php
			if (isset($missing) && $_POST['state'] == 'Nebraska') { ?>
			selected="selected"
			<?php } ?>
			>Nebraska</option>
			
			<option value="Nevada"
			<?php
			if (isset($missing) && $_POST['state'] == 'Nevada') { ?>
			selected="selected"
			<?php } ?>
			>Nevada</option>
			
			<option value="New Hampshire"
			<?php
			if (isset($missing) && $_POST['state'] == 'New Hampshire') { ?>
			selected="selected"
			<?php } ?>
			>New Hampshire</option>
			
			<option value="New Jersey"
			<?php
			if (isset($missing) && $_POST['state'] == 'New Jersey') { ?>
			selected="selected"
			<?php } ?>
			>New Jersey</option>
			
			<option value="New Mexico"
			<?php
			if (isset($missing) && $_POST['state'] == 'New Mexico') { ?>
			selected="selected"
			<?php } ?>
			>New Mexico</option>
			
			<option value="New York"
			<?php
			if (isset($missing) && $_POST['state'] == 'New York') { ?>
			selected="selected"
			<?php } ?>
			>New York</option>
			
			<option value="North Carolina"
			<?php
			if (isset($missing) && $_POST['state'] == 'North Carolina') { ?>
			selected="selected"
			<?php } ?>
			>North Carolina</option>
			
			<option value="North Dakota"
			<?php
			if (isset($missing) && $_POST['state'] == 'North Dakota') { ?>
			selected="selected"
			<?php } ?>
			>North Dakota</option>
			
			<option value="Ohio"
			<?php
			if (isset($missing) && $_POST['state'] == 'Ohio') { ?>
			selected="selected"
			<?php } ?>
			>Ohio</option>
			
			<option value="Oklahoma"
			<?php
			if (isset($missing) && $_POST['state'] == 'Oklahoma') { ?>
			selected="selected"
			<?php } ?>
			>Oklahoma</option>
			
			<option value="Oregon"
			<?php
			if (isset($missing) && $_POST['state'] == 'Oregon') { ?>
			selected="selected"
			<?php } ?>
			>Oregon</option>
			
			<option value="Pennsylvania"
			<?php
			if (isset($missing) && $_POST['state'] == 'Pennsylvania') { ?>
			selected="selected"
			<?php } ?>
			>Pennsylvania</option>
			
			<option value="Rhode Island"
			<?php
			if (isset($missing) && $_POST['state'] == 'Rhode Island') { ?>
			selected="selected"
			<?php } ?>
			>Rhode Island</option>
			
			<option value="South Carolina"
			<?php
			if (isset($missing) && $_POST['state'] == 'South Carolina') { ?>
			selected="selected"
			<?php } ?>
			>South Carolina</option>
			
			<option value="South Dakota"
			<?php
			if (isset($missing) && $_POST['state'] == 'South Dakota') { ?>
			selected="selected"
			<?php } ?>
			>South Dakota</option>
			
			<option value="Tennessee"
			<?php
			if (isset($missing) && $_POST['state'] == 'Tennessee') { ?>
			selected="selected"
			<?php } ?>
			>Tennessee</option>
			
			<option value="Texas"
			<?php
			if (isset($missing) && $_POST['state'] == 'Texas') { ?>
			selected="selected"
			<?php } ?>
			>Texas</option>
			
			<option value="Utah"
			<?php
			if (isset($missing) && $_POST['state'] == 'Utah') { ?>
			selected="selected"
			<?php } ?>
			>Utah</option>
			
			<option value="Vermont"
			<?php
			if (isset($missing) && $_POST['state'] == 'Vermont') { ?>
			selected="selected"
			<?php } ?>
			>Vermont</option>
			
			<option value="Virginia"
			<?php
			if (isset($missing) && $_POST['state'] == 'Virginia') { ?>
			selected="selected"
			<?php } ?>
			>Virginia</option>
			
			<option value="Washington"
			<?php
			if (isset($missing) && $_POST['state'] == 'Washington') { ?>
			selected="selected"
			<?php } ?>
			>Washington</option>
			
			<option value="West Virginia"
			<?php
			if (isset($missing) && $_POST['state'] == 'West Virginia') { ?>
			selected="selected"
			<?php } ?>
			>West Virginia</option>
			
			<option value="Wisconsin"
			<?php
			if (isset($missing) && $_POST['state'] == 'Wisconsin') { ?>
			selected="selected"
			<?php } ?>
			>Wisconsin</option>
			
			<option value="Wyoming"
			<?php
			if (isset($missing) && $_POST['state'] == 'Wyoming') { ?>
			selected="selected"
			<?php } ?>
			>Wyoming</option>
			</select>
					</p>

					</div>

					<div id="estimateInnerRightContainer">
					<p class="subHead1">*Please Describe Your Project<?php
				if (isset($missing) && in_array('description', $missing)) { ?>
				<span class="warning">Please enter a description</span><?php } ?><br />
					<textarea name="description" rows="" cols=""><?php 
				if (isset($missing)) {
				  echo htmlentities($_POST['description']);
				  } ?></textarea>
				</p>

					<p id="submit">
					<input name="send" id="send" type="submit" value="Submit" />
					</p>

					
					
					</div>

				</div>


			</div>
			</form>

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