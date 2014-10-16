<?php
include_once 'db_conx.php';
function url(){
  return sprintf(
    "%s://%s",
    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
    $_SERVER['SERVER_NAME']
  );
}
if (isset($_POST['type'])) {
	$code = $_POST['code'];
	$shareTitle = $_POST['title'];
	$type = $_POST['type'];
	$localURL = '/FourthBranch/FourthBranch/frontend/';
	$reddit = 0;
	$google = 0;
	$facebook = 0;
	$linkedin = 0;
	$twitter = 0;
	$billId = $_POST['id'];
	$shareURL = url().$localURL.'bill.php?code='.$code;
	switch ($type) {
		case 'reddit':
			$UrlToShare = "http://reddit.com/submit?url=".$shareURL."&title=".$shareTitle;
			$reddit = 1;
			break;
		case 'google':
			$UrlToShare = "https://plus.google.com/share?url=".$shareURL;
			$google = 1;
			break;
		case 'facebook':
			$UrlToShare = "http://www.facebook.com/sharer.php?u=".$shareURL."&t=".$shareTitle;
			$facebook = 1;
			break;
		case 'linkedin':
			$UrlToShare = "http://www.linkedin.com/shareArticle?mini=true&url=".$shareURL."&title=".$shareTitle."&source=The Fourth Branch";
			$linkedin = 1;
			break;
		case 'twitter':
			$UrlToShare = "https://twitter.com/intent/tweet?source=The Fourth Branch&url=".$shareURL;
			$twitter = 1;
			break;
		case 'comment':
			$UrlToShare = $shareURL."#addComment";
			$comment = 1;
			break;
		default:
			# code...
			break;
	}
	if (isset($comment)) {
			echo '<script type="text/javascript" language="javascript"> 
		window.open("'.$UrlToShare.'"); 
		</script>';
	} elseif (isset($UrlToShare)){
		$stmt = $pdo->prepare("SELECT * FROM bill_votes WHERE billId = ? LIMIT 1");
    	$stmt->bindParam(1, $billId, PDO::PARAM_INT);
	    $stmt->execute();
	    if($stmt->rowCount() == 1){
			$row = $stmt->fetch();
			$reddit = $row['reddit'] + $reddit;
			$google = $row['google'] + $google;
			$facebook = $row['facebook'] + $facebook;
			$twitter = $row['twitter'] + $twitter;
			$linkedin = $row['linkedin'] + $linkedin;
		    $stmt = $pdo->prepare('CALL updateBillVote(:bill_Id, :reddit, :google, :facebook, :twitter, :linkedin)');
			$stmt->bindParam(':bill_Id', $billId, PDO::PARAM_STR);
		    $stmt->bindParam(':reddit', $reddit, PDO::PARAM_INT);
		    $stmt->bindParam(':google', $google, PDO::PARAM_INT);
		    $stmt->bindParam(':facebook', $facebook, PDO::PARAM_INT);
		    $stmt->bindParam(':twitter', $twitter, PDO::PARAM_INT);
		    $stmt->bindParam(':linkedin', $linkedin, PDO::PARAM_INT);
			$stmt->execute();
			echo '<script type="text/javascript" language="javascript"> 
				window.open("'.$UrlToShare.'"); 
				</script>';
	    } else {
        	$stmt = $pdo->prepare('CALL insertBillVote(:billId, :reddit, :google, :facebook, :twitter, :linkedin)');
		    $stmt->bindValue(':billId', $billId, PDO::PARAM_INT);
		    $stmt->bindParam(':reddit', $reddit, PDO::PARAM_INT);
		    $stmt->bindParam(':google', $google, PDO::PARAM_INT);	
		    $stmt->bindParam(':facebook', $facebook, PDO::PARAM_INT);
		    $stmt->bindParam(':twitter', $twitter, PDO::PARAM_INT);
		    $stmt->bindParam(':linkedin', $linkedin, PDO::PARAM_INT);
			if ($stmt->execute() ) {
				echo '<script type="text/javascript" language="javascript"> 
						window.open("'.$UrlToShare.'"); 
						</script>';
			} else {
				echo '<h4>Something went wrong. The developers have been notified.</h4>';
			}
		}
    }
}
?>