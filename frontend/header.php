<!doctype html>
<html lang="en">

<head>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css' />

<meta charset="utf-8" />

  <title>The Fourth Branch</title>

  <meta name="description" content="Keeping you updated and involved in the ongoing political process." />

  <meta name="author" content="The Fourth branch" />

  <link rel="stylesheet" href="css/styles.css" type="text/css" />

  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/html5shiv.min.js"></script>

  <!--[if lt IE 9]>

  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

  <![endif]-->

<!-- authentication info -->

<?php

include "./inc/jsonencode.php";
if (isset($_POST)) {
    include "./inc/functions.php";
    print_r($_POST);
}
?>
</head>

<body>

        <section id="header-bar">
                <div id="login">
                    <form action="" name="llLogin" id="llLogin" method="post" style="display:inline-block;">
                        <input type="email" id="username" name="username" placeholder="Email" size="20" /> 
                        <input type="password" placeholder="Password" id="password" name="password" size="20" />
                        <input type="hidden" name="login-button" />
                        <a id="login-button" style="cursor: pointer;" onclick="loginbutton();">Login</a> | 
                    </form>
                    <a id="signup-button" onclick="introduction();" style="cursor:pointer;">Signup</a>
                </div>
            <header id="logo">
                The Fourth Branch
            </header>

                <nav id="nav">
                    <a href="/home">Home</a> | 
                    <a href="/vote">Vote</a> | 
                    <a href="/proposal">Proposal</a> | 
                    <a href="/news">News</a> | 
                    <a href="/news">Contribute</a> | 
                    <a href="/wallofamerica">Wall of America</a> | 
                    <a href="/about">About</a> | 
                    <a href="/contact">Contact</a>
                </nav>

        </section>
<div id="container">

        <script type="text/javascript">

function toggleOverlay_new(){

                document.body.className = document.body.className.indexOf('overlaid') != -1 ? '' : 'overlaid';

                 document.getElementById('introduction').style.display = 'none';

    		document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('individual').style.display = 'none'; 

      		}

						function login() {

							var lEmail = document.getElementById('lEmail').value;

							var lPassword = document.getElementById('lPassword').value;

							if((lEmail == '') || (lPassword == ''))

							{

							$("#lEmail").val("Incorrect Email or password");

							}

							else

							{

							var dataString = "lEmail="+lEmail+"&lPassword="+lPassword;							

							$.ajax({

								type: "POST",

								url: "login.php",

								data: dataString,

								success: function(data, textStatus, jqXHR)

								{

									document.location.reload(true);

								},

								error: function (jqXHR, textStatus, errorThrown)

								{

									//$("#lEmail").val("Incorrect Email or password");								

									document.location.reload(true);

								}

	                      });

						  }

						}

    		function toggleOverlay() {

				document.body.className = document.body.className.indexOf('overlaid') != -1 ? '' : 'overlaid';

							if(document.getElementById('a').style.display == 'block') {

								document.getElementById('a').style.display = 'none';

							} else if (document.getElementById('a').style.display == 'none') {

									document.getElementById('a').style.display = 'block';

							}			}

			function toggleOverlay1() {

				document.body.className = document.body.className.indexOf('overlaid') != -1 ? '' : 'overlaid';

          					if(document.getElementById('introduction').style.display == 'block') {

			   					document.getElementById('introduction').style.display = 'none';

			 				} else if(document.getElementById('introduction').style.display == 'none') {

			  	 				document.getElementById('introduction').style.display = 'block';

			 				}

                        }

      		document.addEventListener('DOMContentLoaded', function() {

        		document.querySelector('.overlay').addEventListener('click', function(ev) {

        		});

      		});

      </script>

        <!--<tr>

		<td><input type='checkbox' id="remember" name="remember" >Remember Me</td>

        <td><a style="cursor: pointer;" onclick='toggleOverlay2();'>Forget?</a></td>

		</tr>-->

<div class='overlay'>

	<div class='wrap-outer'>

		<div class='wrap' style="position:relative;float:left;">

			<div class="double-border" id='a' style='position:fixed; top: 50%; left: 50%;margin-top:-100px;margin-left:-200px;'>

									<div style='margin: 15px 15px 15px 15px'>

										<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

										<h2 style='text-align:center;clear:both;'>

											Login or Sign Up

										</h2>																				

										<form action="" name="llLogin" id="llLogin" method="post">

											<input type='email' id="username" name="username" size='20' placeholder='Email' />

											<input type='password' size='20' id="password" name="password" placeholder='Password' />

    										<div style='overflow:hidden;'>
    
    											<button class='button' name='login-button' type="submit" style='cursor: pointer;width:100px;float:left;margin-left:15px;font-size:larger;'>
    
    												Login
    
    											</button>
    
    											<button class='button' onclick='introduction();' style='cursor: pointer;width:100px;float:right;margin-right:20px;font-size:larger;'>
    
    												Sign Up
    
    											</button>
    
    										</div>

                                        </form>

										<p style="float:left;cursor:hand;" onclick="javascript:forgotpwd();">

											Forgot Password?

										</p>

										<script>

										function forgotpwd()

										{

											document.getElementById('individual').style.display = 'none';

											document.getElementById('introduction').style.display = 'none';

											document.getElementById('organization').style.display = 'none';

											document.getElementById('organization2').style.display = 'none';

											document.getElementById('organization3').style.display = 'none';

											document.getElementById('confirm').style.display = 'none';

											document.getElementById('forgot2').style.display = 'none';

											document.getElementById('a').style.display = 'none';

											document.getElementById('confirm').style.display = 'none';

											document.getElementById('confirm2').style.display = 'none';

											document.getElementById('forgot').style.display = 'block';

										}

	                                    </script>

									</div>

							</div>

			<div class="double-border" id='forgot' style='position:fixed; top: 50%; left: 50%;margin-top:-100px;margin-left:-200px;'>

									<div style='margin: 15px 15px 15px 15px'>

										<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

										<br style="clear:both;" />

										<h3>

											Generate a temporary log in password

										</h3>

  										<form id='forgotpassform' id="forgot" name="forgot" onsubmit='return false;'>

    										<p align="center" >

    											Step 1: Enter Your Email Address

    										</p>

    										<input type='text'  style="width:100%;" id="forgot" name="forgot">

    										<br />

    										<br />

    										<button class='button' name='forgot-button' type="submit"  style="float:left;">

    											Generate Temporary Log In Password

    										</button> 

    										<script type="text/javascript" >

												function forgotpass() {

														var forgot = document.forgot.forgot.value;

													if(forgot == ""){

														document.forgot.forgot.value = "Type in your email address";

													} else if (document.forgot.forgot.value == "Sorry that email address is not in our system"){

														document.forgot.forgot.value = "Type in your email address";

													} else if (document.forgot.forgot.value == "Type in your email address"){

														document.forgot.forgot.value = "Sorry that email address is not in our system";

													} else {

														var dataString = "forgot="+forgot;							

														$.ajax({

															type: "POST",

															url: "#",

															cache:false,

															data: dataString,															

															success: function(data) {															

															document.getElementById('individual').style.display='none';	   															

	   															document.getElementById('introduction').style.display='none';

																document.getElementById('organization').style.display='none';

																document.getElementById('organization2').style.display='none';

																document.getElementById('organization3').style.display='none';

																document.getElementById('confirm').style.display='none';

  																document.getElementById('forgot').style.display='none';

  																document.getElementById('a').style.display='none';

  																document.getElementById('confirm').style.display='none';

																document.getElementById('confirm2').style.display='none';

  																document.getElementById('forgot2').style.display='block';	

															},

															error: function (jqXHR, textStatus, errorThrown)

															{

																document.forgot.forgot.value = "An unknown error occurred";

															}

													  });

												}						

						                      }

											</script>   											

  										</form>

  										<button style="cursor: pointer;float:right;" onclick='a();' id="button">

  											Back

  										</button>

										<br style="clear:both;" />  											

  									</div>

							</div>

			<div class="double-border" id='forgot2' style='position:fixed; top: 50%; left: 50%;margin-top:-100px;margin-left:-200px;'>

									<div style="margin: 15px 15px 15px 15px">

										<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

										<h3 style="clear:both;"align="center">

											Step 2:

										</h3>

										<p>

											Check your email inbox in a few minutes.

										</p>

										<div style="float:right;overflow:hidden;">

											<button class='button' 

													  onclick='toggleOverlay_new();' 

													  style='cursor: pointer;position:relative; width: 50px; margin-left: auto;margin-right:auto;'>

												OK

											</button>

											<button style="cursor: pointer;float:right;width: 50px;" onclick='a();' id="button">

												Login

											</button>

										</div>

										<div style="clear:both;"></div>

									</div>

								</div>

             <div class='double-border' style='position:fixed; top: 50%; left: 50%;margin-top:-90px;margin-left:-225px;' id='introduction'>

									<div style="margin: 15px 15px 15px 15px">

										<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

										<br style="clear:both;" />

										<h3 align='center' >

											Are you an Individual or Organization?

										</h3>

										<button class='button' 

												  onclick='individual();' 

												  style='font-size:larger;position:relative; float: left; width: 120px; margin-left: 25px;'

										>

											Individual

										</button>

										<button class='button' onclick='organization();' style='font-size:larger;float: right; width: 120px; margin-right: 25px;'>

											Organization

										</button>

										<div style="clear:both;" ></div>

									</div>

                                </div>

			<div class="double-border" id='individual' style='position:fixed; width:750px; top: 50%; left: 50%;margin-top:-200px;margin-left: -375px; '>

									<div style="margin: 15px 15px 15px 15px">											

										<div style="float:right;overflow:hidden;">

											<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>									

											<p style="float:right;margin-top:5px;margin-right:15px;">

												Individual &nbsp; &nbsp; | &nbsp; &nbsp; <span style='color:grey;'>Organization</span>

											</p>												

										</div>

                                        <form name="addIndividual"  action="" id="addIndividual" method="post">

                                        <div style="margin: 15px;">

                                                     <div class="left"><label for="fname">First Name:</label>

											     		<input type='text' style="width:150px;" name='fname' id='fname' maxlength='20'>

													</div>

                                                    <div class="right"><label for="lname">Last Name:</label>

														<input type='text' style="width:150px;" name='lname' id='lname' maxlength='20'>

													</div>	

                                                    <div class="left"><label for="pseudonym">Username:</label>

													   <input type='text' style="width:150px;" name='pseudonym' id='pseudonym' maxlength='20'> 

													</div>

                                                    <div class="right"><label for="dob">Date of Birth:</label>

													   <input type='date' style="width:150px;" name='dob' id='dob' placeholder="mm/dd/yyyy">

													</div>	

                                                    <div class="left"><label for="emailI">Email:</label>

															<input type='email' name='emailI' id='emalI' style="width:150px;" />	

															</div>	

                                                        <div class="right">

																<label for="emailI2">Confirm Email:</label>

																<input type='email' name='emailI2' id='emalI2' style="width:150px;" />

														</div>		

                                                        <div class="left">

																<label for="passI">Password:</label>

																<input type='password' name='passI' id='passI' style="width:150px;" />

															</div>

                                                             <div class="right">

																<label for="passI2">Confirm Password:</label>

																<input type='password' name='passI2' id='passI2' style="width:150px;" />

															</div>	

                                                            <div class="left">

																<label for="g[]">Gender:</label>

																<input type='checkbox' name="g[]" value="m" />Male 

																&nbsp; 

																<input type='checkbox' name="g[]" value="f" /> Female

                                                                </div>

                                                                <div class="full"><label for="address">Address:</label> 

																<input style="width:600px;" type='text' name='address' id='address' /> 

																</div>

								            	               	<div class="left">

																<label for="city">City:</label>

																<input type='text' style="width:150px;" name='city' id='city' />  

															</div>

                                                            <div style="float:left;padding-left:70px;">

																<label for="state">State:</label>

																<select id='state' name="state">

    											<option value=''>--Select State--</option><option value='Alabama'>AL</option>

	  											<option value='Alaska'>AK</option><option value='Arizona'>AZ</option>

												<option value='Arkansas'>AK</option><option value='California'>CA</option>

												<option value='Colorado'>CO</option><option value='Connecticut'>CT</option>

												<option value='Delaware'>DE</option><option value='Washington, D.C.'>DC</option>

												<option value='Florida'>FL</option><option value='Georgia'>GA</option>

												<option value='Hawaii'>HI</option><option value='Idaho'>ID</option>

												<option value='Illinois'>IL</option><option value='Indiana'>IN</option>

												<option value='Iowa'>IA</option><option value='Kansas'>KS</option>

												<option value='Kentucky'>KY</option><option value='Louisiana'>LA</option>

												<option value='Maine'>ME</option><option value='Maryland'>MD</option>

												<option value='Massachusetts'>MA</option><option value='Michigan'>MI</option>

												<option value='Minnesota'>MN</option><option value='Mississippi'>MS</option>

												<option value='Missouri'>MO</option><option value='Montana'>MT</option>

												<option value='Nebraska'>NE</option><option value='Nevada'>NV</option>

												<option value='New Hampshire'>NH</option><option value='New Jersey'>NJ</option>

												<option value='New Mexico'>NM</option><option value='New York'>NY</option>

												<option value='North Carolina'>NC</option><option value='North Dakota'>ND</option>

												<option value='Ohio'>OH</option><option value='Oklahoma'>OK</option>

												<option value='Oregon'>OR</option><option value='Pennsylvania'>PA</option>

												<option value='Rhode Island'>RI</option><option value='South Carolina'>SC</option>

												<option value='South Dakota'>SD</option><option value='Tennessee'>TN</option>

												<option value='Texas'>TX</option><option value='Utah'>UT</option>

												<option value='Vermont'>VT</option><option value='Virginia'>VA</option>

												<option value='Washington'>WA</option><option value='West Virginia'>WV</option>

												<option value='Wisconsin'>WI</option><option value='Wyoming'>WY</option>

    										</select>

															</div><div class="right">

																<label for="zip">Zip:</label>

																<input type='text' size='10' name='zip' id='zip' />

                          										</div>

                                                                  <div class="full" style="padding-top: 20px;">

    												<i>(optional) </i>Political Leaning:

  														<input type='checkbox' value="r" name="party[]" />Republican 

    													<input type='checkbox' value="d" name="party[]" />Democrat 

    													<input type='checkbox' value="l" name="party[]" />Libertarian 

    													<input type='checkbox' value="i" name="party[]" />Independent 

    													<input type='checkbox' value="o" name="party[]" style="margin-top:5px;" />Other

    												    <input type='text' style="width:150px;display:none;" name='otherBox' id='otherBox' placeholder='If other, please enter here' /> 

    												</div>

    										</div>

    									</div><div class="left" style="margin:15px;">

    										<p>

    											By clicking sign up you agree to our 

    											<a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">

    												The Fourth Branch Terms

    											</a>

    											 and that you had read our 

    											 <a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">Privacy Policy</a>

    											 , including our 

    											 <a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">cookie use</a>.

    										</p>

                                            </div>

    										<div style="float:right;overflow:hidden;margin:15px">

    											<button id='isignup'  class='button' name='addIndividual-button' type="submit"

    													   style='cursor: pointer;

    													  			background-color: #2F68D1; 

    													  			color: #FFFFFF; 

    													  			text-align: center; 

    													  			padding-top: 5px; 

    													  			padding-bottom: 5px; 

    													  			width:100px;

    													  			float: right;

    													  			margin-left: 25px'

    											>

    												Sign Up

    											</button>

    										<!--	<script>

                                                    $('#addIndividual').submit(function( event ) {

                                                          event.preventDefault();  													

    													var e = document.addIndividual.emailI.value;

    													var e2 = document.addIndividual.emailI2.value;

														var p1 = document.addIndividual.passI.value;

														var p2 = document.addIndividual.passI2.value;

														var state = document.addIndividual.state.value;

														var g = "";

														if (document.addIndividual.male.checked == true) {

															g = document.addIndividual.male.value;

														}		

														if (document.addIndividual.female.checked == true) {

															g = document.addIndividual.female.value;

														}														

														var party = '';

														if (document.addIndividual.republican.checked == true) {

															party = document.addIndividual.republican.value;

														}

														if (document.addIndividual.democrat.checked == true) {

															party = document.addIndividual.democrat.value;

														}

														if (document.addIndividual.libertarian.checked == true) {

															party = document.addIndividual.libertarian.value;

														}

														if (document.addIndividual.other.checked == true) {

															party = document.addIndividual.other.value;

														}

														if (document.addIndividual.independent.checked == true) {

															party = document.addIndividual.independent.value;

														}

														var psu = document.addIndividual.pseudonym.value;

														var u = psu;

														var adr = document.addIndividual.address.value;

														var city = document.addIndividual.city.value;

														var zip = document.addIndividual.zip.value;

														var fname = document.addIndividual.fname.value;

														var lname = document.addIndividual.lname.value;												

														var dob = document.addIndividual.dob.value;														

    													if (e == '' || p1 == "" || state == "" || g == "" || psu == "" || adr == "" || city == "" || zip == "" || fname == "" || lname == "" || dob == "") {

    														document.getElementById('istatus').innerHTML = "Please, fill out all of the form data";

														} else if (p1 != p2) {

															document.getElementById('istatus').innerHTML = "Your password fields do not match";

														} else if (e != e2){

															document.getElementById('istatus').innerHTML = "Your emails do not match";

														} else {

															}

														}).trigger('submit');	

												</script> -->

												<button type="button" class='button' onclick='introduction();' style='cursor: pointer;width:100px;float: right;'>

													Back

												</button>

											</div>

                                            </div>

                                            </form>										

											<div style="clear:both;"></div>

											<p id="istatus" style="color:red;text-align:center;" ></p>

										</div>

                            </div>

				<div class="double-border" id='confirm' style='position:fixed; top: 50%; left: 50%;margin-top:-200px;width:580px;margin-left:-290px;'>

								<div style="margin: 15px 15px 15px 15px;">

											<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

											<br style="clear:both" />

                                            

											<p align='center' >

												A confirmation link has been sent to your email address.

												Please activate your account to become an active participant in your government.

                                            </p>

											<div style="float:right;overflow:hidden;">

												<button class='button' 

														  onclick='toggleOverlay_new();' 

														  style='cursor: pointer;position:relative; float: right; width: 50px; margin-left: 25px;'>

													OK

												</button>

												<button class="button" style="cursor: pointer;float:right;width: 50px;" onclick='a();' id="button">

													Login

												</button>

											</div>

											<div style="clear:both;"></div>

										</div>

                        </div>

				<div class="double-border" id='organization' style='width:618px; position:fixed; top: 50%; left: 50%;margin-top:-200px;margin-left:-309px;'>

										<div style="margin: 15px 15px 15px 15px;">

											<div style="float:right;overflow:hidden;">

												<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>										

												<p style="float:right;margin-top:5px;margin-right:15px;">

													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization

												</p>												

											</div></div>

                                            <form name="signupOrganization" id="signupOrganization" action='' method="POST" style="margin: 15px;">

												<div class="full"><label for="nameOrganization">Name of Organization:</label>

													<input type='text' style="width:400px;" name='nameOrganization' id='nameOrganization' />

											</div>

											<div class="full">

												<label for="addressOrganization">Address:</label>

													<input type='text' id='addressOrganization' name='addressOrganization' style="width:400px" />

											</div>

											<div class="left">

													City:&nbsp;<input type='text' size='20' name='cityOrganization' id='cityOrganization' />

													&nbsp;&nbsp;&nbsp;&nbsp;</div>

                                                    <div style="float:left; padding-left: 20px;">

													State:&nbsp;&nbsp;<select id='stateOrganization' name="stateOrganization">

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

    												</select> </div>

    												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    												<div class="right">Zip:&nbsp;&nbsp;<input type='text' size='5' name='zipOrganization' id='zipOrganization' />

    										</div><div class="full">

									  			<label for="phoneOrganization">Organization Phone:</label><input type='text' size='20' name='phoneOrganization' id='phoneOrganization' />

									  		</div>

                                              <div class="full">

									  				Legal Status:

									  				<input type='checkbox' value="corporate" name="legal[]" />Corporation 

									  				&nbsp; 

									  				<input type='checkbox' value="nonprofit" name="legal[]" />Not-for-Profit 

									  				&nbsp; 

									  				<input type='checkbox' value="other" name="legal[]" />Other

									  				<input type='text' name="otherBox2" id='otherBox2' placeholder='If other, specify here' style="display:none;" />

									  		   </div>

                                              <div class="full">

									  				Your Cause Concerns:

									  				<input type='checkbox' value="federal" name='cause[]' />Federal Government 

									  				&nbsp; 

									  				<input type='checkbox' value="state" name='cause[]' />State

									  		</div>

                                            <div class="left" style="padding-top:23px;">

                                              <label for="imgInp">

									           	<img id="blah" style="padding-left: 20px;" src="http://thefourthbranch.co/TheFourthBranch/fourth/image/avitar.png" alt="your image" width="103" height="125" style='width: 103px; height: 125px; float:left;' />

                                              </label>

								  	 	   </br><input type='file' id="imgInp" name='pic' size='5' accept='image/*' style="float:left;" />

                                          </div><div class="right">

                                          <label for="reason">Reasons for Joining:</label></br>

									  			<textarea id='reason' name='reason' form="textarea" cols='35' rows='7' style='background-color: #E6E6E6; color:black;'></textarea>

									  	</div>

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

									  	<div style="clear:both;"></div>

									  	<div style="clear:right;overflow:hidden;">

									  		<button type="button" onclick='organization2();' class='button' style='cursor: pointer;width: 100px; float:right; margin-left: 25px;'>

									  			Next

									  		</button>

									  		<button type="button" class='button' onclick='introduction();' style='cursor: pointer;float: right;width: 100px;'>

									  			Back

									  		</button>

									  	</div>

									  	<p style="color:red;text-align:center;" id='ostatus'></p>

                                        </form>

									 </div>

				<div id='organization2' class="double-border" style='position:fixed; width:420px; top: 50%; left: 50%;margin-top:-150px;margin-left:-210px;'>

										<div style="margin: 15px 15px 15px 15px">

											<div style="float:right;overflow:hidden;">

												<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>											

												<p style="float:right;margin-top:5px;margin-right:15px;">

													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization

												</p>												

											</div>

                                            <form name="signupOrganization2" id="signupOrganization2" action="" method="POST" style="margin: 15px;">

                                            <div class="full">

										<label for="nameI">

														Name of Individual:

                                                        </label><input type='text' size='25' name='nameI' id='nameI' />

													</div>

                                                    <div class="full">

													<label for="titleI">

														Title in Organization:</label><input type='text' size='25' name='titleI' id='titleI' />

													</div><div class="full"><label for="phonePersonal">

														Personal Phone:</label><input type='text' size='25' name='phoneP' id='phoneP' />

    											     </div>

												<div class="full">

													<label for="emailO">

														Email:</label><input type='email' name='emailO' id='emailO' size='25' />

												</div>

											<div style="height:15px;"></div>

											<div style="clear:both;overflow:hidden">

												<button class='button' type="button" onclick='organization3();' style='cursor: pointer;float: right; width: 100px; margin-left: 25px;'>

													Next

												</button>

												<button class='button' type="button" onclick='organization();' style='cursor: pointer;float: right; width: 100px;'>

													Back

												</button>												

											</div>

                                            </form>

                        </div></div>

				<div id='organization3' class="double-border" style='position:fixed; top: 50%; left: 50%;width:520px;margin-top:-150px;margin-left:-260px;'>

										<div style="margin: 15px 15px 15px 15px;">

											<div style="float:right;overflow:hidden;">

												<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>											

												<p style="float:right;margin-top:5px;margin-right:15px;">

													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization

												</p>												

											</div>

                                            <form name="signupOrganization3" id="signupOrganization3" action="" method="post">

												<div class="full">

													<span style="color:#FFFFFF;">Confirm </span><label for="emailS">Sign in Email:</label><input type='email' size='25' name='emailS' id='emailS' />

											</div>

											<div class="full">

												<label for="emailS2">

													Confirm Sign in Email:</label><input type='email' size='25' name='emailS2' id='emailS2' />

    										  </div>

											<div class="full">

													<span style="color:#FFFFFF;">Confirm </span><label for="passS">Password:</label><input type='password' size='25' name='passS' id='passS' />

											</div>

											<div class="full">

												<label for="passS2">

													Confirm Password:</label><input type='password' name='passS2' id='passS2' size='25' />

											</div>

											<div class="full"><p>

    											By clicking sign up you agree to our 

    											<a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">

    												The Fourth Branch Terms

    											</a>

    											 and that you had read our 

    											<a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">

    												Privacy Policy

    											</a>

    											, including our 

    											<a href="policy.php" target="_newtab" onclick="window.open('policy.php','_newtab');" style="color:red;">

    												cookie use

    											</a>

    											.</p>

    										</div>

											<div style="overflow:hidden;float:right">	

                                            <button class='button' type="button" onclick="mergeForms('signupOrganization2', 'signupOrganization', 'signupOrganization3');" name='addOrganization-button' id='addOrganization-button' style='cursor: pointer;float: right; width: 100px; margin-left: 25px;'>

													Sign Up

												</button>

												<button class='button' type="button" onclick='organization2();' style='cursor: pointer;float: right; width: 100px;'>

													Back

												</button>

											</div>

											<div style="clear:both;"></div>

											<p style="color:red;text-align:center;" id='o3status'></p>

										</form>

                                        </div></div>

                        <form name="toSubmit" id="toSubmit" action="" method="post">

                        </form>

				<table cellpadding='2' bgcolor='#CC0000' id='confirm2' style='position:fixed; top: 50%; left: 50%;margin-top:-200px;margin-left:-290px;'>

					<td>

						<table cellpadding='2' bgcolor='#2F68D1'>

							<td>

								<table cellpadding='2' bgcolor='#FFFFFF'>

									<td width="580">

										<div style="margin: 15px 15px 15px 15px;">

										<div style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;" class="xbut"></div>

											<br style="clear:both" />

											<p align='center'>

                                            <?php 

                                            $jsonj = jsonarray($output);

                                            if ($jsonj->name_taken == 'true'){ ?>

                                            Sorry, something went wrong. Please try again.         

                                            <?php } else { ?>

												Thank you for your submission, our team will review your application at this time and if approved will notify you via email.

											<?php } ?>

                                            </p>

											<div style="float:right;overflow:hidden;">

												<button class='button' onclick='toggleOverlay_new();' style='cursor: pointer;position:relative; float: right; width: 50px; margin-left: 25px;'>

													OK

												</button>

												<button class="button" style="cursor: pointer;float:right;width: 50px;" onclick='a();' id="button">

													Login

												</button>

											</div>

											<div style="clear:both;"></div>

										</div>

									</td>

								</table>

							</td>

						</table>

					</td>

				</table>

			</div>

	<script type="text/javascript" >

function mergeForms() {

    var forms = [];

    $.each($.makeArray(arguments), function(index, value) {

        forms[index] = document.forms[value];

    });

    var targetForm = forms[0];

    $.each(forms, function(i, f) {

        if (i != 0) {

            $(f).find('input, select, textarea')

                .hide()

                .appendTo($(targetForm));

        }

    });

    $(targetForm).submit();

}
		document.getElementById('introduction').style.display = 'none';

  		document.getElementById('forgot').style.display = 'none';

  		document.getElementById('forgot2').style.display = 'none';

  		document.getElementById('a').style.display = 'none';

		document.getElementById('individual').style.display = 'none';

		document.getElementById('confirm').style.display = 'none';

		document.getElementById('confirm2').style.display = 'none';

		document.getElementById('organization').style.display = 'none';

		document.getElementById('organization2').style.display = 'none';

		document.getElementById('organization3').style.display = 'none';
        
        function loginbutton() {
            $('#llLogin').submit();
        }

		function introduction() {
		  if ($('body').hasClass('overlaid')) {
          } else {
            	  $('body').toggleClass('overlaid');
          }
	   	document.getElementById('individual').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('introduction').style.display = 'block';

  		}

	   function individual() {

      	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('individual').style.display = 'block';

      }

   	function organization() {

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('individual').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('organization').style.display = 'block';

      }

   	function organization2() {

       /* This will be verification later

   		var names = document.signupOrganization.nameOrganization.value;

    		var address = document.signupOrganization.addressOrganization.value;

			var city = document.signupOrganization.cityOrganization.value;

			var state = document.signupOrganization.stateOrganization.value;

			var zip = document.signupOrganization.zipOrganization.value;

			var phone = document.signupOrganization.phoneOrganization.value;

            if (document.signupOrganization.corporation.checked == true) {

			var legal = document.signupOrganization.corporation.value;

			}		

			if (document.signupOrganization.nonProfit.checked == true) {

				var signupOrganization = document.legal.nonProfit.value;

			}

			if (document.signupOrganization.other.checked == true) {

				var legal = document.signupOrganization.other.value;

			}

			var cause = "";

			if (document.signupOrganization.federal.checked == true) {

				var cause = document.signupOrganization.federal.value;

			}		

			if (document.signupOrganization.state.checked == true) {

				var cause = document.signupOrganization.state.value;

			}

            var reason = document.getElementById("reason").value;

			if (names == "" || address == "" || city == "" || state == "" || zip == "" || phone == "" || legal == "" || reason == "" || cause == "") {

				document.getElementById('ostatus').innerHTML = 'Please fill out all of the form data.'+names+' '+address+' '+city+' '+state+' '+zip+' '+phone+' '+legal+' '+reason+' '+cause;

			} else {

*/

	   		document.getElementById('introduction').style.display = 'none';

				document.getElementById('individual').style.display = 'none';

				document.getElementById('organization').style.display = 'none';

				document.getElementById('organization3').style.display = 'none';

				document.getElementById('forgot').style.display = 'none';

  				document.getElementById('forgot2').style.display = 'none';

  				document.getElementById('a').style.display = 'none';

  				document.getElementById('confirm').style.display = 'none';

				document.getElementById('confirm2').style.display = 'none';

  				document.getElementById('organization2').style.display = 'block';

  			

      }

   	function organization3() {

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('individual').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('organization3').style.display = 'block';

      }

   	function confirm() {

      	document.getElementById('individual').style.display = 'none';

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

			document.getElementById('confirm').style.display = 'none';

  			document.getElementById('confirm').style.display = 'block';

   	}

   	function confirm2() {

      	document.getElementById('individual').style.display = 'none';

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

  			document.getElementById('confirm2').style.display = 'block';

   	}

		function forgot() {

	   	document.getElementById('individual').style.display = 'none';

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('confirm').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('forgot').style.display = 'block';

      }

   	function forgot2() {

	   	document.getElementById('individual').style.display = 'none';

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('confirm').style.display = 'none';

  			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('a').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'block';

  		}

   	function a() {

	   	document.getElementById('individual').style.display = 'none';

	   	document.getElementById('introduction').style.display = 'none';

			document.getElementById('organization').style.display = 'none';

			document.getElementById('organization2').style.display = 'none';

			document.getElementById('organization3').style.display = 'none';

			document.getElementById('confirm').style.display = 'none';

  			document.getElementById('forgot').style.display = 'none';

  			document.getElementById('forgot2').style.display = 'none';

  			document.getElementById('confirm').style.display = 'none';

			document.getElementById('confirm2').style.display = 'none';

  			document.getElementById('a').style.display = 'block';

  		}

	</script>