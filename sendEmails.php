
<?php

require("dbconn.php");

    echo "Email was sent:";
    echo "<br>";
    echo "<br>";
    echo "ClaremontTalk: "
    $to = "claremont@talk.com";

    $subject = "New in ClaremontTalk: ";

    $txt = "<html><body><p>New Events: </p>";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: claremont3@talk.com";



    //echo $txt;

    $connection = connect_to_db("ClaremontTalk");
    $query = "SELECT * FROM Messages WHERE approved = 1 AND emailed = 0";
    $result = perform_query($connection, $query);

    while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
                
                    $title = $row['title'];
                    
                   
                    echo "<li>$title</li>";
                    $txt .= "<li>$title</li>";
                    
                }
                echo"<br/>";
                echo"<br/>";
                echo"Messages: ";
                echo"<br/>";
                echo"<br/>";

                $txt .= "<br/>
                <br/>
                Messages: 
                <br/>
                <br/>";

    $query = "SELECT * FROM Messages WHERE approved = 1 AND emailed = 0";
    $result = perform_query($connection, $query);
    while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
                
                    $title = $row['title'];
                    $name  = $row['name'];
                    $type = $row['type'];
                    $message = $row['messageContents'];
                    
                    echo "<li>$title</li>";
                    
                    echo "Type: $type";
                    echo "<br/>";
                    echo "From: $name";
                    echo "<br/>";
                    echo "Message: $message";
                    echo"<p></p>";

                    $txt .= "<li>$title</li>
                            Type: $type
                            <br/>
                            From: $name
                            <br/>
                            Message: $message
                            <p></p>";
                    
                    
                }

    $txt .= "</body></html>";



    mail($to,$subject,$txt,$headers);


?>





<html>
<body>
    <!--<span></span><input type='submit' value='Send Email'>-->


</body>