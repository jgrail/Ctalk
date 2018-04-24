<?php
    include('dbconn.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Pageable Displays</title>
    <style>
        tr:nth-child(even) {
            background-color: #f1f1f1;
        }
    </style>
        
</head>
<body>


<?php
    
    //TODO:
    //admin button
    //query the userID for admin, if = 1, display button to go to admin view 


    // pagination support
    $itemsPerPage=10;
    // figure out how many pages
    $pages = findpages($itemsPerPage);
    $start = findstart();
        
    $links = createSortLinks();
    createDataTable($start, $itemsPerPage, $links);
    createPageLinks($start, $pages, $itemsPerPage, $links['orderby']);
?>

</body>
</html>


<?php
function createDataTable($start, $itemsPerPage, $links) {
    $qry = "SELECT title, name, messageContents, type FROM Messages 
                WHERE approved = 0 
                ORDER BY {$links['orderby']}
                LIMIT $start, $itemsPerPage ";

        
    echo  "
        <form action='approveMessages.php'>
            <table class=\"fixed\">
                    <tr>
                        <th class=\"title\"> <a href={$links['title']}> Title</a></th>
                        <th class=\"name\"><a href={$links['name']}>Name</a></th>
                        <th class=\"messageContents\"><a href={$links['message']}>Message</a></th>
                        <th class=\"type\"><a href={$links['type']}>Type</a></th>
                         
                        
                        <th class=\"approve\">Approve</th>
                    </tr> \n ";
                    //<th class=\"photo\"><a href={$links['photo']}>Photo</a></th>


        $dbc =  connect_to_db("ClaremontTalk");
        $result = perform_query($dbc, $qry);
        $class = "alt2";
        while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
            $class = ($class=='alt1' ? 'alt2':'alt1');
            echo "  <tr class=\"$class\">
                        <td>$title</td>
                        <td>$name</td>
                        <td>$messageContents</td>
                        <td>$type</td>
                        
                        <td><input type='checkbox' name='approved'></td>

                    </tr>\n";
                    //<td>$photo</td>
        }

        echo "</table>
                <input type='submit' value='Approve Messages'>
            </form>\n";
    }



function findpages($itemsPerPage){
    if (isset($_GET['p'])){
        // get it from the URL if we've already been here
        $pages=$_GET['p'];
    } else {
    
        // starting new, so get it from the database
        $qry="SELECT COUNT(messageId) as count from Messages where approved = 0;";
        
        $dbc =  connect_to_db( "ClaremontTalk" );
        $result = perform_query($dbc, $qry);
        extract((array)mysqli_fetch_array($result, MYSQLI_ASSOC));
            
        if ($count > $itemsPerPage)
            $pages=ceil($count/$itemsPerPage);
        else
            $pages=1;
    }
    return $pages;
}


function findstart(){
    // figure out where to start
    if (isset($_GET['s']))
        $start=$_GET['s'];
    else
        $start=0; // at the beginning
        
    return($start);
}

function createSortLinks(){
    $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameA";  
    //echo  $namelink."<br>";
    $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeA"; 
    //echo $typeLink."<br>";
    $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageA"; 
    //echo $messageLink."<br>";
    $photoLink = "{$_SERVER['PHP_SELF']}?sort=photoA";  
    //echo  $photoLink."<br>";
    $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleA";
    //echo  $titleLink."<br>";
    $orderby="name ASC";
    $sort = isset($_GET['sort']) ? $_GET['sort']: "nameA" ;

    switch ($sort){
        case 'nameA':
            $orderby='name ASC';
            $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameD";
            break;  

        case 'nameD':
            $orderby='name DESC';
            $nameLink = "{$_SERVER['PHP_SELF']}?sort=nameA";
            break;

        case 'titleA':
            $orderby='title ASC';
            $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleD";
            break;

        case 'titleD':
            $orderby='title DESC';
            $titleLink = "{$_SERVER['PHP_SELF']}?sort=titleA";
            break;
        

        case 'messageA':
            $orderby='messageContents ASC';
            $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageD";
            break;
        
        case 'messageD':
            $orderby='messageContents DESC';
            $messageLink = "{$_SERVER['PHP_SELF']}?sort=messageA";
            break;


        case 'photoA':
            $orderby='photo ASC';
            $photoLink = "{$_SERVER['PHP_SELF']}?sort=messageD";
            break;
        
        case 'photoD':
            $orderby='photo DESC';
            $photoLink = "{$_SERVER['PHP_SELF']}?sort=messageA";
            break;

        case 'typeA':
            $orderby='type ASC';
            $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeD";
            break;
    
        case 'typeD':
            $orderby='type DESC';
            $typeLink = "{$_SERVER['PHP_SELF']}?sort=typeA";
            break;              
        default:
            break;
    }


 
    
    echo    $orderby."<br>";
    echo $_GET['sort']."<br>";
    echo $sort;
    $links = array("name"=> $nameLink, "type"=> $typeLink, "photo"=> $photoLink, "message"=> $messageLink, "title"=> $titleLink, "orderby" => $orderby);




    return $links;
}


function createPageLinks($start, $pages, $itemsPerPage, $sort){
    $thispage = "{$_SERVER['PHP_SELF']}";
    $sort = isset($_GET['sort']) ? $_GET['sort']: "";
    echo "This page is $thispage";
    
    
    // creating page links
    if ($pages > 1) {
        echo '<br /><hr />';
        
        // print Previous if not on the first page
        $currentPage=($start/$itemsPerPage) + 1;
        if ($currentPage != 1){
            echo '<a href="'.$thispage.'?s='.($start - $itemsPerPage) . 
                                        '&amp;p=' . $pages . 
                                        '&amp;sort=' . $sort .
                                        '"> Previous </a>';
        }
        
        // print page numbers
        for ($i=1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="'.$thispage.'?s='.(($itemsPerPage * ($i-1))) . 
                                                '&amp;p=' . $pages . 
                                                '&amp;sort=' . $sort .
                                                '"> '. $i .'  </a>'."\n";
                }  else {
                    echo $i . ' ';
                }
        }
    
        // print next if not on the last page
        if ($currentPage != $pages){
            echo '<a href="'.$thispage.'?s='.($start + $itemsPerPage) . '&amp;p=' . 
                                                $pages . '"> Next </a>';
        }
    }
}
?>