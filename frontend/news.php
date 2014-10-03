<?php include("header.php"); ?>
<div class="bodyWrap newsPage">
<h1 class="seal">The News Unfiltered</h1>
<section class="group section">
	<?php
		$sql = 'SELECT * FROM news WHERE category = "2014 elections"';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		if ( $stmt->rowCount() >= 1) {
			$newsItems = $stmt->rowCount();
			while ($row = $stmt->fetchAll()){
				echo '<div class="col span_1_of_4 first-child">';
				echo '<h4>'.$row[0]['category'].'</h4>';
				echo '<div class="newsItem" headline="'.$row[0]['title'].'" headliners="'.$row[0]['title'].'/'.$row[1]['title'].'">
						<a class="linkerrr" href="'.$row[0][news_url].'" target="_blank" data-alturl="'.$row[0][news_url].','.$row[1][news_url].'">
							<img class="newsImage" src="'.$row[0]['photo'].'" data-altsrc="'.$row[0]['photo'].','.$row[1]['photo'].'" align="center">
						</a>';
				echo '</div></div>';	 
			}
		}
		$categories = array("Economics","Politics","World","News As Usual","Congress","The President","World Leaders");
		$categoryImage = array("images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg");
		$count = 2;
		foreach ($categories as $value) {
			if($count%4 == 1){
				echo '<div class="col span_1_of_4 first-child">';
			} else {
				echo '<div class="col span_1_of_4">';
			}
			echo '<h4>'.$value.'</h4>';
			echo '<div class="newsItem" style="background-image:url(\'images/notd1.jpg\')">';
			echo '</div></div>';
			$count++;
		}
	?>
</section>
</div>
<?php include("footer.php"); ?>