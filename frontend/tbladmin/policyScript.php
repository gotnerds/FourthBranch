<?php
	include("inc/check_login_status.php"); 

	$sql = "SELECT admin.policy FROM admin;";
	$result = mysqli_query($db_conx,$sql);
	$results = array();
	while($row = mysqli_fetch_array($result)) {
	  $results[] = $row;
	}
?>
