<?php 
if($logged == 'in') {
    $billId = $row['id'];
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("CALL getUserVote(?, ?)");
    $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
    $stmt->bindParam(2, $billId, PDO::PARAM_STR);
    $rs = $stmt->execute();
    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        $vote = $result[0]['vote'];
    } else {
        // no vote yet
        if (isset($_POST['voteUser'])) {
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
        }
    }
} else {
    // logged out
}
    ?>
    <form class="voteUser hasRadio" action='' method="POST">
            <?php 
            if($logged == 'in'){
                if(isset($vote)) {
                    if ($vote == 'pass') { ?>
                        <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" checked />
                    <?php } elseif ($vote == 'reject') {
                    } } else { ?>
                        <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange="this.form.submit()" />
                    <?php } 
                } else { ?>
                    <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange="a()" /> <?php } ?>
        <label for="pass">PASS<span></span></label>
        <?php 
            if($logged == 'in'){
                if(isset($vote)) {
                    if ($vote == 'reject') { ?>
                        <input type="radio" class="voteReject" name="voteUser" id="reject" value="reject" checked /><?php
                    } elseif ($vote == 'pass') {
                    } } else { ?>
                        <input type="radio" class="voteReject" name="voteUser" id="reject" value="reject" onChange="this.form.submit()" />
                    <?php } 
                } else { ?>
                    <input type="radio" class="voteReject" name="voteUser" id="reject" value="reject" onChange="a()" /> <?php } ?>
        <label for="reject">REJECT<span></span></label>
    </form>