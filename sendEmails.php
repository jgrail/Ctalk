<?php
$to = "grail07@gmail.com";
$subject = "CS Test";
$txt = $message = file_get_contents("viewMessages.php");
$headers = "From: claremont@talk.com";
mail($to,$subject,$txt,$headers);
echo $txt;

?>
