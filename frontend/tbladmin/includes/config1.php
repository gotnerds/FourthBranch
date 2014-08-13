<?php
session_start();
	$con=mysql_connect("localhost","root","");
	if(!$con)
		echo "Error ! ".mysql_error();
		
	$db=mysql_select_db("butler");
	
	if(!$db)
		echo "Error !".mysql_error();

?>