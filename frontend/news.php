<?php include("header.php"); ?>
<div class="bodyWrap newsPage">
<h1 class="seal">The News Unfiltered</h1>
<section class="group section">
	<?php
		$sql = 'SELECT   *, GROUP_CONCAT(category ORDER BY id ASC) grouped_cat FROM news GROUP BY id';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		if ( $stmt->rowCount() >= 1) {
			$newsItems = $stmt->rowCount();
			while ($row = $stmt->fetchAll()){
				$count = 1;
				$newList = sortList($row);
				foreach ($newList as $key => $value) {
					//category
					if($count%4 == 1){
						echo '<div class="col span_1_of_4 first-child">';
					} else {
						echo '<div class="col span_1_of_4">';
					}
					echo '<h4>'.$key.'</h4>';
					echo '<div class="newsItem" headline="'.$value[0]['title'].'" headliners="'.$value[0]['title'];
					foreach ($value as $k => $v) {
						if ($k == "0"){

						}else{
						echo '/'.$v['title'];
						}
					}
					echo '"><a class="linkerrr" href="'.$value[0]["news_url"].'" target="_blank" data-alturl="'.$value[0]["news_url"];
					foreach ($value as $k => $v) {
						if ($k == "0"){

						}else{
						echo ','.$v['news_url'];
						}
					}
					echo'"><img class="newsImage" src="'.$value[0]['photo'].'" data-altsrc="'.$value[0]['photo'];
					foreach ($value as $k => $v) {
						if ($k == "0"){

						}else{
						echo ','.$v['photo'];
						}
					}
					echo '" align="center">
							</a>';
					echo '</div>';
					$count++;
					echo '</div>';
				}
					 
			}
		} else {
			echo "<h4> Sorry there is no news today </h4>";
		}
	?>
</section>
</div>
<?php include("footer.php"); ?>