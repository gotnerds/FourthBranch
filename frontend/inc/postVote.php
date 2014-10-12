<?php   
if (isset($_POST['voteUser'])) {
    echo "HOLA!";
    $date = date("Y-m-d");
    $userVote = $_POST['voteUser'];
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

    }
} else {
    echo "HELLO";
    // logged out
}
    ?>