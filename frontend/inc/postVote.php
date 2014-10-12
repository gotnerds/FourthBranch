<?php   
include "db_conx.php";
if (isset($_POST['voteUser'])) {
    $date = date("Y-m-d");
    $userVote = $_POST['voteUser'];
    $user_id = $_POST['user_id'];
    $billId = $_POST['billId'];
    $org_id = $_POST['org_id'];
    $stmt = $pdo->prepare("CALL insertUserVote(?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $billId, PDO::PARAM_STR);
    $stmt->bindParam(2, $user_id, PDO::PARAM_STR);
    $stmt->bindParam(3, $org_id, PDO::PARAM_STR);
    $stmt->bindParam(4, $userVote, PDO::PARAM_STR);
    $stmt->bindParam(5, $date, PDO::PARAM_STR);
    $rs = $stmt->execute();
    $stmt = $pdo->prepare("CALL getUserVote(?, ?)");
    $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
    $stmt->bindParam(2, $billId, PDO::PARAM_STR);
    $rs = $stmt->execute();
    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        $vote = $result[0]['vote'];
        if ($vote == 'pass') {
            echo '<input type="radio" class="votePass" name="voteUser" id="pass'.$billId.'" value="pass" checked />';
        }
        echo '<label for="pass'.$billId.'">PASS<span></span></label>';
        if ($vote == 'reject') {
            echo '<input type="radio" class="voteReject" name="voteUser" id="reject'.$billId.'" value="reject" checked />';
        }
        echo '<label for="reject'.$billId.'">REJECT<span></span></label>';
    return $billId;
    }
} else {
    echo "<p>You are not logged in. Please login and try again.</p>";
    // logged out
}
    ?>