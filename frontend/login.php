<?php 
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$mysql_db_hostname = "fourthbranch.db.9192271.hostedresource.com";
$mysql_db_user = "fourthbranch";
$mysql_db_password = "G0tnerds!";
$mysql_db_database = "fourthbranch";
$con = mysql_connect($mysql_db_hostname, $mysql_db_user, $mysql_db_password)
or die("Could notconnect database");
mysql_select_db($mysql_db_database, $con)or die("Could not select database");

$query = "SELECT * FROM individuals WHERE name='$username' AND password='$password'";
$result = mysql_query($query)or die(mysql_error());
$num_row = mysql_num_rows($result);
$row=mysql_fetch_array($result);
if( $num_row >=1 ) { 
echo 'true';
$_SESSION['user_name']=$row['name'];
}
else{
echo 'false';
}
?>