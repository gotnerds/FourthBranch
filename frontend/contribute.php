<?php 
include_once('header.php');
//print_r($_SESSION);
?>
<section class="fullWidth contributePage">
	<article class="bodyWrap">
		<h1 class="seal">Contribute</h1>
		<div class="group section clearfix">
			<div class="col span_1_of_3 first-child">
			<!-- Shopping Cart -->
				<p class="user full"><b>Voter: </b><?php echo $_SESSION['username']; ?></p>
				<hr>
				<div class="shopping-cart">
					<h5 class="user">Your Cart:</h5>
					<?php
					if(isset($_SESSION["products"])) {
						//print_r($_SESSION["products"]);
					    $total = 0;
					    echo '<ol>';
					    foreach ($_SESSION["products"] as $cartItm)
					    {
					        echo '<li class="cart-itm">';
					        echo '<span class="remove-itm"><a href="./inc/cartUpdate.php?removep='.$cartItm["code"].'&returnUrl='.$currentUrl.'">&times;</a></span>';
					        echo '<h3>'.$cartItm["name"].'</h3>';
					        echo '<div class="p-code">P code : '.$cartItm["code"].'</div>';
					        echo '<div class="p-qty">Qty : '.$cartItm["qty"].'</div>';
					        echo '<div class="p-price">Price :'.$currency.$cartItm["price"].'</div>';
					        echo '</li>';
					        $subtotal = ($cartItm["price"]*$cartItm["qty"]);
					        $total = ($total + $subtotal);
					    }
					    echo '</ol>';
					    echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong> <a href="viewCart.php">Check-out!</a></span>';
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
				$currentUrl = base64_encode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				    ?>
				    <div class="product">
				    	<form method="post" action="" id="product1">
					    	<div class="productContent"><h4>Support the cause!</h4>
						    	<div class="productDesc">This is the description for the above product</div>
						    	<div class="productInfo">$5
						    		<button class="add_to_cart blueButton" onclick="
						    		<?php
						    			if ($logged == 'in') {
						    		echo "userCart(document.getElementById('product1'));";
						    			} else {
						    				echo 'a(); return false; ';
						    			}
						    		?>">Add To Cart</button>
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