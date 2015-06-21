<ul>
					<?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
					<li <?php if($currentPage == "admin.php"){echo "id=\"selected\"";} ?>><a href="admin.php">Admin Home</a></li>
					<li <?php if($currentPage == "newEntry.php"){echo "id=\"selected\"";} ?>><a href="newEntry.php">Create New Entry</a></li>
					<li <?php if($currentPage == "newUser.php"){echo "id=\"selected\"";} ?>><a href="newUser.php">Create New User</a></li>
					<li><a href="logout.php">Log Out</a></li>
				</ul>