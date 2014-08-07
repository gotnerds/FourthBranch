<!doctype html>
<!-- authentication info -->
<?php
    if (isset($_POST['login-button']))
    {
        exec("perl ./cgi-bin/fourthBranch.pl run=loginIndividual email=".$_POST['username']." password=".$_POST['password'], $output, $return_val);
        print_r ($output);
        $search_text = 'successful';
        array_filter($output, function($el) use ($search_text) {
        return ( strpos($el['text'], $search_text) !== false );
    });
        
        if (in_array("successful", $output)){
            if (find("true", $output)) {
                echo "Yay! It worked!";
            } else {
                echo "Uh oh.. Try again!";
            } 
        } else {
            echo "something's wrong";
        }
        echo 'output= '.array_values($output).' and return_val= '.$return_val;
    }
    
    
?>
<html lang="en">
<head>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
<meta charset="utf-8">

  <title>The Fourth Branch</title>
  <meta name="description" content="Keeping you updated and involved in the ongoing political process.">
  <meta name="author" content="The Fourth branch">
  <link rel="stylesheet" href="css/styles.css" type="text/css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="js/html5shiv.min.js"></script>
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>
</head>

<body>
<!-- <div id="lightboxx">
<script>
$('#lightbox').click(function(){
 $(this).css("display","none");
});
</script>
<div class="signup-type">
<h2>Are you an individual or an organization?</h2>
<a href="#" onclick="toggle_visibility('signup-org');">Organization</a>
<a href="#" onclick="toggle_visibility('signup-ind');">Individual</a>
</div>
<div id="inner-lightbox">
<form name="registration" method="post" action="registration.php">
we will create registration.php after registration.html
USERNAME:<input type="text" name="name" value=""></br>
EMAIL-ID:<input type="text" name="email" value=""></br>
PASSWORD:<input type="text" name="password" value=""></br>
RE-PASSWORD:<input type="text" name="repassword" value=""></br>
<input type="submit" name="submit" value="submit">
</form>
</div>
</div>
-->
    <div id="container">
        <section id="header-bar">
            <div class="left">
                <a href="#">ABOUT</a>
                <a href="#">CONTACT</a>
                <a href="#">DONATE</a>
            </div>
            <div class="right">
                <a style="cursor: pointer;" onclick='toggleOverlay1();'>SIGN UP</a>
                <a href="#" onclick="toggle_visibility('login');">LOGIN</a>
            </div>
            <div id="header">
                <header id="logo">
                    The Fouth Branch
                </header>
                <nav id="nav">
                    <a href="/home">HOME</a>
                    <a href="/vote">VOTE</a>
                    <a href="/proposal">PROPOSAL</a>
                    <a href="/news">NEWS</a>
                </nav>
                <div id="search">
                    <input type="search" placeholder="Search..." results="5" name="s"><span>&rsaquo;&rsaquo;</span>
                </div>
            </div>
        </section>
        <script type="text/javascript">
function toggleOverlay_new(){
            	document.body.className = document.body.className.indexOf('overlaid') != -1 ? '' : 'overlaid';
        			<?php 
					/*	if ($user_ok != true){
							echo "
        						if(document.getElementById('a').style.display == 'block'){
		    						document.getElementById('a').style.display = 'none';
		  						}else if(document.getElementById('a').style.display == 'none'){
		    						document.getElementById('a').style.display = 'block';
		  						}";
		  				}
					*/?>
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
			 				}      		}
      		document.addEventListener('DOMContentLoaded', function() {
        		document.querySelector('.overlay').addEventListener('click', function(ev) {
          			if (/overlay|wrap/.test(ev.target.className)) toggleOverlay();
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
										<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
										<h2 style='text-align:center;clear:both;'>
											Login or Sign Up
										</h2>																				
										<form action="" name="llLogin" id="llLogin" method="post">
											<input type='email' id="username" name="username" size='20' placeholder='Email' />
											<input type='password' size='20' id="password" name="password" placeholder='Password' />
									
										<div style='overflow:hidden;'>
                                        
                                        
											<button id='button' name='login-button' type="submit" style='cursor: pointer;width:100px;float:left;margin-left:15px;font-size:larger;'>
												Login
											</button>
                                            
											<script type="text/javascript" >
												function login1(){        
														username=$("#username").val();
                                                        password=$("#password").val();
                                                        if((username == '') || (password == ''))
														{
														$("#username").val("Incorrect Email or password");
														}
														else
														{
                                                        
                                                        $.ajax({
                                                           type: "POST",
                                                           url: 'login.php',
                                                           data: "username="+username+"&password="+password,
                                                           success: function(html)
                                                           {
                                                              if (html == 'true') {
                                                                window.location = '/user-page.php';
                                                              }
                                                          else {
                                                            alert('Invalid Credentials');
                                                            window.console&&console.log(html);
                                                              }
                                                           }
                                                       });
                                                        return false;
													  }
												}
											</script>
											<button id='button' onclick='introduction();' style='cursor: pointer;width:100px;float:right;margin-right:20px;font-size:larger;'>
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
										<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
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
    										<button id='button' name='forgot-button' type="submit"  style="float:left;">
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
										<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
										<h3 style="clear:both;"align="center">
											Step 2:
										</h3>
										<p>
											Check your email inbox in a few minutes.
										</p>
										<div style="float:right;overflow:hidden;">
											<button id='button' 
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
										<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
										<br style="clear:both;" />
										<h3 align='center' >
											Are you an Individual or Organization?
										</h3>
										<button id='button' 
												  onclick='individual();' 
												  style='font-size:larger;position:relative; float: left; width: 120px; margin-left: 25px;'
										>
											Individual
										</button>
                                                                               
										<button id='button' onclick='organization();' style='font-size:larger;float: right; width: 120px; margin-right: 25px;'>
											Organization
										</button>
										<div style="clear:both;" ></div>
									</div>
                                </div>
			<div class="double-border" id='individual' style='position:fixed; width:750px; top: 50%; left: 50%;margin-top:-200px;margin-left: -375px; '>
									<div style="margin: 15px 15px 15px 15px">											
										<div style="float:right;overflow:hidden;">
											<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>									
											<p style="float:right;margin-top:5px;margin-right:15px;">
												Individual &nbsp; &nbsp; | &nbsp; &nbsp; <span style='color:grey;'>Organization</span>
											</p>												
										</div>
                                        <form name="individualLogin" width="700">
										<div style="clear:both;"></div>
										<div style="margin-right:15px;font-size:14px;"> 
                                                <table>
					                           <div style='float:right;'>
                                                    <tr>
													<td width="100" align="right">First Name:</td>
													<td width="250" align="left">
											     		<input type='text' style="width:150px;" name='fname' id='fname' maxlength='20'>
													</td>
													<td width="120" align="right">Last Name:</td>
													<td width="230" align="left">
														<input type='text' style="width:150px;" name='lname' id='lname' maxlength='20'>
													</td>	
                                                    </tr>
										      	</div>
											<div style="clear:both;"></div>
											<div style="float:right;margin-top:-10px;">
														<tr>
														<td width="100" align="right">Username:</td>
															<td width="250" align="left">
																<input type='text' style="width:150px;" name='pseudonym' id='pseudonym' maxlength='20'> 
															</td>
															<td width="120" align="right">Date of Birth:</td>
															<td width="230" align="left">
																<input type='date' style="width:150px;" name='dob' id='dob' placeholder="mm/dd/yyyy">
															</td>													
														</tr>	
											</div>
											<div style="clear:both;"></div>
    										<div style="float:right;margin-top:-10px;">
														<tr>
															 <td width="100" align="right">
																Email:
															</td>		
															<td width="250" align="left">
																<input type='email' name='emailI' id='emalI' style="width:150px;" />	
															</td>	
                                                         <td width="120" align="right" style="white-space:nowrap;">
																Confirm Email:
															</td>		
															<td width="230" align="left">
																<input type='email' name='emailI2' id='emalI2' style="width:150px;" />
															</td>															
														</tr>												
											</div>
											<div style="clear:both;"></div>
											<div style="float:right;margin-top:-10px;">
														<tr>
															<td width="100" align="right">
																Password:
															</td>		
															<td width="250" align="left">
																<input type='password' name='passI' id='passI' style="width:150px;" />
															</td>
                                                              <td width="120" align="right" style="white-space:nowrap;">
																Confirm Password:
															</td>		
															<td width="230" align="left">
																<input type='password' name='passI2' id='passI2' style="width:150px;" />
															</td>																
														</tr>	
											</div>	
											<div style="clear:both;"></div>
											<div style="float:right;margin-top:-10px;">
														<tr>
															<td width="100" align="right">
																Gender: 
															</td>
															<td width="600" align="left">
																<input type='checkbox' name="male" value="m" onClick="genderMale();" />Male 
																<script type="text/javascript" >
																	function genderMale() {
																		document.gender.female.checked = false;
																	}
																</script>
																&nbsp; 
																<input type='checkbox' name="female" value="f" onClick="genderFemale();" />Female
																<script type="text/javascript" >
																	function genderFemale() {
																		document.gender.male.checked = false;
																	} 	
																</script>
															</td>													
														</tr>										
											</div>
											<div style="float:right;margin-top:-10px;">
														<tr>
														<td width="100" align="right">
																Address: 
															</td>
															<td width="600" align="left">
																<input style="width:600px;" type='text' name='address' id='address' /> 
															</td>																											
														</tr>				
											</div>
											<div style="clear:both;"></div>
											<div style="float:right;margin-top:-10px;">
														<tr>
														<td width="100" align="right">
																City:
															</td>
															<td width="150" align="left">
																<input type='text' style="width:150px;" name='city' id='city' />  
															</td>
															<td width="100" align="right">
																State:
															</td>
															<td width="150" align="left">
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
															</td>
                                              <td width="100" align="right">
																Zip:
															</td>															
															<td width="100" align="left">
																<input type='text' size='10' name='zip' id='zip' />
															</td>													
														</tr>			
    										</div>
    																											
    										<div style="clear:both;margin-top:-10px;"></div>
    										<div style="overflow:hidden;margin-left:15px;">	
    											<div style="float:left">
    												Political Leaning:
    											</div>=
    												<div style="overflow:hidden">
    													<div style="float:left">
    														&nbsp;
    														<input type='checkbox' onClick="politicalRepublican();" value="r" name="republican" />Republican 
    														&nbsp; 
    													</div>
    													<div style="float:left">
    														<input type='checkbox' onClick="politicalDemocrat();" value="d" name="democrat" />Democrat 
    														&nbsp;
    													</div>
    													<div style="float:left"> 
    														<input type='checkbox' onClick="politicalLibertarian();" value="l" name="libertarian" />Libertarian 
    														&nbsp; 
    													</div>
    													<div style="float:left">
    														&nbsp;
    														<input type='checkbox' onClick="politicalIndependent();" value="i" name="independent" />Independent 
    														&nbsp; 
    													</div>
    													<div style="float:left">
    														<input type='checkbox' onClick="politicalOther();" value="o" name="other" style="margin-top:5px;" />Other
    													</div>
    													<div style="float:left">
    														<input type='text' style="width:150px;display:none;" name='otherBox' id='otherBox' placeholder='If other, please enter here' /> 
    													</div>
    												</div>
    												<script type="text/javascript" >
														function politicalRepublican() {
															document.political.democrat.checked = false;
															document.political.libertarian.checked = false;
															document.political.independent.checked = false;
															document.political.other.checked = false;
															document.political.otherBox.style.display = 'none';
														}
														function politicalDemocrat() {
															document.political.republican.checked = false;
															document.political.libertarian.checked = false;
															document.political.independent.checked = false;
															document.political.other.checked = false;
															document.political.otherBox.style.display = 'none';
														} 
														function politicalLibertarian() {
															document.political.republican.checked = false;
															document.political.democrat.checked = false;
															document.political.independent.checked = false;
															document.political.other.checked = false;
															document.political.otherBox.style.display = 'none';
														}
														function politicalIndependent() {
															document.political.republican.checked = false;
															document.political.democrat.checked = false;
															document.political.libertarian.checked = false;
															document.political.other.checked = false;
															document.political.otherBox.style.display = 'none';
														}
														function politicalOther() {
															document.political.republican.checked = false;
															document.political.democrat.checked = false;
															document.political.libertarian.checked = false;
															document.political.independent.checked = false;
															document.political.otherBox.style.display = 'block';
														}
													</script>
    										</div>
                                            </table>
    									</div>
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
    										<div style="float:right;overflow:hidden;">
    											<button id='isignup' 
    													  onclick="individualSignup();" 
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
    											<script>
													function individualSignup() {    													
    													var e = document.emailI.emailI.value;
    													var e2 = document.emailI.emailI2.value;
														var p1 = document.passI.passI.value;
														var p2 = document.passI.passI2.value;
														var state = document.city.state.value;
														var g = "";
														if (document.gender.male.checked == true) {
															g = document.gender.male.value;
														}		
														if (document.gender.female.checked == true) {
															g = document.gender.female.value;
														}														
														var party = '';
														if (document.political.republican.checked == true) {
															party = document.political.republican.value;
														}
														if (document.political.democrat.checked == true) {
															party = document.political.democrat.value;
														}
														if (document.political.libertarian.checked == true) {
															party = document.political.libertarian.value;
														}
														if (document.political.other.checked == true) {
															party = document.political.other.value;
														}
														if (document.political.independent.checked == true) {
															party = document.political.independent.value;
														}
														var psu = document.psu.pseudonym.value;
														var u = psu;
														var adr = document.address.address.value;
														var city = document.city.city.value;
														var zip = document.city.zip.value;
														var fname = document.names.fname.value;
														var lname = document.names.lname.value;												
														var dob = document.psu.dob.value;														
    													if (e == '' || p1 == "" || state == "" || g == "" || psu == "" || adr == "" || city == "" || zip == "" || fname == "" || lname == "" || dob == "") {
    														document.getElementById('istatus').innerHTML = "Please, fill out all of the form data";
														} else if (p1 != p2) {
															document.getElementById('istatus').innerHTML = "Your password fields do not match";
														} else if (e != e2){

															document.getElementById('istatus').innerHTML = "Your emails do not match";
														} else {
                                                        
                                                              $.ajax({
        type: "GET",
        url: "cgi-bin/fourthBrancHTML.pl", // URL of the Perl script
        dataType: "html",
        // send username and password as parameters to the Perl script
        data: "run=addIndividual&first="+fname+"&last="+lname+"&username="+psu+"&birthdate="+dob+"&gender="+g+"&address="+adr+"&city="+city+"&state="+state+"&zip="+zip+"&email="+e+"&password="+p1+"&affiliation="+party,        
        // script call was *not* successful
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
        window.console&&console.log("responseText: " + XMLHttpRequest.responseText 
            + ", textStatus: " + textStatus 
            + ", errorThrown: " + errorThrown);
          $('div#loginResult').text("responseText: " + XMLHttpRequest.responseText 
            + ", textStatus: " + textStatus 
            + ", errorThrown: " + errorThrown);
          $('div#loginResult').addClass("error");
        }, // error 
        // script call was successful 
        // data contains the JSON values returned by the Perl script 
        success: function(data){
                  window.console&&console.log(data);
                  document.getElementById('confirm').style.display = 'block';
        			document.getElementById('individual').style.display = 'none';
	   			    document.getElementById('introduction').style.display = 'none';
		            document.getElementById('organization').style.display = 'none';
					document.getElementById('organization2').style.display = 'none';
					document.getElementById('organization3').style.display = 'none';
					document.getElementById('forgot').style.display = 'none';
  					document.getElementById('forgot2').style.display = 'none';
  					document.getElementById('a').style.display = 'none';
					document.getElementById('confirm2').style.display = 'none';
        
        } // success
      }); // ajax
                                                        /*
														  var dataString = "psu="+psu+"&e="+e+"&p1="+p1+"&state="+state+"&g="+g+"&u="+u+"&adr="+adr+"&city="+city+"&zip="+zip+"&fname="+fname+"&lname="+lname+"&party="+party+"&dob="+dob;
															  //alert (dataString);return false;
															  $.ajax({
																type: "POST",
																url: "#",
																data: dataString,
																success: function(data, textStatus, jqXHR)
																{
																	document.getElementById('confirm').style.display = 'block';
																				document.getElementById('individual').style.display = 'none';
	   																		    document.getElementById('introduction').style.display = 'none';
																				document.getElementById('organization').style.display = 'none';
																				document.getElementById('organization2').style.display = 'none';
																				document.getElementById('organization3').style.display = 'none';
																				document.getElementById('forgot').style.display = 'none';
  																				document.getElementById('forgot2').style.display = 'none';
  																				document.getElementById('a').style.display = 'none';
																				document.getElementById('confirm2').style.display = 'none';
																},
																error: function (jqXHR, textStatus, errorThrown)
																{
																	console.log("err");
																}
															  });
                                                        */
															  return false;
  
															
															}
														}	
												</script>
												<button id='button' onclick='introduction();' style='cursor: pointer;width:100px;float: right;'>
													Back
												</button>
											</div>	
                                            </form>										
											<div style="clear:both;"></div>
											<p id="istatus" style="color:red;text-align:center;" ></p>
										</div>
					     
                            </div>
				<table cellpadding='2' bgcolor='#CC0000' id='confirm' style='position:fixed; top: 50%; left: 50%;margin-top:-200px;margin-left:-290px;'>
					<td>
						<table cellpadding='2' bgcolor='#2F68D1'>
							<td>
								<table cellpadding='2' bgcolor='#FFFFFF'>
									<td width="580">
										<div style="margin: 15px 15px 15px 15px;">
											<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
											<br style="clear:both" />
											<p align='center' >
												<!-- A confirmation link has been sent to your email address. -->
												You have activated your account and are now an active participant in your government.
											</p>
											<div style="float:right;overflow:hidden;">
												<button id='button' 
														  onclick='toggleOverlay_new();' 
														  style='cursor: pointer;position:relative; float: right; width: 50px; margin-left: 25px;'>
													OK
												</button>
												<button style="cursor: pointer;float:right;width: 50px;" onclick='a();' id="button">
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
				<table cellpadding='2' bgcolor='#CC0000' id='organization' style='position:fixed; top: 50%; left: 50%;margin-top:-200px;margin-left:-309px;'>
					<td>
						<table cellpadding='2' bgcolor='#2F68D1'>
							<td>
								<table cellpadding='2' bgcolor='#FFFFFF'>
									<td width="619">
										<div style="margin: 15px 15px 15px 15px;">
											<div style="float:right;overflow:hidden;">
												<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>										
												<p style="float:right;margin-top:5px;margin-right:15px;">
													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization
												</p>												
											</div>
											<div style="clear:both;margin-right:15px;">
											<div style="float:right;">
												<form name="nameOrganization">
												<label for="name">Name of Organization:</label>
													<input type='text' style="width:400px;" name='nameOrganization' id='nameOrganization' />
												</form>
											</div>
											<div style="height:5px;clear:both;"></div>
											<div style="float:right;">
												<form name="addressOrganization">
												<label for="name">Address:</label>
													<input type='text' id='addressOrganization' name='addressOrganization' style="width:400px" />
												</form>
											</div>
											<div style="clear:both;height:5px;"></div>
											<div style="float:right;">
												<form name="cityOrganization">
													City:&nbsp;<input type='text' size='20' name='cityOrganization' id='cityOrganization' />
													&nbsp;&nbsp;&nbsp;&nbsp;
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
    												</select> 
    												&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    												Zip:&nbsp;&nbsp;<input type='text' size='5' name='zipOrganization' id='zipOrganization' />
    											</form>
    										</div>
    										<div style="clear:both;height:5px;"></div>
									  		<div style="margin-left:30px;">
									  			<form name="phoneOrganization">
									  				Organization Phone:<input type='text' size='20' name='phoneOrganization' id='phoneOrganization' />
									  			</form>
									  		</div>
									  		<div style="height:5px;"></div>
									  		<div style="margin-left:75px;">
									  			<form name="legal">
									  				Legal Status:
									  				<input type='checkbox' onClick="legalCorporation();" value="c" name="corporation" />Corporation 
									  				&nbsp; 
									  				<input type='checkbox' onClick="legalNotForProfit();" value="n" name="nonProfit" />Not-for-Profit 
									  				&nbsp; 
									  				<input type='checkbox' onClick="legalOther();" value="o" name="other" />Other
									  				<input type='text' name="otherBox2" id='otherBox2' placeholder='If other, specify here' style="display:none;" />
									  			</form>		
									  			<script type="text/javascript" >
													function legalCorporation() {
														document.legal.nonProfit.checked = false;
														document.legal.other.checked = false;
														document.legal.otherBox2.style.display = 'none';
													}
													function legalNotForProfit() {
														document.legal.corporation.checked = false;
														document.legal.other.checked = false;
														document.legal.otherBox2.style.display = 'none';
													}
													function legalOther() {
														document.legal.nonProfit.checked = false;
														document.legal.corporation.checked = false;
														document.legal.otherBox2.style.display = 'block';
													}		
												</script>
									  		</div>
									  		<div style="height:10px;"></div>
									  		<div style="margin-left:10px;">
									  			<form name="cause">
									  				Your Cause Concerns:
									  				<input type='checkbox' value="f" name="federal" onClick="causeFederal();" />Federal Government 
									  				&nbsp; 
									  				<input type='checkbox' value="s" name="state" onClick="causeState();" />State
									  			</form>
									  			<script type="text/javascript" >
													function causeFederal() {
														document.cause.state.checked = false;
													 }
													function causeState() {
														document.cause.federal.checked = false;
													 }	
												</script>
									  		</div>
									  		<div style="height:10px;"></div>
									  	</div>
									  	<img id="blah" src="http://thefourthbranch.co/TheFourthBranch/fourth/image/avitar.png" alt="your image" width="103" height="125" style='width: 103px; height: 125px; float:left;' />
									  	<div style='float:right;overflow:hidden;'>
									  		<form id="textarea" style="float:right;" name="textarea">
									  			<textarea id='reason' name='reason' form="textarea" cols='35' rows='7' style='background-color: #E6E6E6; color:black;'></textarea>
									  		</form>
									  		<div style="float:right;">
									  			Reasons For Joining:
									  		</div>
									  	</div>
									  	<div style="clear:both;"></div>
									  	<form name="pic" runat="server">
									  		<input type='file' id="imgInp" name='pic' size='5' accept='image/*' style="float:left;" />
									  	</form>
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
									  		<button id='button' onclick='organization2();' style='cursor: pointer;width: 100px; float:right; margin-left: 25px;'>
									  			Next
									  		</button>
									  		<button id='button' onclick='introduction();' style='cursor: pointer;float: right;width: 100px;'>
									  			Back
									  		</button>
									  	</div>
									  	<p style="color:red;text-align:center;" id='ostatus'></p>
									 </div>
									</td>
								</table>
							</td>
						</table>
					</td>
				</table>
				<table cellpadding='2' bgcolor='#CC0000' id='organization2' style='position:fixed; top: 50%; left: 50%;margin-top:-150px;margin-left:-210px;'>
					<td>
						<table cellpadding='2' bgcolor='#2F68D1'>
							<td>
								<table cellpadding='2' bgcolor='#FFFFFF'>
									<td>
										<div style="margin: 15px 15px 15px 15px">
											<div style="float:right;overflow:hidden;">
												<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>											
												<p style="float:right;margin-top:5px;margin-right:15px;">
													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization
												</p>												
											</div>
											<div style="clear:both;margin-right:15px;">
												<div style="margin-left:13px">
													<form name="nameIndividual">
														Name of Individual:<input type='text' size='25' name='nameIndividual' id='nameIndividual' />
													</form>
												</div>
												<div style="height:5px;"></div>
												<div>
													<form name="titleIndividual">
														Title in Organization:<input type='text' size='25' name='titleIndividual' id='titleIndividual' />
													</form>
												</div>
												<div style="height:5px;"></div>
												<div style="margin-left:37px;">
													<form name="phonePersonal">
														Personal Phone:<input type='text' size='25' name='phonePersonal' id='phonePersonal' />
													</form>
												</div>
												<div style="height:5px;"></div>
												<div style="margin-left:107px;">
													<form name="emailO">
														Email:<input type='email' name='emailO' id='emailO' size='25' />
													</form>
												</div>
											</div>
											<div style="height:15px;"></div>
											<div style="float:right;overflow:hidden">
												<button id='button' onclick='organization3();' style='cursor: pointer;float: right; width: 100px; margin-left: 25px;'>
													Next
												</button>
												<button id='button' onclick='organization();' style='cursor: pointer;float: right; width: 100px;'>
													Back
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
				<table cellpadding='2' bgcolor='#CC0000' id='organization3' style='position:fixed; top: 50%; left: 50%;margin-top:-150px;margin-left:-260px;'>
					<td>
						<table cellpadding='2' bgcolor='#2F68D1'>
							<td>
								<table cellpadding='2' bgcolor='#FFFFFF'>
									<td width="520">
										<div style="margin: 15px 15px 15px 15px;">
											<div style="float:right;overflow:hidden;">
												<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>											
												<p style="float:right;margin-top:5px;margin-right:15px;">
													<span style='color:grey;'>Individual</span> &nbsp; &nbsp; | &nbsp; &nbsp; Organization
												</p>												
											</div>
											<div style='clear:both;'>
												<form name="emailS">
													<span style="color:#FFFFFF;">Confirm </span>Sign in Email:<input type='email' size='25' name='emailS' id='emailS' />
												</form>
											</div>
											<div style="height:5px;"></div>
											<div>
												<form name="emailS2">
													Confirm Sign in Email:<input type='email' size='25' name='emailS2' id='emailS2' />
												</form>
											</div>
											<div style="height:5px;"></div>
											<div style="margin-left:25px;">
												<form name="passS">
													<span style="color:#FFFFFF;">Confirm </span>Password:<input type='password' size='25' name='passS' id='passS' />
												</form>
											</div>
											<div style="height:5px;"></div>
											<div style="margin-left:25px;">
												<form name="passS2">
													Confirm Password:<input type='password' name='passS2' id='passS2' size='25' />
												</form>
											</div>
											<p>
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
    											.
    										</p>
											<div style="overflow:hidden;float:right">	
												<button id='button' onclick="organizationSignup();" style='cursor: pointer;float: right; width: 100px; margin-left: 25px;'>
													Sign Up
												</button>
												<script type="text/javascript" >
													function organizationSignup() {
    													var names = document.nameOrganization.nameOrganization.value;
    													var address = document.addressOrganization.addressOrganization.value;
														var city = document.cityOrganization.cityOrganization.value;
														var state = document.cityOrganization.stateOrganization.value;
														var zip = document.cityOrganization.zipOrganization.value;
														var phone = document.phoneOrganization.phoneOrganization.value;
														var legal = "";
														if (document.legal.corporation.checked == true) {
															var legal = document.legal.corporation.value;
														}		
														if (document.legal.nonProfit.checked == true) {
															var legal = document.legal.nonProfit.value;
														}
														if (document.legal.other.checked == true) {
															var legal = document.legal.other.value;
														}
														var cause = "";
														if (document.cause.federal.checked == true) {
															var cause = document.cause.federal.value;
														}		
														if (document.cause.state.checked == true) {
															var cause = document.cause.state.value;
														}
														var reason = document.getElementById("reason").value;
														var avi = document.pic.pic.value;
														var nameI = document.nameIndividual.nameIndividual.value;
														var titleI = document.titleIndividual.titleIndividual.value;
														var phoneP = document.phonePersonal.phonePersonal.value;
														var emailO = document.emailO.emailO.value;
														var emailS = document.emailS.emailS.value;
														var emailS2 = document.emailS2.emailS2.value;
														var passS = document.passS.passS.value;
														var passS2 = document.passS2.passS2.value;
    													if (names == "" || address == "" || city == "" || state == "" || zip == "" || phone == "" || legal == "" || reason == "" || nameI == "" || titleI == "" || phoneP == "" || emailO == "" || emailS == "" || passS == "" || cause == "") {
    														document.getElementById('o3status').innerHTML = "Please, fill out all of the form data";
														} else if (passS != passS2) {
															document.getElementById('o3status').innerHTML ="Your password fields do not match";
														} else if (emailS != emailS2){
															document.getElementById('o3status').innerHTML ="Your Sign in Emails do not match";
														} else {
                                                        
                                                         $.ajax({
        type: "GET",
        url: "cgi-bin/fourthBrancHTML.pl", // URL of the Perl script
        dataType: "html",
        // send username and password as parameters to the Perl script
          data: "run=addOrganization&name="+names+"&address="+address+"&city="+city+"&state="+state+"&zip="+zip+"&phone="+phone+"&legalstatus="+legal+"&cause="+cause+"&joinreason="+reason+"&individualname="+nameI+"&titleorganization="+titleI+"&personalphone="+phoneP+"&email="+emailO+"&password="+passS,        
        // script call was *not* successful
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
        window.console&&console.log("responseText: " + XMLHttpRequest.responseText 
            + ", textStatus: " + textStatus 
            + ", errorThrown: " + errorThrown);
          $('div#loginResult').text("responseText: " + XMLHttpRequest.responseText 
            + ", textStatus: " + textStatus 
            + ", errorThrown: " + errorThrown);
          $('div#loginResult').addClass("error");
        }, // error 
        // script call was successful 
        // data contains the JSON values returned by the Perl script 
        success: function(data){
          if (data.successful) { // script returned error
                  window.console&&console.log(data);
            $('div#loginResult').text("data.error: " + data.error);
            $('div#loginResult').addClass("error");
          } // if
          else { // login was successful
                  window.console&&console.log(data);
            $('form#loginForm').hide();
            $('div#loginResult').text("data.success: " + data.success 
              + ", data.userid: " + data.userid);
            $('div#loginResult').addClass("success");
          } //else
        } // success
      }); // ajax
                                                        
																var dataString = "legal="+legal+"&name="+names+"&address="+address+"&city="+city+"&state="+state+"&zip="+zip+"&phone="+phone+"&reason="+reason+"&nameI="+nameI+"&titleI="+titleI+"&phoneP="+phoneP+"&emailO="+emailO+"&emailS="+emailS+"&passS="+passS+"&cause="+cause;							
																	$.ajax({
																		type: "POST",
																		url: "#",
																		data: dataString,
																		success: function(data, textStatus, jqXHR)
																		{
																			   document.getElementById('confirm2').style.display = 'block';
																				document.getElementById('individual').style.display = 'none';
	   																		    document.getElementById('introduction').style.display = 'none';
																				document.getElementById('organization').style.display = 'none';
																				document.getElementById('organization2').style.display = 'none';
																				document.getElementById('organization3').style.display = 'none';
																				document.getElementById('forgot').style.display = 'none';
  																				document.getElementById('forgot2').style.display = 'none';
  																				document.getElementById('a').style.display = 'none';
																				document.getElementById('confirm').style.display = 'none';
																		},
																		error: function (jqXHR, textStatus, errorThrown)
																		{
																			document.getElementById('o3status').innerHTML = "An Unknown Error Occurred";							
																		}
																  });																
														}
													}
												</script>
												<button id='button' onclick='organization2();' style='cursor: pointer;float: right; width: 100px;'>
													Back
												</button>
											</div>
											<div style="clear:both;"></div>
											<p style="color:red;text-align:center;" id='o3status'></p>
										</div>
									</td>
								</table>
							</td>
						</table>
					</td>
				</table>
				<table cellpadding='2' bgcolor='#CC0000' id='confirm2' style='position:fixed; top: 50%; left: 50%;margin-top:-200px;margin-left:-290px;'>
					<td>
						<table cellpadding='2' bgcolor='#2F68D1'>
							<td>
								<table cellpadding='2' bgcolor='#FFFFFF'>
									<td width="580">
										<div style="margin: 15px 15px 15px 15px;">
										<div onclick='toggleOverlay_new();' style="cursor: pointer;float:right;background-image: url(http://thefourthbranch.co/TheFourthBranch/image/x.png);height:24px;width:24px;"></div>
											<br style="clear:both" />
											<p align='center'>
												Thank you for your submission, our team will review your application at this time and if approved will notify you via email.
											</p>
											<div style="float:right;overflow:hidden;">
												<button id='button' onclick='toggleOverlay_new();' style='cursor: pointer;position:relative; float: right; width: 50px; margin-left: 25px;'>
													OK
												</button>
												<button style="cursor: pointer;float:right;width: 50px;" onclick='a();' id="button">
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
		</div>
	</div>
	<script type="text/javascript" >
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
			
		function introduction() {
	   		
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
   		var names = document.nameOrganization.nameOrganization.value;
    		var address = document.addressOrganization.addressOrganization.value;
			var city = document.cityOrganization.cityOrganization.value;
			var state = document.cityOrganization.stateOrganization.value;
			var zip = document.cityOrganization.zipOrganization.value;
			var phone = document.phoneOrganization.phoneOrganization.value;
			var legal = "";
			if (document.legal.corporation.checked == true) {
				var legal = document.legal.corporation.value;
			}		
			if (document.legal.nonProfit.checked == true) {
				var legal = document.legal.nonProfit.value;
			}
			if (document.legal.other.checked == true) {
				var legal = document.legal.other.value;
			}
			var cause = "";
			if (document.cause.federal.checked == true) {
				var cause = document.cause.federal.value;
			}		
			if (document.cause.state.checked == true) {
				var cause = document.cause.state.value;
			}
			var reason = document.getElementById("reason").value;
			if (names == "" || address == "" || city == "" || state == "" || zip == "" || phone == "" || legal == "" || reason == "" || cause == "") {
				document.getElementById('ostatus').innerHTML = 'Please fill out all of the form data.';
			} else {
	   	
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
