<?php   
include "db_conx.php";
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();
if (login_check($mysqli) == true) {
    $logged = 'in';
    if (isset($_POST['voteUser'])) {
        $date = date("Y-m-d");
        $userVote = $_POST['voteUser'];
        $organization_id = $_POST['organization_id'];
        $user_id = $_POST['user_id'];
        $billId = $_POST['billId'];
        $stmt = $pdo->prepare("CALL insertUserVote(?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $billId, PDO::PARAM_STR);
        $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(3, $organization_id, PDO::PARAM_STR);
        $stmt->bindParam(4, $userVote, PDO::PARAM_STR);
        $stmt->bindParam(5, $date, PDO::PARAM_STR);
        $rs = $stmt->execute();
        $vote = $userVote;
        if ($vote == 'pass') {
            echo '<input type="radio" class="votePass" name="voteUser" id="pass'.$billId.'" value="pass" checked />';
        }
        echo '<label for="pass'.$billId.'">PASS<span></span></label>';
        if ($vote == 'reject') {
            echo '<input type="radio" class="voteReject" name="voteUser" id="reject'.$billId.'" value="reject" checked />';
        }
        echo '<label for="reject'.$billId.'">REJECT<span></span></label>';
    }
    //echo $logged;
} else {
    $logged = 'out';
    //echo $logged;
    echo "<p>You are not logged in. Please login and try again.</p>";
    // logged out
}
    ?>