<?php include("header.php"); ?>
<div class="bodyWrap">
	<h1>Draft Your Proposal</h1>
	<?php
		if (isset($_POST['proposal-submit'])){
		include ('inc/getSimilarProposals.php');
	?>
	<?php
		} else {
	?>
	<form class="proposal1 hasRadio" action="" method="POST" id="proposalDraft1" name="proposalDraft1"> 
			<label for="proposalName" class="largeText">Name of Bill:</label>
			<span>
				<input type="text" name="proposalName" maxlength="150">
			</span>
		<div class="medText">Does your proposal concern the Federal Government or your state?</div>
		<span>
		<input type="radio" class="votePass" name="proposalConcern" value="proposalFederal" id="proposalFederal" />
		<label for="proposalFederal" class="noFloat indent">Federal Government<span></span></label>
		<input type="radio" class="votePass" name="proposalConcern" value="proposalState" id="proposalState" onchange="stateReveal();" />
		<label class="stateLabel" class="noFloat" for="proposalState">State Government<span></span></label>
		</span>
		<legend class="medText">Category (pick three that are relevant):</legend>
		<fieldset class="indent section group">
			<?php 
				$categories=array(										
					"Agriculture and Food",
					"Animals",
					"Armed Forces and National Security",
					"Arts, Culture, Religion",
					"Civil Rights and Liberties, Minority Issues",
					"Commerce",
					"Congress",
					"Crime and Law Enforcement",
					"Economics and Public Finance",
					"Education",
					"Emergency Management");
				$categories2=array(
					"Energy",
					"Environmental Protection",
					"Families",
					"Finance and Financial Sector",
					"Foreign Trade and International Finance",
					"Government Operations and Politics",
					"Health",
					"Housing and Community Development",
					"Immigration",
					"International Affairs",
					"Labor and Employment");
				$categories3=array(
					"Law",
					"Native Americans",
					"Private Legislation",
					"Public Lands and Natural Resources",
					"Science, Technology, Communications",
					"Social Sciences and History",
					"Social Welfare",
					"Sports and Recreation",
					"Taxation",
					"Transportation and Public Works",
					"Water Resources Development"
					); 
				  echo '<div class="col2 span_1_of_3 first-child">';
					foreach ($categories as $value) {
					  echo '<input type="checkbox" name="category" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
					} 
					echo '</div>';
					echo '<div class="col2 span_1_of_3">';
					foreach ($categories2 as $value) {
					  echo '<input type="checkbox" name="category" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
					} 
					echo '</div>';
					echo '<div class="col2 span_1_of_3">';
					foreach ($categories3 as $value) {
					  echo '<input type="checkbox" name="category" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
					} 
					echo '</div>';
			?>
		</fieldset>
		<hr style="width:100%;margin-bottom:10px;margin-top:20px;">
		<span style="padding-left:0;">Step 1 of 3</span>
		<button class="blueButton" name="proposal-submit" type="submit">Next</button>
	</form>
	<?php } ?>
</div>
<?php include("footer.php") ?>