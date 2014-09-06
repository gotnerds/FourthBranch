<?php include("header.php"); ?>
<div class="bodyWrap">
	<h1>Draft Your Proposal</h1>
	<form class="hasRadio" action="" method="POST" id="proposalDraft1" name="proposalDraft1">
		<h4>Does your proposal concern the Federal Government or your state?</h4>
		<input type="radio" class="votePass" name="proposalConcern" value="proposalFederal" id="proposalFederal" />
		<label for="proposalFederal">Federal Government<span></span></label>
		<input type="radio" class="votePass" name="proposalConcern" value="proposalState" id="proposalState" onchange="stateReveal();" />
		<label class="stateLabel" for="proposalState">State Government<span></span></label>
		<label for="proposalName">Name of Bill</label>
		<input type="text" name="proposalName">
		<h4>Category (pick three that are relevant)</h4>
		
	</form>
</div>
<?php include("footer.php") ?>