<?php

	include("include/dbcon.php");

	
/*	$username=$_POST['link1'];
	$pass=$_POST['link2'];
	
	$sql="select * from adminlogin where username='$username' and password='$pass'";
	$query=mysqli_query($con,$sql);
	$count=mysqli_num_rows($query);
	if($count){
		$_SESSION['username']=$username;
		echo"<script>window.location='index.php'</script>";
	}
	else{
		echo "<script>alert('Invalid Username Or Password');</script>";
	}

*/


$sql="insert into adminlogin(username,password) values('admin','admin')";
	$query=mysqli_query($con,$sql);
if($query){
	echo "Ok ! ";
}
else{
	echo "Error ".mysqli_error($con);
}



?>