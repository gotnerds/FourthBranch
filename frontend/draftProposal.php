<?php include("header.php"); ?>
<div class="bodyWrap">
	<h1>Draft Your Proposal</h1>
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
		$limit = 9;
		# Get the page number from GET, or set it to 0.
		$index = isset ( $_GET['page'] ) && $_GET['page'] ? (int) $_GET['page'] : 0;
		$page = $index * $limit;
		if (isset($_POST['proposal-submit'])){
		include ('./inc/searchBills.php');
		$terms = $_POST['proposalName'];
		$sql = search_perform($terms);
		$stm = $pdo->prepare($sql);
		$stm->bindParam(1, $page, PDO::PARAM_INT);
		$stm->bindParam(2, $limit, PDO::PARAM_INT);
		$stm->execute();
		$count = 1;
			echo '<h4>There is power in numbers! Review the following proposals to ensure that your own proposal is unique and does not divide the effort</h4>';
			echo '<section class="proposalList section group">';

		while ( $row = $stm->fetch() ) {
			if($count%3 == 1) {
				echo '<article class="proposalListItem clearfix col2 span_1_of_3 first-child">';
			} else {
				echo '<article class="proposalListItem clearfix col2 span_1_of_3">';
			}
			echo '<div class="proposalListTitle"><p>';
				if (strlen($row["title"]) >= 160)
					{ 
						$pos = strpos($row["title"], ' ', 140);
						$titleSnippit = substr($row["title"], 0, $pos);
						echo $titleSnippit."..."; }
					else { echo $row["title"]; }
						echo '</p>
				</div>
				<div class="proposalListDetails">
					<div>1:30pm 9.14.2014</div>
					<div>30 Agree</div>
					<div>10 Disaree</div>
				</div>
				<button class="blueButton">Read More</button>
			</article>';
				$count++;
		}
		echo '</section>';
	?>	<h4>If you do not see your proposal above, please click 'Next'</h4>
		<div style="position:relative;margin-bottom:30px;">
			<hr style="width:100%;margin-bottom:10px;margin-top:20px;">
			<span style="padding-left:0;">Step 2 of 3</span>
			<button class="blueButton right" name="proposal-submit2" type="submit">Next</button>
		</div>
	<?php
		} else {
	?>
	<form class="proposal1 hasRadio" action="" method="POST" id="proposalDraft1" name="proposalDraft1"> 
			<label for="proposalName" class="largeText">Name of Bill:</label>
			<span>
				<input type="text" name="proposalName" maxlength="150" required>
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
				  echo '<div class="col2 span_1_of_3 first-child">';
					foreach ($categories as $value) {
					  echo '<input type="checkbox" name="category[]" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
					} 
					echo '</div>';
					echo '<div class="col2 span_1_of_3">';
					foreach ($categories2 as $value) {
					  echo '<input type="checkbox" name="category[]" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
					} 
					echo '</div>';
					echo '<div class="col2 span_1_of_3">';
					foreach ($categories3 as $value) {
					  echo '<input type="checkbox" name="category[]" id="'.$value.'" value="'.$value.'"><label for="'.$value.'" class="clearfix">'.$value.'</label>';
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