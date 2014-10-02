<?php include("header.php"); ?>
<div class="bodyWrap proposalPage">
	<h1 class="seal">Draft Your Proposal Today</h1>
	<section class="introduction section group">
		<div class="introductionDesc col span_1_of_2 first-child">
			<p>When you make a proposal you enrich your community. Your voice matters. It's time to share what you have to say.</p>
			<ol>
				<li>Reasons to draft</li>
				<li>and another</li>
				<li> and another</li>
			</ol>
			<button class="blueButton" onclick="location.href='draftProposal.php'">Draft Now</button>
		</div>
		<div class="introductionVideo col span_1_of_2">
			<video width="100%" height="auto" controls="controls">
				<source src="video/video.mp4" type="video/mp4">
				<source src="video/video.ogv" type="video/ogv">
				<source src="video/video.webm" type="video/webm">
				video is not supoorted.
			</video>
		</div>
	</section>
	<hr>
	<section class="proposalList section group">
		<div class="proposalListOrder clearfix">
			<div class="proposalListLocation textLeft col span_1_of_3 first-child">
				<button class="blueButton">Federal</button>
				<button class="blueButton">State</button>
			</div>
			<div class="proposalListLocation textRight col span_2_of_3">
				<button class="blueButton">Time</button>
				<button class="blueButton">Most Agrees</button>
				<button class="blueButton">Most Discussed</button>
			</div>
		</div>
		<?php 
			$limit = 9;
			$firstChild = 1;
			# Get the page number from GET, or set it to 0.
			$index = isset ( $_GET['page'] ) && $_GET['page'] ? (int) $_GET['page'] : 0;
			$page = $index * $limit;
			$sql = 'SELECT * FROM proposals ORDER BY id DESC LIMIT ?, ?';
			$sqlOrder = str_replace("*", "COUNT(*)", $sql);
			$remove=strrchr($sqlOrder,'ORDER');
			//remove is now "- Name: bmackeyodonnell"
			$sqlOrder=str_replace(" $remove","",$sqlOrder);
			$statement = $pdo->prepare ($sqlOrder);
			$statement->execute();
			$count = $statement->fetchColumn();
			#The result is now in the $count variable.
			$stm = $pdo->prepare($sql);
			$stm->bindParam(1, $page, PDO::PARAM_INT);
			$stm->bindParam(2, $limit, PDO::PARAM_INT);
			$stm->execute();
			while ( $row = $stm->fetch() ) {
				if($firstChild %3 == 1) { ?>
					<article class="proposalListItem clearfix col2 span_1_of_3 first-child">
				<?php } else { ?>
					<article class="proposalListItem clearfix col2 span_1_of_3">
				<?php } ?>
			<div class="proposalListTitle">
				<a href="proposalPage.php?code=<?php echo $row['id']; ?>"><h5><?php echo $row['name']; ?></h5></a>
			</div>
			<div class="proposalListDetails">
				<div><?php echo $row['created']; ?></div>
				<div>30 Agree</div>
				<div>10 Disaree</div>
			</div>
			<button class="blueButton" onclick="window.location.href='proposalPage.php?code=<?php echo $row['id']; ?>'">Read More</button>
		</article>
		<?php $firstChild++; } ?>
		<div class="proposalListMore">
			<button class="blueButton">View More Proposals</button>
		</div>
	</section>
</div>
<?php include("footer.php"); ?>