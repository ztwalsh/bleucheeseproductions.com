<?php
	require_once("includes/connection.inc.php");
	require_once("includes/functions.inc.php");
	
	if (isset($_POST['submit'])) {
		$errors = array();
		
		$required_fields = array ('address1', 'loc_city', 'loc_state', 'zipcode', 'rent', 'description');
		foreach ($required_fields as $fieldname) {
			if (!isset($_POST[$fieldname]) || (empty($_POST[$fieldname]) && !is_int($_POST[$fieldname]))) {
				$errors[] = $fieldname;
			}		
		}
		
		if (empty($errors)) {
			// Perform Update
			$id = $_GET['id'];
			$address1 = mysql_prep($_POST['address1']); 
			$address2 = mysql_prep($_POST['address2']); 
			$loc_city = mysql_prep($_POST['loc_city']); 
			$loc_state = mysql_prep($_POST['loc_state']); 
			$zipcode = mysql_prep($_POST['zipcode']); 
			$rent = mysql_prep($_POST['rent']);
			$av_month = mysql_prep($_POST['av_month']); 
			$av_day = mysql_prep($_POST['av_day']);
			$av_year = mysql_prep($_POST['av_year']); 
			$beds = mysql_prep($_POST['bedrooms']); 
			$baths = mysql_prep($_POST['bathrooms']); 
			$squarefootage = mysql_prep($_POST['squarefootage']);
			$parking = mysql_prep($_POST['parking']);
			$laundry = mysql_prep($_POST['laundry']);
			$ut_heat = mysql_prep($_POST['ut_heat']);
			$ut_ac = mysql_prep($_POST['ut_ac']);
			$ut_gas = mysql_prep($_POST['ut_gas']);
			$ut_water = mysql_prep($_POST['ut_water']);
			$ut_cable = mysql_prep($_POST['ut_cable']);
			$ut_internet = mysql_prep($_POST['ut_internet']);
			$description = mysql_prep($_POST['description']);
			
			$update_query = "UPDATE properties SET 
					address1 = '{$address1}', 
					address2 = '{$address2}', 
					loc_city = '{$loc_city}', 
					loc_state = '{$loc_state}', 
					zip = '{$zipcode}', 
					rent = '{$rent}', 
					av_month = '{$av_month}', 
					av_day = '{$av_day}', 
					av_year = '{$av_year}', 
					beds = '{$beds}', 
					baths = '{$baths}', 
					squarefootage = '{$squarefootage}', 
					parking = '{$parking}', 
					laundry = '{$laundry}', 
					ut_heat = '{$ut_heat}', 
					ut_ac = '{$ut_ac}', 
					ut_gas = '{$ut_gas}', 
					ut_water = '{$ut_water}', 
					ut_cable = '{$ut_cable}', 
					ut_internet = '{$ut_internet}', 
					description = '{$description}' 
					WHERE id={$id}";
					
			$update_result = mysql_query($update_query);
			if (mysql_affected_rows() == 1) {
				// Success
				$success_mes = "This property has been updated.";
			} else {
				// Failed
				$error_mes = "The subject update failed";
				$error_mes .= "<br />".mysql_error();
			}
			
		} else {
			//Errors Occurred
			$error_mes = "There were ". count($errors)." errors in the form.";
		}
		
	}
	
	$query = "SELECT * FROM properties WHERE id=".$_GET['id']."";
	$query_result = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_array($query_result);
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">


	<head>
		<title><?php echo $row['address1']; ?></title>
		<link href="../css/sitestyles.css" rel="stylesheet" type="text/css" media="screen" />
		<link href="../css/jqgalscroll.css" rel="stylesheet" type="text/css" media="screen" />
		<link rel="shortcut icon" href="images/favicon.ico" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="Description" content="" />
		<meta name="Keywords" content="" />
		
		<script type="text/javascript" src="../js/jquery.js"></script>
		<script type="text/javascript" src="../js/jqgalscroll.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#demoOne").jqGalScroll();
			});
		</script>
		
	</head>
	<body>
	
	
	<!-- START TOP CONTAINER -->
	<div id="top_container">
		
		<!-- START TOP INFO CONTAINER -->
		<div id="top_info_container">
		
			<!-- START LOGO CONTAINER -->
			<div id="logo_container">
				<a href="index.php"><img src="../images/adminlogo.jpg" alt="Hannibal Properties" /></a>	
			</div>
			<!-- START LOGO CONTAINER -->
			
		</div>
		<!-- START TOP INFO CONTAINER -->
		
	</div>
	<!-- END TOP CONTAINER -->
	
	
	<!-- START FADE CONTAINER -->
	<div id="fade_container">
	
		<?php include("includes/adminmenu.inc.php"); ?>
	
	</div>
	<!-- END FADE CONTAINER -->
	
	
	
	<!-- START LINK MAP CONTAINER -->
	<div id="link_map_container">
		<a href="properties.php">Properties</a> > <a href="editproperty.php?id=<?php echo $row['id']; ?>"><?php echo $row['address1']; ?></a>
	</div>
	<!-- END LINK MAP CONTAINER -->
	
	

	<!-- START MAIN CONTAINER -->
	<div id="main_container">
		<h1><?php echo $row['address1']; ?></h1>
		<p><span class="red"> <img src="../images/icons/delete.png" /> <a href="deleteproperty.php?id=<?php echo $row['id'];?>">Delete <?php echo $row['address1']; ?></a></span></p>
		
			<?php
				if (!empty($success_mes)) {
					echo "<p class=\"message\">".$success_mes."</p>";
				}
			?>
			
			<?php
				if (!empty($errors)) {
					echo "<p class=\"errors\">";
					echo $error_mes."<br />";
					echo "Please review the following fields:<br />";
					foreach($errors as $error) {
						echo " - ".$error."<br />";
					}
					echo "</p>";
				}
			?>
		
		<form action="editproperty.php?id=<?php echo $_GET['id']; ?>" method="post">
		<div class="column_one">
			
			<p><strong>Address 1</strong><br />
			<input type="text" name="address1" value="<?php if(isset($row['address1'])) { echo $row['address1']; } ?>" />
			</p>
			
			<p><strong>Address 2</strong><br />
			<input type="text" name="address2" value="<?php if(isset($row['address2'])) { echo $row['address2']; } ?>" />
			</p>
			
			<p><strong>City</strong><br />
			<input type="text" name="loc_city" value="<?php if(isset($row['loc_city'])) { echo $row['loc_city']; } ?>" />
			</p>
			
			<p><strong>State</strong><br />
			<select name="loc_state">
					<option>Select State</option> 
					<option value="Alabama" <?php if($row['loc_state'] == "Alabama"){ echo "selected=\"selected\"";}?>>Alabama</option> 
					<option value="Alaska" <?php if($row['loc_state'] == "Alaska"){ echo "selected=\"selected\"";}?>>Alaska</option> 
					<option value="Arizona" <?php if($row['loc_state'] == "Arizona"){ echo "selected=\"selected\"";}?>>Arizona</option> 
					<option value="Arkansas" <?php if($row['loc_state'] == "Arkansas"){ echo "selected=\"selected\"";}?>>Arkansas</option> 
					<option value="California" <?php if($row['loc_state'] == "California"){ echo "selected=\"selected\"";}?>>California</option> 
					<option value="Colorado" <?php if($row['loc_state'] == "Colorado"){ echo "selected=\"selected\"";}?>>Colorado</option> 
					<option value="Connecticut" <?php if($row['loc_state'] == "Connecticut"){ echo "selected=\"selected\"";}?>>Connecticut</option> 
					<option value="Delaware" <?php if($row['loc_state'] == "Delaware"){ echo "selected=\"selected\"";}?>>Delaware</option>  
					<option value="Florida" <?php if($row['loc_state'] == "Florida"){ echo "selected=\"selected\"";}?>>Florida</option> 
					<option value="Georgia" <?php if($row['loc_state'] == "Georgia"){ echo "selected=\"selected\"";}?>>Georgia</option> 
					<option value="Hawaii" <?php if($row['loc_state'] == "Hawaii"){ echo "selected=\"selected\"";}?>>Hawaii</option> 
					<option value="Idaho" <?php if($row['loc_state'] == "Idaho"){ echo "selected=\"selected\"";}?>>Idaho</option> 
					<option value="Illinois" <?php if($row['loc_state'] == "Illinois"){ echo "selected=\"selected\"";}?>>Illinois</option> 
					<option value="Indiana" <?php if($row['loc_state'] == "Indiana"){ echo "selected=\"selected\"";}?>>Indiana</option> 
					<option value="Iowa" <?php if($row['loc_state'] == "Iowa"){ echo "selected=\"selected\"";}?>>Iowa</option> 
					<option value="Kansas" <?php if($row['loc_state'] == "Kansas"){ echo "selected=\"selected\"";}?>>Kansas</option> 
					<option value="Kentucky" <?php if($row['loc_state'] == "Kentucky"){ echo "selected=\"selected\"";}?>>Kentucky</option> 
					<option value="Louisiana" <?php if($row['loc_state'] == "Louisiana"){ echo "selected=\"selected\"";}?>>Louisiana</option> 
					<option value="Maine" <?php if($row['loc_state'] == "Maine"){ echo "selected=\"selected\"";}?>>Maine</option> 
					<option value="Maryland" <?php if($row['loc_state'] == "Maryland"){ echo "selected=\"selected\"";}?>>Maryland</option> 
					<option value="Massachusetts" <?php if($row['loc_state'] == "Massachusettes"){ echo "selected=\"selected\"";}?>>Massachusetts</option> 
					<option value="Michigan" <?php if($row['loc_state'] == "Michigan"){ echo "selected=\"selected\"";}?>>Michigan</option> 
					<option value="Minnesota" <?php if($row['loc_state'] == "Minnesota"){ echo "selected=\"selected\"";}?>>Minnesota</option> 
					<option value="Mississippi" <?php if($row['loc_state'] == "Mississippi"){ echo "selected=\"selected\"";}?>>Mississippi</option> 
					<option value="Missouri" <?php if($row['loc_state'] == "Missouri"){ echo "selected=\"selected\"";}?>>Missouri</option> 
					<option value="Montana" <?php if($row['loc_state'] == "Montana"){ echo "selected=\"selected\"";}?>>Montana</option> 
					<option value="Nebraska" <?php if($row['loc_state'] == "Nebraska"){ echo "selected=\"selected\"";}?>>Nebraska</option> 
					<option value="Nevada" <?php if($row['loc_state'] == "Nevada"){ echo "selected=\"selected\"";}?>>Nevada</option> 
					<option value="New Hampshire" <?php if($row['loc_state'] == "New Hampshire"){ echo "selected=\"selected\"";}?>>New Hampshire</option> 
					<option value="New Jersey" <?php if($row['loc_state'] == "New Jersey"){ echo "selected=\"selected\"";}?>>New Jersey</option> 
					<option value="New Mexico" <?php if($row['loc_state'] == "New Mexico"){ echo "selected=\"selected\"";}?>>New Mexico</option> 
					<option value="New York" <?php if($row['loc_state'] == "New York"){ echo "selected=\"selected\"";}?>>New York</option> 
					<option value="North Carolina" <?php if($row['loc_state'] == "North Carolina"){ echo "selected=\"selected\"";}?>>North Carolina</option> 
					<option value="North Dakota" <?php if($row['loc_state'] == "North Dakota"){ echo "selected=\"selected\"";}?>>North Dakota</option> 
					<option value="Ohio" <?php if($row['loc_state'] == "Ohio"){ echo "selected=\"selected\"";}?>>Ohio</option> 
					<option value="Oklahoma" <?php if($row['loc_state'] == "Oklahoma"){ echo "selected=\"selected\"";}?>>Oklahoma</option> 
					<option value="Oregon" <?php if($row['loc_state'] == "Oregon"){ echo "selected=\"selected\"";}?>>Oregon</option> 
					<option value="Pennsylvania" <?php if($row['loc_state'] == "Pennsylvania"){ echo "selected=\"selected\"";}?>>Pennsylvania</option> 
					<option value="Rhode Island" <?php if($row['loc_state'] == "Rhode Island"){ echo "selected=\"selected\"";}?>>Rhode Island</option> 
					<option value="South Carolina" <?php if($row['loc_state'] == "South Carolina"){ echo "selected=\"selected\"";}?>>South Carolina</option> 
					<option value="South Dakota" <?php if($row['loc_state'] == "South Dakota"){ echo "selected=\"selected\"";}?>>South Dakota</option> 
					<option value="Tennessee" <?php if($row['loc_state'] == "Tennessee"){ echo "selected=\"selected\"";}?>>Tennessee</option> 
					<option value="Texas" <?php if($row['loc_state'] == "Texas"){ echo "selected=\"selected\"";}?>>Texas</option> 
					<option value="Utah" <?php if($row['loc_state'] == "Utah"){ echo "selected=\"selected\"";}?>>Utah</option> 
					<option value="Vermont" <?php if($row['loc_state'] == "Vermont"){ echo "selected=\"selected\"";}?>>Vermont</option> 
					<option value="Virginia" <?php if($row['loc_state'] == "Virginia"){ echo "selected=\"selected\"";}?>>Virginia</option> 
					<option value="Washington" <?php if($row['loc_state'] == "Washington"){ echo "selected=\"selected\"";}?>>Washington</option> 
					<option value="West Virginia" <?php if($row['loc_state'] == "West Virginia"){ echo "selected=\"selected\"";}?>>West Virginia</option> 
					<option value="Wisconsin" <?php if($row['loc_state'] == "Wisconsin"){ echo "selected=\"selected\"";}?>>Wisconsin</option> 
					<option value="Wyoming" <?php if($row['loc_state'] == "Wyoming"){ echo "selected=\"selected\"";}?>>Wyoming</option>
				</select>
			</p>
			
			<p><strong>Zip Code</strong><br />
			<input type="text" name="zipcode"  value="<?php if(isset($row['zip'])) { echo $row['zip']; } ?>" />
			</p>
			
			<p><strong>Rental Rate</strong> <em>(i.e. 800, 1150)</em><br />
			<input type="text" name="rent" value="<?php if(isset($row['rent'])) { echo $row['rent']; } ?>" />
			</p>
			
			<p><strong>Select Availability</strong><br />
			<select name="av_month">
				<option>Month</option>
				<option value="January" <?php if($row['av_month'] == "January"){ echo "selected=\"selected\"";}?>>January</option>
				<option value="February" <?php if($row['av_month'] == "February"){ echo "selected=\"selected\"";}?>>February</option>
				<option value="March" <?php if($row['av_month'] == "March"){ echo "selected=\"selected\"";}?>>March</option>
				<option value="April" <?php if($row['av_month'] == "April"){ echo "selected=\"selected\"";}?>>April</option>
				<option value="May" <?php if($row['av_month'] == "May"){ echo "selected=\"selected\"";}?>>May</option>
				<option value="June" <?php if($row['av_month'] == "June"){ echo "selected=\"selected\"";}?>>June</option>
				<option value="July" <?php if($row['av_month'] == "July"){ echo "selected=\"selected\"";}?>>July</option>
				<option value="August" <?php if($row['av_month'] == "August"){ echo "selected=\"selected\"";}?>>August</option>
				<option value="September" <?php if($row['av_month'] == "September"){ echo "selected=\"selected\"";}?>>September</option>
				<option value="October" <?php if($row['av_month'] == "October"){ echo "selected=\"selected\"";}?>>October</option>
				<option value="November" <?php if($row['av_month'] == "November"){ echo "selected=\"selected\"";}?>>November</option>
				<option value="December" <?php if($row['av_month'] == "December"){ echo "selected=\"selected\"";}?>>December</option>
			</select>
			
			<select name="av_day">
				<option>Select Day</option>
				<?php
					$count = 1;
					while ($count < 32) {
						echo "<option value=\"".$count."\"";
							if ($row['av_day'] == $count) {
								echo " selected=\"selected\"";
							}
						echo ">".$count."</option>";
						$count++;		
					}
				?>		
			</select>
			
			<select name="av_year">
				<option>Select Year</option>
				<?php
					$count = date('Y');
					$limit = $count+3;
					while ($count <= $limit) {
						echo "<option value=\"".$count."\"";
							if ($row['av_year'] == $count) {
								echo " selected=\"selected\"";
							}
						echo ">".$count."</option>";
						$count++;		
					}
				?>
			</select>
			</p>
			
		</div>
		
		<div class="column_two">
			
			<p><strong>Bedrooms</strong><br />
			<select name="bedrooms">
				<option>Select Bedrooms</option>
				<?php
					$count = 1;
					while ($count < 5) {
						echo "<option value=\"".$count."\"";
							if ($row['beds'] == $count) {
								echo " selected=\"selected\"";
							}
						echo ">".$count." Bedrooms</option>";
						$count++;		
					}
				?>		
			</select>
			</p>
			
			<p><strong>Bathrooms</strong><br />
			<select name="bathrooms">
				<option>Select Bathrooms</option>
				<?php
					$count = 1;
					while ($count < 5) {
						echo "<option value=\"".$count."\"";
							if ($row['baths'] == $count) {
								echo " selected=\"selected\"";
							}
						echo ">".$count." Bathrooms</option>";
						$count++;		
					}
				?>		
			</select>
			</p>
			
			<p><strong>Square Footage</strong> <em>(ex. 1250)</em><br />
			<input type="text" name="squarefootage"  value="<?php if(isset($row['squarefootage'])) { echo $row['squarefootage']; } ?>" />
			</p>
			
			<p><strong>Parking</strong><br />
			<select name="parking">
				<option>Select</option>
				<option value="Garage" <?php if($row['parking'] == "Garage"){ echo "selected=\"selected\"";}?>>Garage</option>
				<option value="Carport"<?php if($row['parking'] == "Carport"){ echo "selected=\"selected\"";}?>>Carport</option>
				<option value="Driveway"<?php if($row['parking'] == "Driveway"){ echo "selected=\"selected\"";}?>>Driveway</option>
				<option value="Street Parking"<?php if($row['parking'] == "Street Parking"){ echo "selected=\"selected\"";}?>>Street Parking</option>
				<option value="None"<?php if($row['parking'] == "None"){ echo "selected=\"selected\"";}?>>None</option>		
			</select>
			</p>
			
			<p><strong>Laundry Facilities</strong><br />
			<select name="laundry">
				<option>Select</option>
				<option value="In-Unit" <?php if($row['laundry'] == "In-Unit"){ echo "selected=\"selected\"";}?>>In-Unit</option>
				<option value="On Site" <?php if($row['laundry'] == "On Site"){ echo "selected=\"selected\"";}?>>On Site</option>
				<option value="None" <?php if($row['laundry'] == "None"){ echo "selected=\"selected\"";}?>>None</option>	
			</select>
			</p>
			
			<p><strong>Utlities Included</strong><br />
			<select name="ut_heat">
				<option>Heat</option>
				<option value="Included" <?php if($row['ut_heat'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_heat'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			<select name="ut_ac">
				<option>A/C</option>
				<option value="Included" <?php if($row['ut_ac'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_ac'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			<select name="ut_gas">
				<option>Gas</option>
				<option value="Included" <?php if($row['ut_gas'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_gas'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			<select name="ut_water">
				<option>Water</option>
				<option value="Included" <?php if($row['ut_water'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_water'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			<select name="ut_cable">
				<option>Cable</option>
				<option value="Included" <?php if($row['ut_cable'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_cable'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			<select name="ut_internet">
				<option>Internet</option>
				<option value="Included" <?php if($row['ut_internet'] == "Included"){ echo "selected=\"selected\"";}?>>Included</option>
				<option value="Not Included" <?php if($row['ut_internet'] == "Not Included"){ echo "selected=\"selected\"";}?>>Not Included</option>	
			</select>
			</p>
			
		</div>
		
		<div class="column_three">
			<p><strong>Description</strong><br />
			<textarea name="description"><?php if(isset($row['description'])) { echo $row['description']; } ?></textarea>
			</p>
			
		</div>
		
		
		<div class="clear"></div>
		
		
		
		<div class="two_columns">
			<p><strong>Photos</strong><br />
			<span class="green"><img src="../images/icons/add.png" /> <a href="addphoto.php">Add Photo</a></span> &nbsp; <span class="red"> <img src="../images/icons/delete.png" /> <a href="deletephoto.php">Delete this Photo</a></span>
			<p>
			
			<?php
				$photo_query = "SELECT * FROM photos WHERE property_id=".$_GET['id']."";
				$photo_query_result = mysql_query($photo_query) or die(mysql_errors());
			?>
			<ul id="demoOne">
			<?php
				while($photo_row = mysql_fetch_array($photo_query_result)) {	
			?>
				<li><img src="../images/projects/<?php echo $photo_row['filename']; ?>" /></li>
			<?php } ?>
			</ul>
			
		</div>
		
		<div class="column_three">
			<p><strong>PDFs</strong><br />
			<span class="green"><img src="../images/icons/add.png" /> <a href="addpdf.php">Add Document</a></span>
			</p>
			<p>
			<a href="" target="_blank">Application (PDF)</a> &nbsp; <span class="red"> <img src="../images/icons/delete.png" /> <a href="deletepdf.php">Delete</a></span> 
		
		</div>
		
		<div class="clear"></div>
		<p>
		<input type="submit" name="submit" id="submit" value="Save" /> <a href="properties.php">Cancel</a>
		</p>
		</form>
		
	</div>
	<!-- END MAIN CONTAINER -->
	
	
	
	<?php include("includes/adminfooter.inc.php"); ?>
	
	

	</body>
</html>