<?php 
if($logged == 'in') {
    unset($vote);
    $billId = $row['id'];
    if ($_SESSION['userType'] == "organization") {
            $organization_id = $_SESSION['user_id'];
            $stmt = $pdo->prepare("CALL getOrganizationVote(?, ?)");
            $stmt->bindParam(1, $organization_id, PDO::PARAM_STR);
            $stmt->bindParam(2, $billId, PDO::PARAM_STR);
            $rs = $stmt->execute();
    } elseif ($_SESSION['userType'] == "individual") {
        $user_id = $_SESSION['user_id'];
        $stmt = $pdo->prepare("CALL getUserVote(?, ?)");
        $stmt->bindParam(1, $user_id, PDO::PARAM_STR);
        $stmt->bindParam(2, $billId, PDO::PARAM_STR);
        $rs = $stmt->execute();
    }
    if ($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
        $vote = $result[0]['vote'];
    } else {
        // no vote yet    
        
    }
} else {
    // logged out
}
    ?>
    <form class="voteUser hasRadio" action='inc/postVote.php' method="POST" id="postVote<?php echo $billId; ?>">
            <?php 
            if($logged == 'in'){
                if(isset($vote)) {
                    if ($vote == 'pass') { ?>
                        <input type="radio" class="votePass" name="voteUser" id="pass<?php echo $billId; ?>" value="pass" checked />
                    <?php } elseif ($vote == 'reject') {
                    } 
                } else { ?>
                    <input type="radio" class="votePass" name="voteUser" id="pass<?php echo $billId; ?>" value="pass" onChange="userVote(document.getElementById('postVote<?php echo $billId; ?>'));" />
                <?php } 
                } else { ?>
                    <input type="radio" class="votePass" name="voteUser" id="pass<?php echo $billId; ?>" value="pass" onChange="a()" /> <?php } ?>
        <label for="pass<?php echo $billId; ?>">PASS<span></span></label>
        <?php 
            if($logged == 'in'){
                if(isset($vote)) {
                    if ($vote == 'reject') { ?>
                        <input type="radio" class="voteReject" name="voteUser" id="reject<?php echo $billId; ?>" value="reject" checked /><?php
                    } elseif ($vote == 'pass') {
                    } 
                } else { ?>
                    <input type="radio" class="voteReject" name="voteUser" id="reject<?php echo $billId; ?>" value="reject" onChange="userVote(document.getElementById('postVote<?php echo $billId; ?>'));" />
                    <input type="hidden" name="billId" value="<?php echo $billId; ?>" />
                    <?php 
                    if(isset($user_id)) { ?>
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
                    <?php } elseif (isset($organization_id)) { ?>
                    <input type="hidden" name="organization_id" value="<?php echo $organization_id; ?>" />
                    <?php }
                } 
            } else { ?>
                <input type="radio" class="voteReject" name="voteUser" id="reject<?php echo $billId; ?>" value="reject" onChange="a()" /> <?php } ?>
        <label for="reject<?php echo $billId; ?>">REJECT<span></span></label>
    </form>