<!DOCTYPE html> 
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="style.css" type="text/css" /> 
		<title>Assignment 1 - Post Status Form</title>
	</head>
<div class="header">
	<h1> Status Posting System </h1>
</div>
<body>
	<form action = "poststatusprocess.php" method = "post" >
		<table>
			<tr>
				<td>Status code (required): </td>
				<td><input type="text" name="statuscode"></td>
			</tr>
			<tr>
				<td>Status (required): </td>
				<td><input type="text" name="status"></td>
			</tr>
			<tr>
				<td>Share:</td>
				<td>
					<label class="container">Public
					<input type = "radio" id = "public" name = "share" value = "Public">
					<span class="checkmark_radio"></span>
					</label>
					<label class="container">Friends
					<input type = "radio" id = "friends" name = "share" value = "Friends">
					<span class="checkmark_radio"></span>
					</label>
					<label class="container">Only Me
					<input type = "radio" id = "only-me" name = "share" value = "Only Me">
					<span class="checkmark_radio"></span>
					</label>
				</td>
			</tr>
			<tr>
				<td>Date: </td>
				<td><input type="text" name = "Date" value="<?php print(date('d/m/Y')); ?>"></td>
			</tr>
			<tr>
				<td>Permission Type:</td>
			</tr>
		</table>
		<label class="container">Allow Like
			<input type="checkbox" id="allow-like" name="allow-like" value="allow-like">
			<span class="checkmark"></span>
			</label>
			<label class="container">Allow Comments
			<input type="checkbox" id="allow-comments" name="allow-comments" value="allow-comments">
			<span class="checkmark"></span>
			</label>
			<label class="container">Allow Share
			<input type="checkbox" id="allow-share" name="allow-share" value="allow-share">
			<span class="checkmark"></span>
		</label>
		<br><br>
		<input type = "submit" class = "button" value = "Post">
		<input type = "reset" ID = "reset_button" class = "button" value = "Reset">
	</form>
	<div class = "links">
		<a href="http://ghn4826.cmslamp14.aut.ac.nz/assign1">Return to Home Page</a>
	</div>
</body>
</html>