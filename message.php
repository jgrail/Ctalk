<?php
require 'dbconn.php';

?>
<?php

if (isSet($_POST['submit'])) { //submitted form
	echo "this far";
	
///////////////////////////
}	
?>
<!DOCTYPE html>
<head>
</head>
<body>
	<h2>Enter Your Message</h2>
	<p>Please fill out the following fields to submit your message.</p>
	<form method= "post" action='messageConfirmation.php' onsubmit= 'messageConfirmation.php'>
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
		<strong>Location:</strong><br>
		<input type = "text" name = "location" required><br><br>
		<strong>Message:</strong><br>
		<textarea rows = "7" cols="50" name = "message" required></textarea><br>
		<!--<input type = "text" rows = "10" name = "message" required><br>-->
		<input type = "button" name = "img" value = "Upload Image">
		<input type = "submit" value = "Submit Message">
	</form>
</body>
</html>
