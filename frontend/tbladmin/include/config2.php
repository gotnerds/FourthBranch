<?php

	$con=mysqli_connect("localhost","root","");
		if(!$con)
				echo "Error ! ";

	$db=mysqli_select_db($con,"fourth");
		if(!$db)
				echo "Error !!! ";


?>