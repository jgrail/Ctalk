<?php
	//session_start();
	require 'dbconn.php';
	$connection = connect_to_db("ClaremontTalk");

	$messageContents = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];
	$name = $_POST['name'];
	
	//TODO: look up userID from db using email from session variable
	
	//$userID = $_SESSION['userID'];
	$userID = 1;
	//TODO "stateless design?"

	echo $messageContents;
	echo $type;
	echo $title;
	echo $name;
	$approved = 0;
	$query1 = "INSERT INTO Messages (name, messageContents, type, title, approved, userID) VALUES (?,?,?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection-> prepare($query1);
	if ($insertMsg) {
		
		$insertMsg -> bind_param('ssssii', $name, $messageContents, $type, $title, $approved, $userID);
		echo "here";
	} else {
		die("Error".$connection ->error);
	}
	echo "HELLO!";

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
	<a href="viewMessages.php">View Message Board</a><br>
	<a href ="message.php">Post New Message</a>
</body>
</html>
