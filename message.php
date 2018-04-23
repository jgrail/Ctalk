<?php
require 'dbconn.php';
?>

<!DOCTYPE html>
<head>
	<title>Create Message</title>
	<link rel="stylesheet" href="CTalkStyle.css">
</head>
<body  class = "msg" style = "background-color: #ccf6ff">
	<h2>Enter Your Message</h2>
	<p>Please fill out the following fields to submit your message.</p>
	<img src = "http://www.kgi.edu/Images/About_KGI/400x300_Claremont-Colleges.jpg" style= "float:right">
	
	<form method= "post" action='messageConfirmation.php'>
		<strong>Title:</strong><br>
		<input type = "text" name = "title" required><br><br>
		<strong>Subject:</strong><br>
		<select name = "subject">
			<option value="tech">Technology</option>
			<option value="science">Science</option>
			<option value="speaker">Speaker Series</option>
			<option value="food">Food</option>
			<option value = "gov">Government</option>
			<option value = "art">Art</option>
			<option value = "entertainment">Entertainment</option>
			<option value = "other">Other</option>
		</select><br><br>
		<strong>Name:</strong><br>
		<input type = "text" name = "name" required><br><br>
		<strong>Location:</strong><br>
		<input type = "text" name = "location" required><br><br>
		<strong>Message:</strong><br>
		<textarea rows = "7" cols="50" name = "message" required></textarea><br>
		<!--<input type = "text" rows = "10" name = "message" required><br>-->
		<input type="file" name="img" accept="image/*" value = "Upload Image">
		<input type = "submit" class = "button" value = "Submit Message">
	</form>
</body>
</html>
