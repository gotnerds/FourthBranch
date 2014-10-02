<?php include("header.php"); 
include("./inc/getTomorrowsBill.php");
?>
<section class="fullWidth">
    <article class="tomorrowsBill bodyWrap">
        <h1 class="seal">Tomorrow's Bill</h1>
        <div class="section group">
        <?php 
    	if (isset($_POST['submitTomorrowsBillSummary'])) { ?>
        	<h4>Thank you for submitting your summary.</h4>
        <?php	} else {
        ?>
            <div class="tomorrowsBillBox full">
                <div class="tomorrowsBillTitle">
                    <a href="bill.php?code=<?php echo $tomorrowsBill["code"]; ?>"> <h4><?php echo strtoupper($tomorrowsBill['code']) ?>:</br>
                    <?php echo $tomorrowsBill['title'] ?></h4></a>
                </div>
                <p><?php echo $tomorrowsBillJsonSnippit; ?></p>
            </div>
            <div class="tomorrowsBillParticipate">
                <div class="tomorrowsBillParticipateTitle">
	                <h4 style="text-align:center">Enter your own summary: </h4>
					<form class="proposal3" action="" method="post">
						<TEXTAREA class="proposal1" required name="tomorrowsBillSummary" maxlength="1000" id="tomorrowsBillSummary" ROWS=8 placeholder="Click on the bill code to view Tomorrow's Bill of The Day. After reviewing the bill, create your own summary in this space and when you are done, submit it."></TEXTAREA>
						<div class="centered">
							<button class="blueButton" name="submitTomorrowsBillSummary" type="submit">Submit</button>
						</div>
					</form>    
	            </div>
	        </div>
	        <?php } ?>
        </div>
    </article>
</section>
<?php include("footer.php"); ?>