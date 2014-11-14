<?php
include_once 'db_conx.php';
include_once 'functions.php';
sec_session_start();
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $verified = 1;
    $email = mysql_escape_string($_GET['email']); // Set email variable
    $hash = mysql_escape_string($_GET['hash']); // Set hash variable
    $sql = "UPDATE individuals SET activated='1' WHERE email='".$email."' AND verification='".$hash."' AND activated='0'";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	if($stmt->rowCount() == 1) {
		$_SESSION['error_msg'] = 'Your account is now verified. Please sign in.';
		header('Location: ../index.php');
	} else {
		$sql = "UPDATE organizations SET verified='1' WHERE email='".$email."' AND verification='".$hash."' AND verified='0'";
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		if($stmt->rowCount() == 1) {
			$_SESSION['error_msg'] = 'Your account is now verified. Please sign in.';
			header('Location: ../index.php');
		} else {
			header('Location: ../index.php?err=Verification_Error');
		}
	}
}else{
	header('Location: ../index.php?err=Connection_Error');
}