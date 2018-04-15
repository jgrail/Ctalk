<?php

session_start(); 



require 'dbconn.php';
$connection = connect_to_db( "ClaremontTalk" );

$query = "SELECT * FROM Messages";
            $result = perform_query( $connection, $query );
            
            echo "Num Results:" . mysqli_num_rows($result);
            echo "<ul>\n";
            while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
            
                $title = $row['title'];
                $messageContents  = $row['messageContents'];
               
                echo "<li>$title  $messageContents</li>\n";
            }
            echo "</ul>\n";

            disconnect_from_db( $connection, $result );


//$query = "SELECT title FROM Messages";

   // $selectMesssges = $connection -> prepare($query);
   // $selectMesssges -> bind_param("s", $title);

   // echo $connection->error;
    

    //mysqli_stmt_execute($selectMessages);

   // $selectMessages -> bind_result($result);
    

    //while ( $row = mysqli_fetch_array( $result, MYSQLI_ASSOC ) ) {
      //      
        //        $title = $row['title'];
          //      $year  = $row['year'];
               
           //     echo "<li>$title  $year </li>\n";
            //}
        

        

    //mysqli_stmt_close($selectMesssges);





?>