<?php include("header.php"); 
?>
<section class="fullWidth">
    <article class="bodyWrap">
        <h1 class="seal">Contact</h1>
        <div class="contact-area group section">
	        <div class="col span_1_of_2 first-child">
	        <?php if (isset($_POST['Message'])) {
				$EmailTo = "ilan.gitter@gmail.com";
				$Subject = "Message from The Fourth Branch Contact Form";
				$Name = Trim(stripslashes($_POST['Name'])); 
				$Email = Trim(stripslashes($_POST['Email'])); 
				$Message = Trim(stripslashes($_POST['Message'])); 

				// validation
				$validationOK=true;
				if (!$validationOK) {
				  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
				  exit;
				}

				// prepare email body text
				$Body = "";
				$Body .= "Name: ";
				$Body .= $Name;
				$Body .= "\n";
				$Body .= "Email: ";
				$Body .= $Email;
				$Body .= "\n";
				$Body .= "Message: ";
				$Body .= $Message;
				$Body .= "\n";

				// send email 
				$success = mail($EmailTo, $Subject, $Body, "From: <$Email>");

				// redirect to success page 
				if ($success){
	        		echo "<h4>Thank you for your message.</h4>";
				}
				else{
				  echo "<p>There was a problem with the form. The administrator has been notified.</p>";
				}
        	} else {
			echo '<form method="post" action="">
					<label for="Name">Name:</label>
					<input type="text" name="Name" id="Name" style="width:100%;" required />
					<label for="Email">Email:</label>
					<input type="text" name="Email" id="Email" style="width:100%;" required />
					<label for="Message">Message:</label><br />
					<textarea name="Message" rows="10" cols="20" id="Message" style="width:100%;" required ></textarea>
				<button type="submit" name="submit" class="blueButton" />Submit</button>
			</form>';
			} ?>
			</div>
			<div class="col span_1_of_2">
				<p>The Fourth Branch welcomes all comments and questions. Our headquarters are in Brooklyn NY.</p>
			</div>
		</div>
    </article>
</section>
<?php include("footer.php"); ?>
	