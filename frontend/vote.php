<?php include("header.php");
include("inc/getBills.php");
?>
<div class="bodyWrap">
	<section class="votePage">
		<h1 class="seal">Vote</h1>
		<article class="voteSearch">
			<div class="searchBox">
				<h3>Search for Bills</h3>
				<form method="POST" action="" name="billSearch" id="billSearch">
				<div class="searchKeywords">
					<input type="search" name="term" size="40" placeholder=
					<?php if (!empty($_REQUEST['term'])) {
						?>"<?php echo $term; ?>" <?php
					 } else { ?>
					"Enter Keywords..."<?php } ?> autofocus>
					<button class="button" type="submit" name="search-button">Search</button>
					</div><div class="searchSortBy">
						<h4>Sort By</h4>
						<label for="mostAgreed" class="sortBy button">Most Agreed</label>
						<input type="radio" class="button" name="sortBy" id="mostAgreed" value="mostAgreed">
						<label for="mostDisagreed" class="sortBy button">Most Disagreed</label>
						<input type="radio" class="button" name="sortBy" id="mostDisagreed" value="mostDisagreed">
						<label for="popularity" class="sortBy button">Popularity</label>
						<input type="radio" class="button" name="sortBy" id="popularity" value="popularity">
						<label for="mostAgreed" class="sortBy button">Most Agreed</label>
						<input type="radio" class="button" name="sortBy" id="mostAgreed" value="mostAgreed">

					</div>
				</form>
			</div>
		</article>
		<div id="results">
		<?php include("inc/postBills.php") ?>
    </section>
</div>
<?php include("footer.php"); ?>