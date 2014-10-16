<?php include("header.php"); 
$userID = htmlspecialchars($_GET["id"]);
?>
<section class="fullWidth">
    <article class="bodyWrap">
    	<div class="group section clearfix">
    		<div class="col span_1_of_4 first-child">
    			<form action="" method="POST">
    				<label for="imgInp">
			           		<img id="blah" style="padding-left: 20px;" src="http://thefourthbranch.co/TheFourthBranch/fourth/image/avitar.png" alt="your image" width="103" height="125" style='width: 103px; height: 125px; float:left;' />
                      	</label>
		  	 	   		</br>
		  	 	   		<input type='file' id="imgInp" name='pic' size='5' accept='image/*' style="display:none;float:left;" />
                  	</div>
				  	<script type="text/javascript" >
						function readURL(input) {
							if (input.files && input.files[0]) {
							var reader = new FileReader();            
							reader.onload = function (e) {
								$('#blah').attr('src', e.target.result);
							}            
							reader.readAsDataURL(input.files[0]);
							}
						}    
						$("#imgInp").change(function(){
							readURL(this);
						});	
					</script>
    			</form>
    		</div>
    		<div class="col span_3_of_4">
    		</div>
        </div>
    </article>
</section>
<?php include("footer.php"); ?>