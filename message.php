<?php
require 'dbconn.php';

?>
<?php
if (isSet($_POST['submit'])) { //submitted form
	echo "this far";
	$message = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];
	echo $message;
	$query1 = "INSERT INTO Message (messageConents, type, title, approved) VALUES (?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection->prepare($query1);
	if ($insertMsg = $connection ->prepare($query1)) {
		$insertMsg -> bind_param('ssss', $message, $type, $title, '0');
		echo "here";
	} else {
		die("Error".$connection ->error);
	}
	mysqli_stmt_execute($insertMsg);
  	mysqli_stmt_close($insertMsg);	
}	
?>
<!DOCTYPE html>
<head>
	<title>Create Message</title>
</head>
<body>
	<h2>Enter Your Message</h2>
	<p>Please fill out the following fields to submit your message.</p>
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
		<input type = "submit" value = "Submit Message">
	</form>
</body>
</html>
