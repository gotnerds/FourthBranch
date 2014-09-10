<?php 
$term = mysqli_real_escape_string($db_conx, $_REQUEST['term']);
$statement = $mysqli->prepare  ("SELECT * FROM bills WHERE title LIKE '%".$term."%' ORDER BY id DESC LIMIT 6");
		$statement->execute();
		$results = $statement->get_result();
		 while ( $row = $results->fetch_array() ) {
		 }
?>