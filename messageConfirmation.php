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

	$approved = 0;
	$query1 = "INSERT INTO Messages (name, messageContents, type, title, approved, userID, photo) VALUES (?,?,?,?,?,?,?)";
	//add User ID into database
	$insertMsg = $connection-> prepare($query1);
	if ($insertMsg) {
		
		$insertMsg -> bind_param('ssssiib', $name, $messageContents, $type, $title, $approved, $userID, $image);
	} else {
		die("Error".$connection ->error);
	}

	mysqli_stmt_execute($insertMsg);
  	mysqli_stmt_close($insertMsg);	
?>
<!DOCTYPE html>
<head>
	<title>Message Confirmation</title>
	<link rel="stylesheet" href="CTalkStyle.css">
</head>
<body class = "bckgrnd" style="background-color: #ccf6ff">
	<h2>Your Message Has Been Recorded</h2>
	<img src="http://a.scpr.org/i/c7b8ab50e2167c6bc4fb12e02760a18c/65101-full.jpg" height = "250" width="750" align="center">
	<p>Thank you for posting your message! It will be distributed on Claremont Talk once it is validated by our administrators.
	</p>
	<button type = "button" class="button" onclick="window.location.href='viewMessages.php'">View Message Board</button>
	<button type = "button" class="button" onclick="window.location.href='messages.php'">Post New Message</button>
</body>
</html>
