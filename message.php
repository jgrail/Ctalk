<?php
session_start();
require 'ddl.sql';
require 'dbconn.php';
/*define('DBHOST',"localhost");
define('DBNAME',"ClaremontTalk");
define('DBUSER',"Claremont");
define('DBPASS',"talk");

$connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);

if ($connection -> connect_error) {
	$output = "<P>Unable to connect to database</p>".$connection -> connect_error;
	exit($output);
}

$sql = "GRANT USAGE On *.* to ".DBUSER. '@localhost identified by ' . "'" . DBPASS . "'"; */
	//echo $output;
?>
<?php

if (isSet($_POST["submit"])) { //submitted form
	 //validate firstname
	$message = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];

	$query1 = "INSERT INTO messageContents(messageConents, type, title) VALUES (?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection->prepare($query1);
	if ($insertMsg = $connection ->prepare($query1)) {
		$insertMsg -> bind_param('sss' $message, $type, $title);
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
	<form method= 'post' action = "messageConfirmation.php">
		Title:
		<input type = "text" name = "title" required>
		Subject:
		<select name = "subject">
			<option value="tech">Technology</option>
			<option value="science">Science</option>
			<option value="speaker">Speaker Series</option>
			<option value="food">Food</option>
			<option value = "entertainment">Entertainment</option>
			<option value = "other">Other</option>
		</select>
		Location:
		<input type = "text" name = "location" required>
		Message:
		<input type = "text" name = "message" required>
		<input type = "button" name = "img" value = "Upload Image">
		<input type = "submit" value = "Submit Message">
	</form>
</body>
</html>
