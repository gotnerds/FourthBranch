<?php
include_once './inc/register.inc.php';
include_once './inc/functions.php';
if (isset($_POST)) {
	//var_dump($_POST);
}
include "./inc/db_conx.php";
include_once './inc/db_connect.php';
#include "./inc/userRoles.php"
sec_session_start();
if (login_check($mysqli) == true) {
    $logged = 'in';
    //echo $logged;
    $username = $_SESSION['username'];
    $currentUserId = $_SESSION['user_id'];
} else {
    $logged = 'out';
    $username = "please sign in";
}
if (!empty($error_msg)) {
    echo $error_msg;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>The Fourth Branch</title>
  <meta name="description" content="Keeping you updated and involved in the ongoing political process." />
  <meta name="author" content="The Fourth branch" />
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="icon" href="images/favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/css.css" type="text/css" rel="stylesheet" media="screen, projection">
<!-- for online access
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
-->
  <script src="js/jquery.js" type="text/javascript"></script>
  <script src="js/html5shiv.min.js"></script>
  <script src="js/sha512.js" type="text/javascript"></script>
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
<!-- authentication info -->
</head>
<body>
    <?php include "./inc/loginModal.php"; ?>
	<header id="siteHeader">
		<nav id="extraNav" role="navigation">
			<a href="about.php">About</a> | 
			<a href="contact.php">Contact</a> | 
			<a href="contribute.php">Contribute</a>
		</nav>
			<?php 
                if($logged == 'in') {
            ?>

			<section class="headerLogin" style="width: 50%;text-align: right;margin-right: 10px;height: 50px;">
            Welcome 
            <a href="profile.php?id=<?php echo $_SESSION['user_id']; ?>"><?php echo $_SESSION['username']; ?></a> | 
            <a id="logout-button" href="inc/logout.php">Logout  </a>
            <?php
            } else {
            ?>
		<section class="headerLogin">
			<table cellspacing="0">
			    <form action="inc/process_login.php" name="Login" id="login" method="post">
					<tbody>
						<tr>
							<td class="html7magic">
								<label for="username">Email</label>
							</td>
							<td class="html7magic">
								<label for="password">Password</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="text" class="inputtext" name="email" id="email" size="14" value="" tabindex="1">
							</td>
							<td>
								<input type="password" class="inputtext" name="password" id="password" size="14" tabindex="2">
							</td>
							<td>
								<button type="button" onclick="formhash(this.form, this.form.password);" name="login-button" class="linkButton">Login</button> |  

							</td>
							<td>
								<a id="signup-button" onclick="introduction();" style="cursor:pointer;">Signup</a>
							</td>
						</tr>
						<tr>
							<td>
								<div>
									<div class="uiInputLabel clearfix uiInputLabelLegacy">
										<input id="rememberMe" type="checkbox" name="rememberMe" value="1" checked="1" class="uiInputLabelInput uiInputLabelCheckbox">
										<label for="rememberMe" class="uiInputLabelLabel">Remember Me?</label>
									</div>
									<input type="hidden" name="default_rememberMe" value="1">
								</div>
							</td>
							<td>
		               			<a onclick="forgotPassword();" style="cursor:pointer;">Forgot Password?</a>
							</td>
						</tr>
					</tbody>
				</form>
			</table>
            <?php } ?>
        </section>
        <div id="logo" role="banner"><img src="images/logo.png" width="600" /></div>
        <nav id="mainNav" role="navigation">
        	<a href="index.php">Home</a>
        	<a href="vote.php">Vote</a>
        	<a href="proposal.php">Proposal</a>
        	<a href="news.php">News</a>
        	<a href="wallofamerica.php">Wall of America</a>
        </nav>
    </header>
