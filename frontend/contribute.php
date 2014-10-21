<?php 
error_reporting(~0);
ini_set('display_errors', 1);
include_once('header.php');
print_r($_SESSION);
?>
<section class="fullWidth contributePage">
	<article class="bodyWrap">
		<h1 class="seal">Contribute</h1>
		<div class="group section clearfix">
			<div class="col span_1_of_3 first-child">
			<!-- Shopping Cart -->
				<p class="user full"><b>Voter: </b><?php echo $username; ?></p>
				<hr>
				<div class="shopping-cart">
					<h5 class="user">Your Cart:</h5>
					<?php
					$currentUrl = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
					if(!empty($_SESSION["products"])) {
						//print_r($_SESSION["products"]);
					    $total = 0;
					    $currency = "$";
					    echo '<ol>';
					    foreach ($_SESSION["products"] as $cartItm)
					    {
					        echo '<li class="cart-itm">';
					        echo '<h4>'.$cartItm["name"].'</h4>';
					        echo '<div class="p-price">Price :'.$currency.$cartItm["price"].'</div>';
					        echo '<form action="./inc/cartUpdate.php?removep='.$cartItm["code"].'&returnUrl='.$currentUrl.'" method="POST"> <button class="blueButton remove-itm">remove</button></form>';
					        echo '</li>';
					        $subtotal = ($cartItm["price"]*$cartItm["qty"]);
					        $total = ($total + $subtotal);
					    }
					    echo '</ol>';
					    echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong></span>';
					    echo '<form method="POST" action="./inc/paypalProcess.php">';
					    foreach ($_SESSION["products"] as $key =>$cartItm) {
				    		echo '<input type="hidden" name="item_name['.$key.']" value="'.$cartItm["name"].'">';
				    		echo '<input type="hidden" name="item_code['.$key.']" value="'.$cartItm["code"].'">';
				    		echo '<input type="hidden" name="item_price['.$key.']" value="'.$cartItm["price"].'">';
				    		echo '<input type="hidden" name="item_qty['.$key.']" value="1">';
				    	}
					    	echo '<button type="submit" class="blueButton" value="Pay Now">Contribute Now!</button></form>';
					    echo '<span class="empty-cart"><a href="./inc/cartUpdate.php?emptycart=1&returnUrl='.$currentUrl.'">Empty Cart</a></span>';
						
					}else{
						echo 'Your Cart is empty';
					}
					?>
				</div>
			</div>
			<div class="col span_2_of_3">
			<!-- Store Items -->
				<div class="products">
				<?php
				//current URL of the Page. cart_update.php redirects back to this URL
				    ?>
				    <div class="product">
				    	<form method="post" action="" id="product1">
					    	<div class="productContent"><h4>Support the cause!</h4>
						    	<div class="productDesc">This is the description for the above product</div>
						    	<div class="productInfo">$5
						    		<?php
						    		$thisProduct=0;
						    		if (!empty($_SESSION["products"])) {
						    			foreach ($_SESSION["products"] as $cartItm) {
						    				if ($cartItm['code'] == '1') {
						    					$thisProduct = 1;
						    				}
						    			}
						    		}
						    		?>
						    		<button class="add_to_cart blueButton" onclick="
						    		<?php
						    			if ($logged == 'in') {
							    				if ($thisProduct == '1') {
							    					echo "return false;";
							    				} else {
						    					echo "userCart(document.getElementById('product1'));";
						    				} 
						    			} else {
						    				echo 'a(); return false; ';
						    			}
						    		?>"><?php 
					    				if ($thisProduct == '1') { 
					    					echo "Added"; 
					    				} else { 
					    					echo "Add to Cart"; 
					    				}
					    				?></button>
						    	</div>
						    </div>
						    <input type="hidden" name="productName" value="SupportTheCause" />
						    <input type="hidden" name="productCode" value="1" />
						    <input type="hidden" name="type" value="add" />
						    <input type="hidden" name="price" value="5" />
						    <input type="hidden" name="returnUrl" value="<?php echo $currentUrl; ?>" />
					    </form>
					</div>
				</div>
			</div>
		</div>
	</article>
</section>
<?php 
include_once('footer.php');
?>