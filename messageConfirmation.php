<?php
	//session_start();
	require 'dbconn.php';
	$connection = connect_to_db("ClaremontTalk");

	$message = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];
	echo $message;
	$query1 = "INSERT INTO Message (messageContents, type, title, approved) VALUES (?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection-> prepare($query1);
	if ($insertMsg = $connection -> prepare($query1)) {
		$insertMsg -> bind_param('ssss', $message, $type, $title, '0');
		echo "here";
	} else {
		die("Error".$connection ->error);
	}
	mysqli_stmt_execute($insertMsg);
  	mysqli_stmt_close($insertMsg);	
?>
<!DOCTYPE html>
<head>
</head>
<body>
	<?php 
	echo $_POST['subject'];
	?>
	<h2>Your Message Has Been Recorded</h2>
	<p>Thank you for posting your message! It will be distributed on Claremont Talk once it is validated by our administrators.
	</p>
	<a href="board.php">View Message Board</a><br>
	<a href ="message.php">Post New Message</a>
</body>
</html>
