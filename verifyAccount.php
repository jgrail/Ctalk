
<?php 
// Define database connection details via constants 
 require'dbconn.php';
$conn = connect_to_db("ClaremontTalk");
$email = $_POST['email'];
$psw = $_POST['psw-repeat'];
$pswRepeat = $_POST['psw'];
$school = $_POST['school'];
$emailErr = $passwordErr = "";
$admin = 0;
// check if name only contains letters and whitespace
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo $email;
      $emailErr = "Invalid email format"; 
    }

     if ((!preg_match("^(?=.*\d).{4,30}+^",$psw) || $psw != $pswRepeat) ){
      echo $psw;
      echo $pswRepeat;
      $passwordErr = "invalid password"; 
    }

if(strlen($emailErr)>0||strlen($passwordErr)>0) {
  header("Location: createLogin.php");
}

else {
  $sql = "SELECT count(*) as 'c' FROM User WHERE email = '$email'";
  $result = $conn->query($sql)->fetch_object()->c;
  if(($result==0)){
  $insertUser = $conn -> prepare("INSERT INTO User (email, password, school, admin) VALUES(?,?,?,?)");
  $insertUser -> bind_param("sssi",$email,$psw,$school,$admin);
  $insertUser->execute();
  $emailErr = $passwordErr = "";
  echo "VALID USER";
  header("Location: login.php");
}
else {echo "You already have an account, please login";}
}
?>

</body>
</html>
