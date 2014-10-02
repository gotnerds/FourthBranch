<?php include("header.php"); 
?>
<section class="fullWidth">
    <article class="bodyWrap">
	    <h1 class="seal">Wall of America</h1>
        <div style="text-align:center;">
	        <h4 style="margin-bottom:0;">Contribute now to get on the Wall of Dreams and Wishes.</h4>
	        <br>
	        <button class="blueButton">Get on the Wall Today!</button>
	    </div>
	    <div id="dreamAndWish">
			<?php
			if($logged == 'in') {
					$user_id = $_SESSION['user_id'];
					$sql = 'SELECT * FROM wall_of_america WHERE user = ?';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
					$stmt->execute();
					if ( $stmt->rowCount() >= 1) {
						while ($row = $stmt->fetch()){
							echo '
							<div style="float:left;display:inline-block;">
								<h5>Your Dream And Wish</h5>
							</div>
							<div style="float:right;display:inline-block;">
								<h5>edit</h5>
							</div>
							<div class="group section clearfix">
								<div class="col span_2_of_5 first-child">
									<p class="dream">'.$row['dream'].'</p>
								</div>
								<div class="col span_1_of_5">
									<div style="max-width:100%;height:60px;border:1px black solid;text-align:center;">PICTURE</div>
								</div>
								<div class="col span_2_of_5">
									<p style="text-align:right;">'.$row['wish'].'</p>
								</div>
							</div>
							<hr style="width:100%;">';
						}
					}
					//logged in but no vote
				}
			$limit = 5;
			# Get the page number from GET, or set it to 0.
			$index = isset ( $_GET['page'] ) && $_GET['page'] ? (int) $_GET['page'] : 0;
			$page = $index * $limit;
			# Get the total number of posts. We need this to know when we've reached the last # page. 
			# You probably want to do some error handling here, if mysql queries fail. 
			#$statement = $mysqli->prepare ("SELECT COUNT(*) FROM bills");
			$sql = 'SELECT * FROM wall_of_america ORDER BY id DESC LIMIT ?, ?';
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
				echo '
				<div class="singleDream">
					<div style="float:left;display:inline-block;">
						<h5>Dream And Wish #'.$row['id'].'</h5>
					</div>
				<div class="group section clearfix">
					<div class="col span_2_of_5 first-child">
						<p class="dream">'.$row['dream'].'</p>
					</div>
					<div class="col span_1_of_5">
						<div style="max-width:100%;height:60px;border:1px solid black;text-align:center;">PICTURE</div>
					</div>
					<div class="col span_2_of_5">
						<p style="text-align:right;">'.$row['wish'].'</p>
					</div>
				</div>
				<hr style="width:100%;">
				</div>';
			}
			?>
	    </div>
    </article>
</section>
<?php include("footer.php"); ?>