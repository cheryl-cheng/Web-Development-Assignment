<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" /> 
		<title>Assignment 1 - Search Status Process</title>
	</head>
<div class="header">
	<h1> Status Posting System </h1>
</div>
<body>
	<div class="content">
		<h3> Status Information </h3>
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

			// Checks if search is empty, or if the pattern does not match the required input.
			$search = '';
			if($_GET["Search"]!=""){
				$search = $_GET["Search"];
				$pattern = "/^[A-Za-z0-9 ,.!?]+$/";
					if(!preg_match($pattern,$search)){
						echo "<p>The status can only contain alphanumeric characters including spaces, 
						comma, period, exclamation point and question mark. Other characters or symbols are not allowed.
						Please try again.</p>";
					}
			}else{
				echo "<p>The status cannot be blank.</p>";
			}
			
			if(!empty($search)){
				// Set up the SQL command to retrieve the data from the table
				// % symbol represent a wildcard to match any characters
				// like is a compairson operator
				$query = "select * from $sql_tble where content like '%$search%'";
			
				// executes the query and store result into the result pointer
				$result = mysqli_query($conn, $query);
				//pointer for formatting line breaks in the while loop.
				$i = 1;
				// checks if the execuion was successful
				if(!$result) {
					//echo "<p>Something is wrong with ",	$query, "</p>";
					//echo "Error description: " .mysqli_error($conn);
					echo "<p>Database error, please contact the developer. </p>";
				} else if (mysqli_num_rows($result)==0){
					echo "<p>There is no existing status containing: \"$search\". Please try again.</p>";
				} else {
					// retrieve current record pointed by the result pointer
					while ($row = mysqli_fetch_assoc($result)){
						
						//Tokenize the date to format it for publishing
						$d = $row["date"];
						$date = explode("/", $d);
						//convert the month to a word and replace the value
						$month_to_word = date("F", mktime(0,0,0,$date[1],10));
						$date[1] = $month_to_word;
						
						//Find which permissions are set, and join them together in a string.
						$allow_array = ["a_like", "a_comments", "a_share"];
						$allow_string = "";
						//if the permission is set as true (1), it will be added to the string.
						foreach ($allow_array as $value){
							if($row["$value"] == 1){
								$allow_string .= $value;
								$allow_string .= ", ";
							}
						}
						//Converts the permissions back into readable text.
						$allow_string = str_replace("a_like", "Allow Like", $allow_string);
						$allow_string = str_replace("a_comments", "Allow Comments", $allow_string);
						$allow_string = str_replace("a_share", "Allow Share", $allow_string);
						//Trims the comma at the end of the string for formatting.
						$allow_string = rtrim($allow_string, ", ");
						
						//if it is the first entry, it will not print a line break before the horizontal rule
						if($i==1){
							echo "<hr><br>";
						}
						else{
							echo "<br><hr><br>";
						}
						//Display results
						echo "Status: ",$row["content"],"<br>";
						echo "Status Code: ".$row["code"]."<br><br>";
						echo "Share: ".$row["permission"]."<br>";
						echo "Date Posted: $date[1] $date[0], $date[2]<br>";
						echo "Permission: $allow_string<br>";
						//increment the pointer for line break
						$i++;
					}
					echo "<br><hr>";
					// Frees up the memory, after using the result pointer
					mysqli_free_result($result); 
				}
			}	
		}
		// close the database connection
		mysqli_close($conn);
	?>
		<div class = "links">
			<a href="http://ghn4826.cmslamp14.aut.ac.nz/assign1/searchstatusform.html">Search for another status</a>
			<a href="http://ghn4826.cmslamp14.aut.ac.nz/assign1" style = "float: right;">Return to Home Page</a>
		</div>
	</div>
</body>
</html>




