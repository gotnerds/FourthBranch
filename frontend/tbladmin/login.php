<?php
session_start();
	include("include/dbcon.php");
if(isset($_POST['sbt'])){
	
	
	$username=$_POST['link1'];
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
}


?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


	<!-- General meta information -->
	<title>Admin Panel</title>
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<meta name="robots" content="index, follow" />
	<meta charset="utf-8" />
	<!-- // General meta information -->
	
	
	<!-- Load Javascript -->
	<script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery.query-2.1.7.js"></script>
	<script type="text/javascript" src="./js/rainbows.js"></script>
	<!-- // Load Javascipt -->

	<!-- Load stylesheets -->
	<link type="text/css" rel="stylesheet" href="css/stylelogin.css" media="screen" />
	<!-- // Load stylesheets -->
	
<script>


	$(document).ready(function(){
 
	$("#submit1").hover(
	function() {
	$(this).animate({"opacity": "0"}, "slow");
	},
	function() {
	$(this).animate({"opacity": "1"}, "slow");
	});
 	});


</script>
	
</head>
<body>

	<div id="wrapper">
	<div id="wrappertop">
	
		</div>
			
		<div id="wrappermiddle">

			<h2>Login Panel</h2>

			<div id="username_input">

				<div id="username_inputleft"></div>

				<div id="username_inputmiddle">
				<form method="post" action="">
					<input type="text" name="link1" id="url" value="Enter Username" onclick="this.value = ''" required>
					<img id="url_user" src="./images/mailicon.png" alt="">
				
				</div>

				<div id="username_inputright"></div>

			</div>

			<div id="password_input">

				<div id="password_inputleft"></div>

				<div id="password_inputmiddle">
				
					<input type="password" name="link2" id="url" value="Password" onclick="this.value = ''" required>
					<img id="url_password" src="./images/passicon.png" alt="">
				
				</div>

				<div id="password_inputright"></div>

			</div>

			<div id="submit">
				
				
				<input type="submit" style="width:150px;height:50px;margin-left:60px;font-size:20px" value="Sign In" name="sbt">
				</form>
			</div>


			<div id="links_left">


			</div>

		
		</div>

		<div id="wrapperbottom"></div>
		
		
	</div>

</body>
</html>