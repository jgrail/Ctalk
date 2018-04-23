<?php
	//session_start();
	require 'dbconn.php';
	$connection = connect_to_db("ClaremontTalk");

	$messageContents = ($_POST['message']);
	$type = $_POST['subject'];
	$title = $_POST['title'];
	$name = $_POST['name'];
	$image = $_POST['img'];
	
	//TODO: look up userID from db using email from session variable
	
	//$userID = $_SESSION['userID'];
	$userID = 1;
	//TODO "stateless design?"

	//echo $messageContents;
	//echo $type;
	//echo $title;
	//echo $name;
	$approved = 0;
	$query1 = "INSERT INTO Messages (name, messageContents, type, title, approved, userID, photo) VALUES (?,?,?,?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection-> prepare($query1);
	if ($insertMsg) {
		
		$insertMsg -> bind_param('ssssiib', $name, $messageContents, $type, $title, $approved, $userID, $image);
		//echo "here";
	} else {
		die("Error".$connection ->error);
	}
	//echo "HELLO!";

	mysqli_stmt_execute($insertMsg);
  	mysqli_stmt_close($insertMsg);	
?>
<!DOCTYPE html>
<head>
	<title>Message Confirmation</title>
</head>
<body>
	<?php 
	//echo $_POST['subject'];
	?>
	<h2>Your Message Has Been Recorded</h2>
	<p>Thank you for posting your message! It will be distributed on Claremont Talk once it is validated by our administrators.
	</p>
	<button type = "button" onclick="window.location.href='viewMessages.php'">View Message Board</button>
	<button type = "button" onclick="window.location.href='messages.php'">Post New Message</button>
</body>
</html>
