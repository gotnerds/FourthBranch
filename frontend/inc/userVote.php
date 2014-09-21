<?php 
if(logged == in) {
    $userId = $_SESSION['user_id']
    $userVote = checkUserVote($userId, $billId);
    echo $userVote;
    ?>
    <script>
        $(function() {
            var $radios = $('input:radio[name=voteUser]');
            if($radios.is(':checked') === false) {
                $radios.filter('[value=<?php echo $_SESSION['voteUser']; ?>]').prop('checked', true);
            }
        });
    </script>
    <?php } ?>
    <form class="voteUser hasRadio" action="" method="POST">
        <input type="radio" class="votePass" name="voteUser" id="pass" value="pass" onChange="<?php
            if(isset($_SESSION)){
                if(isset($_SESSION['voteUser'])) {
                    ?>"preventDefault()"<?php
                } else {
                ?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
        <label for="pass">PASS<span></span></label>
        <input type="radio" name="voteUser" class="voteReject" id="reject" value="reject" onChange=<?php 
        if(isset($_SESSION)){
            if(isset($_SESSION['voteUser'])) {
                ?>"preventDefault()"<?php
            } else {
            ?>"this.form.submit()"<?php } } else { ?>"a()"<?php } ?> />
        <label for="reject">REJECT<span></span></label>
    </form>