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
		if (isset($_POST['proposal-submit3'])) {
			$proposalCategory = unserialize($_POST['proposalCategory']);
			$proposalName = $_POST['proposalName'];
			$proposalConcern = $_POST['proposalConcern'];
			$proposalDescription = $_POST['proposalDescription'];
			$currentDate = date("Y-m-d");
			$individual_id = 5;
			$verified = 0;

#SET @p0='1'; SET @p1='The bill to start them all'; SET @p2='federal'; SET @p3='arts'; SET @p4='science'; SET @p5='business'; SET @p6='2014-09-09'; SET @p7='0'; SET @p8='the bill will begin soon'; CALL `insertProposal`(@p0, @p1, @p2, @p3, @p4, @p5, @p6, @p7, @p8);

			$stmt = $pdo->prepare('CALL insertProposal(:individual_id, :name, :concern, :category1, :category2, :category3, :created, :verified, :description)');
			    $stmt->bindValue(':individual_id', $individual_id, PDO::PARAM_INT);
			    $stmt->bindParam(':name', $proposalName, PDO::PARAM_STR);
			    $stmt->bindParam(':concern', $proposalConcern, PDO::PARAM_STR);	
			    $stmt->bindParam(':category1', $proposalCategory[0], PDO::PARAM_STR);
			    $stmt->bindParam(':category2', $proposalCategory[1], PDO::PARAM_STR);
			    $stmt->bindParam(':category3', $proposalCategory[2], PDO::PARAM_STR);
			    $stmt->bindParam(':created', $currentDate, PDO::PARAM_STR);
			    $stmt->bindValue(':verified', 0, PDO::PARAM_STR);
			    $stmt->bindParam(':description', $proposalDescription, PDO::PARAM_STR);
			#$stmt->execute();
			if ($stmt->execute() ) {
			echo '<h4>Thank you for adding your Proposal. We will post it within 24 hours.</h4>';
			} else {
				echo '<h4>Something went wrong. The developers have been notified.</h4>';
			}
		} elseif (isset($_POST['proposal-submit2'])){
			$proposalCategory = $_POST['proposalCategories'];
			$proposalName = $_POST['proposalName'];
			$proposalConcern = $_POST['proposalConcern'];
			echo '
				<h4 >Enter the description for: '.$proposalName.'</h4>
				<form class="proposal3" action="" method="post">
					<TEXTAREA class="proposal1" required name="proposalDescription" maxlength="1000" id="proposalDescription" ROWS=8></textarea>
					<input type="hidden" name="proposalCategory" value=\''.$proposalCategory.'\'>
					<input type="hidden" name="proposalName" value="'.$proposalName.'">
					<input type="hidden" name="proposalConcern" value="'.$proposalConcern.'"> 
					<hr style="width:100%;margin-bottom:10px;margin-top:20px;">
					<div class="step3">
						<span style="padding-left:0;margin-bottom:30px;">Step 3 of 3</span>
						<button class="blueButton" name="proposal-submit3" type="submit">Propose</button>
					</div>
					</form>
				';

		} elseif (isset($_POST['proposal-submit'])){
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
				<a href="bill.php?code='.$row["code"].'"><button class="blueButton">Read More</button></a>
			</article>';
				$count++;
		}
		echo '</section>';
	?>	<h4>If you do not see your proposal above, please click 'Next'</h4>
		<div style="position:relative;margin-bottom:30px;">
			<hr style="width:100%;margin-bottom:10px;margin-top:20px;">
			<span style="padding-left:0;">Step 2 of 3</span>
			<form action="" method="post">
				<?php $data=serialize($_POST['category']); 
 				$encoded=htmlentities($data);?>
				<input type="hidden" value="<?php echo ($terms); ?>" name="proposalName">
				<input type="hidden" value="<?php echo ($_POST['proposalConcern']); ?>" name="proposalConcern">
				<input type="hidden" value="<?php echo $encoded; ?>" name="proposalCategories">
				<button class="blueButton right" name="proposal-submit2" type="submit">Next</button>
			</form>
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