<?php
require 'dbconn.php';
?>
<?php

if (isSet($_POST["submit"])) { //submitted form
	$message = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];

	$query1 = "INSERT INTO messageContents(messageConents, type, title) VALUES (?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection->prepare($query1);
	if ($insertMsg = $connection ->prepare($query1)) {
		$insertMsg -> bind_param('sss', $message, $type, $title);
	} else {
		die("Error".$connection ->error);
	}
	mysqli_stmt_execute($insertMsg);
  	mysqli_stmt_close($insertMsg);	
///////////////////////////
}	
?>
<!DOCTYPE html>
<head>
</head>
<body>
	<h3>Please Enter Your Message</h3>
	<form method= 'post' action='messageConfirmation.php' onsubmit= 'messageConfirmation.php'>
		<strong>Title:</strong><br>
		<input type = "text" name = "title" required><br><br>
		<strong>Subject:</strong><br>
		<select name = "subject">
			<option value="tech">Technology</option>
			<option value="science">Science</option>
			<option value="speaker">Speaker Series</option>
			<option value="food">Food</option>
			<option value = "entertainment">Entertainment</option>
			<option value = "other">Other</option>
		</select><br><br>
		<strong>Location:</strong><br>
		<input type = "text" name = "location" required><br><br>
		<strong>Message:</strong><br>
		<input type = "text" name = "message" required><br>
		<input type = "button" name = "img" value = "Upload Image">
		<input type = "submit" value = "Submit Message">
	</form>
</body>
</html>
