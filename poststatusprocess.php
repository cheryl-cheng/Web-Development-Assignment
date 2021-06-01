<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" /> 
		<title>Assignment 1 - Post Status Process</title>
	</head>
<div class="header">
	<h1> Status Posting System </h1>
</div>
<body>
	<div class="content">
	<?php
		// sql info or use include 'file.inc'
		   require_once('../../conf/sqlinfo.inc.php');
		
		// The @ operator suppresses the display of any error messages
		// mysqli_connect returns false if connection failed, otherwise a connection value
		$conn = @mysqli_connect($sql_host,
			$sql_user,
			$sql_pass,
			$sql_db
		);
	  
		// Checks if connection is successful
		if (!$conn) {
			// Displays an error message
			echo "<p>Database connection failure. Please contact the developer for assistance.</p>";
		} else {
			
			// Upon successful connection
			
			// Get data from the form - Will display error message(s) and stop the script if these tests fail.
			$error_set = [];
			// Test if status code is in correct pattern, and is not null.
			if($_POST["statuscode"]!=null){
				$code = $_POST["statuscode"];
				$pattern = "/^S[0-9]{4}$/";
					if(!preg_match($pattern,$code)){
						array_push($error_set, "Please enter a status code using the correct format.");
					}
					else{
					// checks if the status code is unique
					$unique_query = "SELECT * FROM status WHERE code = '$code'";
					$unique_result = mysqli_query($conn, $unique_query);
					// checks if the execution was successful
					if(!$unique_result) {
						//echo "<p>Something is wrong with ",	$unique_query, "</p>";
						echo "<p>Database error: please contact the developer.</p>";
					} else{
						$check_result = mysqli_num_rows($unique_result);
						if($check_result>0){
							array_push($error_set, "The status code: ".$code.", already exists.");
						}
					}
				}
			}else{
				array_push($error_set, "The status code cannot be blank.");
			}
			//Test if status content is in correct pattern, and not null.
			if($_POST["status"]!=null){
				$status = $_POST["status"];
				$pattern = "/^[A-Za-z0-9 ,.!?]+$/";
					if(!preg_match($pattern,$status)){
						array_push($error_set, "The status can only contain alphanumeric characters including spaces, 
						comma, period, exclamation point and question mark. Other characters or symbols are not allowed.");
					}
			}else{
				array_push($error_set, "The status cannot be blank.");
			}
			//Test if Date is not null, and is valid.
			if(isset($_POST["Date"])){
				$date = $_POST["Date"];
				//DateTime doesn't work so checkdate is another alternative.
				//Tokenizes the date into d, m, y.
				$date_test = explode("/", $date);
				#checkdate parameters require month, date, year.
					if(!checkdate((int)$date_test[1], (int)$date_test[0], (int)$date_test[2])){
						array_push($error_set, "Please enter a valid date in the format: dd/mm/yy.");
					}
			}else{
				array_push($error_set, "The date cannot be blank.");
			}
			//Set sharing
			if(isset($_POST["share"])){
				$permission = $_POST["share"];
			}else{
				array_push($error_set, "Please select your sharing preference.");
			}
			//Set permissions, 1 for true and 0 for false.
			$a_like = isset($_POST["allow-like"])?1:0;
			$a_comments = isset($_POST["allow-comments"])?1:0;
			$a_share = isset($_POST["allow-share"])?1:0;
			
			//Prevents database code from running if there are errors, and displays all error message.
			if(!empty($error_set)){
				echo "<p>Error - could not submit your status due to the following: <br></p>";
				echo "<ul>";
				foreach($error_set as $error){
					echo "<li>$error<//li>";
				}
				echo "</ul>";
			} else{
				// If no errors, we can add the fields into the database.
				// Set up the SQL command to add the data into the table
				$query = "insert into $sql_tble"
								."(code, content, a_like, a_comments, a_share, date, permission)"
							. "values"
								."('$code','$status', $a_like, $a_comments, $a_share, '$date', '$permission')";
								
				// executes the query
				$result = mysqli_query($conn, $query);
				// checks if the execution was successful
				if(!$result) {
					//echo "<p>Something is wrong with ",	$query, "</p>";
					//echo "Error description: " .mysqli_error($conn);
					echo "<p>Database error, please contact the developer. </p>";
				} else {
					echo "<p>Successfully posted your status.</p>";
					
				} // if successful query operation
				// Frees up the memory, after using the result pointer
				mysqli_free_result($result);
				// close the database connection
				mysqli_close($conn);
			}
		}  // if successful database connection
	?>
		<div class = "links">
			<a href="http://ghn4826.cmslamp14.aut.ac.nz/assign1">Return to Home Page</a></label>
		</div>
	</div>
</body>
</html> 
