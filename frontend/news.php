<?php include("header.php"); ?>
<div class="bodyWrap">
<h1>The News Unfiltered</h1>
<section class="newsPage group section">
	<?php
		$categories = array("Business","Economics","Politics","World","News As Usual","Congress","The President","World Leaders");
		$categoryImage = array("images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg", "images/notd1.jpg");
		$count = 1;
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