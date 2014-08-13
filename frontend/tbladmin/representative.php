<?php
if (isset($_POST["name"])) {
include "../inc/db_conx.php";
$web = mysqli_real_escape_string($db_conx,$_POST['web']);
$number = mysqli_real_escape_string($db_conx,$_POST['number']);
$state = mysqli_real_escape_string($db_conx,$_POST['state']);
$name = mysqli_real_escape_string($db_conx,$_POST['name']);
$email = mysqli_real_escape_string($db_conx,$_POST['email']);
$name = mysqli_real_escape_string($db_conx,$_POST['name']);
$hs = mysqli_real_escape_string($db_conx,$_POST['hs']);
$avi = mysqli_real_escape_string($db_conx,$_FILES["file"]["name"]);
$sql = "INSERT INTO `4thbranch`.`rep` (`id`, `type`, `name`, `email`, `phone`, `web`, `avi`, `state`) 
VALUES (NULL, '$hs', '$name', '$email', '$number', '$web', '$avi', '$state');";

if (!mysqli_query($db_conx,$sql))
  {
  die('Error: ' . mysqli_error($db_conx));
  }
  if (!file_exists("../senator/$email")) {
			mkdir("../senator/$email", 0755);
		}
	$allowedExts = array("gif", "jpeg", "jpg", "png");
	$temp = explode(".", $_FILES["file"]["name"]);
	$extension = end($temp);
	if ((($_FILES["file"]["type"] == "image/gif")
	|| ($_FILES["file"]["type"] == "image/jpeg")
	|| ($_FILES["file"]["type"] == "image/jpg")
	|| ($_FILES["file"]["type"] == "image/pjpeg")
	|| ($_FILES["file"]["type"] == "image/x-png")
	|| ($_FILES["file"]["type"] == "image/png"))
	&& ($_FILES["file"]["size"] < 20000)
	&& in_array($extension, $allowedExts))
	  {
	  if ($_FILES["file"]["error"] > 0)
	    {
	    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
	    }
	  else
	    {
	      move_uploaded_file($_FILES["file"]["tmp_name"],
	      "../senator/" . $email . "/" . $_FILES["file"]["name"]);
	    }
	  }
	else
	  {
	  echo "Invalid file";
	  }
$succesful= "bill successfully added";
}
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
	<meta http-equiv='content-type' content='text/html; charset=utf-8' />
	<title>Admin</title>
	<link rel='stylesheet' href='../style/stylesheet.css'>
	<script type='text/javascript' src='http://code.jquery.com/jquery-1.10.2.js'></script>
		<script src="../js/ajax.js"></script>
		<script src="../js/ajaxfileupload.js"></script>
</head>
<div id='headerBackDark'></div>
<div id='headerBackLight'></div>
<div id='header'>
	<div id='headerTop'>
		<div id='headerTopLeft'>
			&nbsp;
			<a href='about.php'>about </a>
			| 
			<a href='contect.php'>contact </a>
			| 
			<a href="copyright.php">copyright</a>
			|
			<a href="policy.php">privacy policy</a>
		</div>
		<div id='headerTopRight'>
			<div>
				<div id='headerTopRightLogin'>			  	
				</div>
				<div>
					<a href="slogan.php">Slogan (footer)</a>
					|
					<a href='slogan.php'>Copyright (footer)</a>
					&nbsp;
				</div>
			</div>
		</div>
	</div>
	<div id='headerBanner'></div>
	<table width='980' id='headerBottom'>
		<td width='25%'>
			<a href='home.php'>HOME</a>			
		</td>
		<td width='25%'>
			<a href='vote.php'>VOTE</a>			
		</td>
		<td width='25%'>
			<a href='proposal.php'>PROPOSAL</a>			
		</td>
		<td width='25%'>
			<a href='news.php'>NEWS</a>			
		</td>
	</table>
</div>
<br />
<style type="text/css">
	#main:hover{
		color: blue;
		}
</style>
<div id="body">
	<h1 align="center">
		<a style="color:#003366;" href="index.php">
			<span id="main">Main Page</span>
		</a>
		 > 
		 <span style="color:red">Create Representatives</span>
	</h1>
	<?php if (isset($_POST["name"])){echo $succesful;} ?>
	<form action="representative.php" method="post" id="form" name="form">
		<input type="text" name="name" id="name" size="45" placeholder="Representative's Name" ><br /><br />
		House:<input type="radio" name="hs" id="hs" value="h">
		 or 
		Senate:<input type="radio" name="hs" id="hs" value="s" size="45"><br /><br />
		State:<select id='state' name="state">
    																		<option value=''></option>
	  																		<option value='Alabama'>AL</option>
	  																		<option value='Alaska'>AK</option>
	  																		<option value='Arizona'>AZ</option>
	  																		<option value='Arkansas'>AK</option>
	  																		<option value='California'>CA</option>
	  																		<option value='Colorado'>CO</option>
	  																		<option value='Connecticut'>CT</option>
	  																		<option value='Delaware'>DE</option>
	  																		<option value='Washington, D.C.'>DC</option>
	  																		<option value='Florida'>FL</option>
	  																		<option value='Georgia'>GA</option>
	  																		<option value='Hawaii'>HI</option>
	  																		<option value='Idaho'>ID</option>
		  																	<option value='Illinois'>IL</option>
		 	 																<option value='Indiana'>IN</option>
	  																		<option value='Iowa'>IA</option>
	  																		<option value='Kansas'>KS</option>
	  																		<option value='Kentucky'>KY</option>
	  																		<option value='Louisiana'>LA</option>
		  																	<option value='Maine'>ME</option>
	  																		<option value='Maryland'>MD</option>
	  																		<option value='Massachusetts'>MA</option>
	  																		<option value='Michigan'>MI</option>
	  																		<option value='Minnesota'>MN</option>
						  													<option value='Mississippi'>MS</option>
	  																		<option value='Missouri'>MO</option>
	 																		<option value='Montana'>MT</option>
	  																		<option value='Nebraska'>NE</option>
	  																		<option value='Nevada'>NV</option>
	  																		<option value='New Hampshire'>NH</option>
	  																		<option value='New Jersey'>NJ</option>
	  																		<option value='New Mexico'>NM</option>
		  																	<option value='New York'>NY</option>
		  																	<option value='North Carolina'>NC</option>
	  																		<option value='North Dakota'>ND</option>
	  																		<option value='Ohio'>OH</option>
	  																		<option value='Oklahoma'>OK</option>
	  																		<option value='Oregon'>OR</option>
	  																		<option value='Pennsylvania'>PA</option>
	  																		<option value='Rhode Island'>RI</option>
								  											<option value='South Carolina'>SC</option>
							  												<option value='South Dakota'>SD</option>
		  																	<option value='Tennessee'>TN</option>
						  													<option value='Texas'>TX</option>
	  																		<option value='Utah'>UT</option>
	  																		<option value='Vermont'>VT</option>
							  												<option value='Virginia'>VA</option>
		  																	<option value='Washington'>WA</option>	  												
	  																		<option value='West Virginia'>WV</option>
	  																		<option value='Wisconsin'>WI</option>
	  																		<option value='Wyoming'>WY</option>
    																	</select><br /><br />
		<input type="text" name="web" id="web" size="45" placeholder="Representative's Web URL address (include http://)" ><br /><br />
		<input type="email" name="email" id="email" size="45" placeholder="Representative's Email">	<br /><br />
		<input type="text" name="number" id="number" size="45" placeholder="Representative's Phone Number"><br /><br />
		<img id="blah" src="../image/avitar.png" alt="your image" width="103" height="125" style='width: 103px; height: 125px;' /><br /><br />
		<input type='file' id="imgInp" name='pic' size='45' accept='image/*' style="float:left;" /><br /><br />
		<script type="text/javascript" >
			function readURL(input) {
        		if (input.files && input.files[0]) {
            	var reader = new FileReader();            
            	reader.onload = function (e) {
               	$('#blah').attr('src', e.target.result);
            	}            
            	reader.readAsDataURL(input.files[0]);
        		}
    		}    
    		$("#imgInp").change(function(){
        		readURL(this);
    		});    												
		</script>
	<br />
	<p><input id="button" type="submit"></p>
	</form>
</div>