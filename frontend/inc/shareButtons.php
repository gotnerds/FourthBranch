<?php 
    $billId = $row['id'];    
	$code = $row['code'];
	$shareTitle = $row['title'];
    ?>
        <div class="share-buttons">
        	<form action='' method="POST" id="shareButtons<?php echo $billId; ?>">
    	        <button type="button" name="type" value="reddit" class="reddit shareButton" onClick="document.getElementById('type<?php echo $billId; ?>').value = this.value; userShare(document.getElementById('shareButtons<?php echo $billId; ?>'));">Reddit</button>
    	        <button type="button" name="type" value="google" class="google shareButton" onClick="document.getElementById('type<?php echo $billId; ?>').value = this.value; userShare(document.getElementById('shareButtons<?php echo $billId; ?>'));">Google</button>
            	<button type="button" name="type" value="facebook" class="facebook shareButton" onClick="document.getElementById('type<?php echo $billId; ?>').value = this.value; userShare(document.getElementById('shareButtons<?php echo $billId; ?>'));">Facebook</button>
    	        <button type="button" name="type" value="linkedin" class="linkedin shareButton" onClick="document.getElementById('type<?php echo $billId; ?>').value = this.value; userShare(document.getElementById('shareButtons<?php echo $billId; ?>'));">LinkedIn</button>
            	<button type="button" name="type" value="twitter" class="twitter shareButton" onClick="document.getElementById('type<?php echo $billId; ?>').value = this.value; userShare(document.getElementById('shareButtons<?php echo $billId; ?>'));">Twitter</button>
            	<input type="hidden" name="type" value="this" id="type<?php echo $billId; ?>">
            	<input type="hidden" name="id" value="<?php echo $billId; ?>">
            	<input type="hidden" name="code" value="<?php echo $code; ?>">
            	<input type="hidden" name="title" value="<?php echo $shareTitle; ?>">
            	
            </form>
            <a href="<?php echo $shareURL; ?>#addComment">
    	        <button class="comment shareButton">Comment</button>
    	    </a>
        </div>