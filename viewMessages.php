
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
			background-color: #FF8000;
		}
	</style>
		
</head>
<body>


<?php
	
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
	$qry = "SELECT title, name, messageContents, type, photo FROM Messages 
				ORDER BY {$links['orderby']}
				LIMIT $start, $itemsPerPage ";
		
	echo  "<table class=\"fixed\">
				<tr>
					<th class=\"title\"> <a href={$links['title']}> Title</a></th>
					<th class=\"name\"><a href={$links['name']}>Name</a></th>
					<th class=\"messageContents\"><a href={$links['message']}>Message</a></th>
					<th class=\"type\"><a href={$links['type']}>Type</a></th>
					<th class=\"photo\"><a href={$links['photo']}>Photo</a></th> 
				</tr> \n ";


	$dbc =  connect_to_db("ClaremontTalk");
	$result = perform_query($dbc, $qry);
	$class = "alt2";
	while (@extract(mysqli_fetch_array($result, MYSQLI_ASSOC))) {
		$class = ($class=='alt1' ? 'alt2':'alt1');
		echo "	<tr class=\"$class\">
					<td>$title</td>
					<td>$name</td>
					<td>$messageContents</td>
					<td>$type</td>
					<td>$photo</td>
				</tr>\n";
	}
	echo "</table>\n";
}



function findpages($itemsPerPage){
	if (isset($_GET['p'])){
		// get it from the URL if we've already been here
		$pages=$_GET['p'];
	} else {
	
		// starting new, so get it from the database
		$qry="SELECT COUNT(messageId) as count from Messages;";
		
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

	$namelink = "{$_SERVER['PHP_SELF']}?sort=nameA";   
	$typeLink = "{$_SERVER['PHP_SELF']}?sort=typeA"; 
	$messageLink = "{$_SERVER['PHP_SELF']}?sort=messageA"; 
	$photoLink = "{$_SERVER['PHP_SELF']}?sort=photoA";  
	$titleLink = "{$_SERVER['PHP_SELF']}?sort=titleA"; 
	$orderby="type ASC";
	$sort = isset($_GET['sort']) ? $_GET['sort']: "titleA" ;

	switch ($sort){
		case 'nameA':
			$orderby='name ASC';
			$namelink = "{$_SERVER['PHP_SELF']}?sort=nameD";
			break;
		
		case 'nameD':
			$orderby='name DESC';
			$namelink = "{$_SERVER['PHP_SELF']}?sort=nameA";
			break;

		case 'titleA':
			$orderby='title ASC';
			$titlelink = "{$_SERVER['PHP_SELF']}?sort=titleD";
			break;

		case 'titleD':
			$orderby='title DESC';
			$titlelink = "{$_SERVER['PHP_SELF']}?sort=titleA";
			break;
		

		case 'messageA':
			$orderby='messageContents ASC';
			$messagelink = "{$_SERVER['PHP_SELF']}?sort=messageD";
			break;
		
		case 'messageD':
			$orderby='messageContents DESC';
			$messagelink = "{$_SERVER['PHP_SELF']}?sort=messageA";
			break;


		case 'photoA':
			$orderby='photo ASC';
			$photolink = "{$_SERVER['PHP_SELF']}?sort=messageD";
			break;
		
		case 'photoD':
			$orderby='photo DESC';
			$photolink = "{$_SERVER['PHP_SELF']}?sort=messageA";
			break;

		case 'typeA':
			$orderby='type ASC';
			$typelink = "{$_SERVER['PHP_SELF']}?sort=typeD";
			break;
	
		case 'typeD':
			$orderby='type DESC';
			$typelink = "{$_SERVER['PHP_SELF']}?sort=typeA";
			break;				
		default:
			break;
	}

	$links = array(
					"name"=> $namelink,
					"type"=> $typelink,
					"photo"=> $photolink,
					"message"=> $messagelink,
					"title"=> $titlelink,
					"orderby" => $orderby
					);
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
