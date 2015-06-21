<?php
	require_once("includes/connection.inc.php");
	require_once("includes/functions.inc.php");
	
	$errors = array();
	
	
		// define a constant for the maximum upload size
define ('MAX_FILE_SIZE', 5120000);

if (array_key_exists('upload', $_POST)) {
  // define constant for upload folder
  define('UPLOAD_DIR', '../images/projects/');
  // replace any spaces in original filename with underscores
  // at the same time, assign to a simpler variable
  $file = str_replace(' ', '_', $_FILES['image']['name']);
  // convert the maximum size to KB
  $max = number_format(MAX_FILE_SIZE/1024, 1).'KB';
  // create an array of permitted MIME types
  $permitted = array('image/gif', 'image/jpeg', 'image/jpg', 'image/png');
  // begin by assuming the file is unacceptable
  $sizeOK = false;
  $typeOK = false;
  
  // check that file is within the permitted size
  if ($_FILES['image']['size'] > 0 && $_FILES['image']['size'] <= MAX_FILE_SIZE) {
    $sizeOK = true;
	}

  // check that file is of an permitted MIME type
  foreach ($permitted as $type) {
    if ($type == $_FILES['image']['type']) {
      $typeOK = true;
	  break;
	  }
	}
  
  if ($sizeOK && $typeOK) {
    switch($_FILES['image']['error']) {
	  case 0:
		        // check if a file of the same name has been uploaded
		if (!file_exists(UPLOAD_DIR.$file)) {
		  // move the file to the upload folder and rename it
		  $success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$file);
		  }
		else {
		  // get the date and time
		  ini_set('date.timezone', 'Europe/London');
		  $now = date('Y-m-d-His');
		  $success = move_uploaded_file($_FILES['image']['tmp_name'], UPLOAD_DIR.$now.$file);
		  }
		if ($success) {
          $result = "$file uploaded successfully";
	      }
		else {
		  $result = "Error uploading $file. Please try again.";
		  }
	    break;
	  case 3:
		$result = "Error uploading $file. Please try again.";
	  default:
        $result = "System error uploading $file. Contact webmaster.";
	  }
    }
  elseif ($_FILES['image']['error'] == 4) {
    $result = 'No file selected';
	}
  else {
    $result = "$file cannot be uploaded. Maximum size: $max. Acceptable file types: gif, jpg, png.";
	}
  }

	
	$pic = mysql_prep($_FILES['image']['name']);
	$subject = mysql_prep($_POST['subject']);
	$title = mysql_prep($_POST['title']);
	$description = mysql_prep($_POST['description']);
	$link = mysql_prep($_POST['link']);
	
	
	
	
	
	

	$query = "INSERT INTO work (
				artwork, subject_id, title, description, link
			) VALUES (
				'{$pic}', '{$subject}', '{$title}', '{$description}', '{$link}'
			)";
		
	if (mysql_query($query, $connection)) {
		// Success !
		header("Location: newEntry.php?id=success");
		exit;
	} else {
	// Display error Message
		echo "<p>Location creation failed</p>";
		echo "<p> ".mysql_error()." </p>";
	}
?>

<?php
	mysql_close($connection);
?>