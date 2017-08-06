<?php 
session_start();

//Include database configuration file
include_once('dbConfig.php');

 if(!empty($_SESSION["full_amount"]) && isset($_SESSION['CART_ITEM']) && $_SESSION['CART_ITEM'] !=0 && isset($_SESSION['cartArray'])  && isset($_SESSION['quantity_purchased']))
 {
 
   // echo $GLOBALS['A'];
   // die;
 
		global $qDiscount;
		global $rDiscount;
		global $qcDiscount;

 	?>
 	<script>
	window.onload = function() {
		var d = new Date().getTime();
		document.getElementById("tid").value = d;
		
	};
</script>
<style>
.error{color: red;}
</style>

 	<?php

 	$stamp = strtotime("now");
	$orderid = 'QPO-'.$stamp; 
	$orderid = str_replace(".", "", $orderid); 
	


    
       $full_amount = $_SESSION["full_amount"];
       $quantity_purchased= $_SESSION["quantity_purchased"];

      $cartArray= $_SESSION['cartArray'];
      $total_item = count($cartArray);

          unset($_SESSION['ORDER-SUCCESS']);
          unset($_SESSION['ORDER-NO']);

      
         // echo '<pre>';

//print_r($cartArray);
      
       $state ='';
     // Finding City and State
     $query = $db->query("SELECT distinct `state` FROM `statelist` ORDER BY `state` ASC");
     While($row = $query->fetch_assoc()){

        $state .= '<option value="'.$row['state'].'">'.$row['state'].'</option>';

     }
 }
	
else{

	
		$url = "./index.php";
               echo ("<script>location.href='$url'</script>");
		exit();
}

?>

<?php include_once('header.php'); ?>
<link href="http://parsleyjs.org/src/parsley.css" rel="stylesheet">

<link href="http://parsleyjs.org/bower_components/bootstrap/dist/css/bootstrap.css
" rel="stylesheet">
<script src="http://parsleyjs.org/bower_components/jquery/dist/jquery.min.js"></script>
<script src="http://parsleyjs.org/dist/parsley.js"></script>

  <!-- #header end -->

		<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1>Checkout</h1>
				<ol class="breadcrumb">
					<li><a href="../">Home</a></li>
					<li><a href="./">Shop</a></li>
					<li class="active">Checkout</li>
				</ol>
			</div>

		</section><!-- #page-title end -->

		<!-- Content
		============================================= -->
		<section id="content" class="mainSection">

			<div class="content-wrap">

				<div class="container clearfix">

					<div class="col_half" style=" margin-bottom: 0px;margin-top: 10px;">
						
					<div class="panel backThis">
							 <div class="panel-body" style="border: none;">
							<a  title="User Login" href="login-register.php" style="color: #f79452;">Click here to login</a>
							</div>
						</div></div>
				<!--	<div class="col_half col_last">
						<?php /* ?>
						<div class="panel panel-default">
							<div class="panel-body">
								Have a coupon? <a href="login-register.html">Click here to enter your code</a>
							</div>
						</div>
						<?php */ ?>

					</div> -->

					<div class="row clearfix checkoutFomrs">
					     <form id="place_order-form"  name="place_order-form" class="nobottommargin" action="ccavRequestHandler.php" method="post" data-parsley-validate="">

						<div class="col-md-6 well"  style="width: 49%;margin-right: 2%;">
							<h3 class="heading_color">Billing Address</h3>

							


						


								<div class="col_half">
									<label for="first_name">First Name: <small class="error">*</small></label>
									<input type="text" id="first_name" name="billing_name" value="" class="sm-form-control" required="" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your First Name"/>
								</div>

								<div class="col_half col_last">
									<label for="last_name">Last Name: <small class="error">*</small></label>
									<input type="text" id="last_name" name="last_name" value="" class="sm-form-control" required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your Last Name" />
								</div>

								<div class="clear"></div>

								<div class="col_full">
									<label for="company_name">Company Name:</label>
									<input type="text" id="company_name" name="company_name" value="" class="sm-form-control" />
								</div>

								<div class="col_full">
									<label for="address">Address: <small class="error">*</small></label>
									<textarea style="height: auto;" rows="4" cols="30" id="address" name="billing_address" value="" class="sm-form-control" required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your Address"></textarea>
								</div>

								
								<div class="col_half clear-both">
									<label for="state">State: <small class="error">*</small></label>
									  <select  style="height: auto;" class="sm-form-control" id="state" name="billing_state" required="required">

                                                        <option value="">Select State</option>
                                                        <?php echo $state; ?>
                                         </select>
								</div>
								<div class="col_half col_last">
									<label for="city">City / Town: <small class="error">*</small></label>
									<input type="text" id="city" name="billing_city" value="" class="sm-form-control"  required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your City Name"/>
								</div>

								<div class="col_half clear-both">
									<label for="email">Email Address: <small class="error">*</small></label>
									<input type="email" id="email" name="billing_email" value="" class="sm-form-control" required="required" class=" sm-form-control form-control" type="email" data-parsley-type="email" autofocus data-parsley-error-message="Enter a Valid Email" />
								</div>
								<div class="col_half col_last">
									<label for="postal">Postal: <small class="error">*</small></label>
									<input type="number" id="postal_code" name="billing_zip" value="" class="sm-form-control" required="required" class=" sm-form-control form-control"  data-parsley-length="[6, 6]" autofocus data-parsley-error-message="Enter a Valid Postal Address" />
								</div>

								<div class="col_half clear-both">
									<label for="phone">Phone:</label>
									<input type="text" id="phone" name="phone" value="" class="sm-form-control" />
								</div>

								<div class="col_half col_last">
									<label for="mobile">Mobile: <small class="error">*</small></label>
									<input type="text" id="mobile" name="billing_tel" value="" class="sm-form-control" required="required" class=" sm-form-control form-control"  data-parsley-length="[10, 10]" autofocus data-parsley-error-message="Enter a Valid Phone Number"/>
								</div>


						</div>
						<div class="col-md-6 well col_last shipping" style="width: 49%;">
							<h3 class="heading_color">Shipping Address</h3>

                                                                <div class="col_full" style="margin-bottom: 0px;">
								  <input class="" type="checkbox" id="sameAddr" name="sameAddr" value="" style="margin-right: 10px;height: auto;
								    display: inline-flex;"><label for="same as Billing Address" class="heading_color">Same As Billing Address:</label>			 
								</div>
								<div class="col_half">
									<label for="sfirst_name">First Name: <small class="error">*</small></label>
									<input type="text" id="sfirst_name" name="delivery_name" value="" class="sm-form-control" required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your First Name" />
								</div>

								<div class="col_half col_last">
									<label for="slast_name">Last Name: <small class="error">*</small></label>
									<input type="text" id="slast_name" name="slast_name" value="" class="sm-form-control" required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your Last Name"/>
								</div>

								<div class="clear"></div>

								<div class="col_full">
									<label for="scompany_name">Company Name: </label>
									<input type="text" id="scompany_name" name="scompany|_name" value="" class="sm-form-control" />
								</div>

								<div class="col_full">
									<label for="saddress">Address: <small class="error">*</small></label>
									<textarea  style="height: auto;" rows="4" cols="30" id="saddress" name="delivery_address" value="" class="sm-form-control" required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your Address" ></textarea>
								</div>

								
								<div class="col_half clear-both">
									<label for="sstate">State: <small class="error">*</small></label>
									
									      <select  style="height: auto;" class="sm-form-control" id="sstate" name="delivery_state" required="required">

                                                        <option value="">Select State</option>
                                                        <?php echo $state; ?>
                                         </select>
								</div>
								<div class="col_half col_last">
									<label for="scity">City / Town: <small class="error">*</small></label>
									<input type="text" id="scity" name="delivery_city" value="" class="sm-form-control"  required="required" data-parsley-required="true" autofocus data-parsley-error-message="Enter Your City Name"/>
								</div>
								
								<div class="col_half clear-both">
									<label for="email">Email Address: <small class="error">*</small></label>
									<input type="email" id="semail" name="delivery_email" value="" class="sm-form-control" required="required" class=" sm-form-control form-control" type="email" data-parsley-type="email" autofocus data-parsley-error-message="Enter a Valid Email" />
								</div>

								<div class="col_half col_last">
									<label for="spostal">Postal: <small class="error">*</small></label>
									<input type="text" id="spostal_code" name="delivery_zip" value="" class="sm-form-control" required="required" class=" sm-form-control form-control"  data-parsley-length="[6, 6]" autofocus data-parsley-error-message="Enter a Valid Postal Address"/>
								</div>
								<div class="clearfix"></div>

								
								<div class="col_half clear-both">
									<label for="sphone">Phone:</label>
									<input type="text" id="sphone" name="sphone" value="" class="sm-form-control" />
								</div>

								<div class="col_half  col_last">
									<label for="smobile">Mobile: <small class="error">*</small></label>
									<input type="text"  required="required" id="smobile" name="delivery_tel" value="" class="sm-form-control" class=" sm-form-control form-control"  data-parsley-length="[10, 10]" autofocus data-parsley-error-message="Enter a Valid Phone Number"/>
								</div>

								<div class="col_full">
									<label for="shipping-form-message">Notes </label>
									<textarea style="height: auto;" class="sm-form-control" id="smessage" name="smessage" rows="2" cols="30"></textarea>
								</div>

							
						</div>
						<div class="clear bottommargin"></div>
						<div class="col-md-6">
							<div class="table-responsive clearfix order_details_data" id="order_details_data">
								<h4>Your Orders</h4>

								<table class="table cart">
									<thead>
										<tr>
											
											<th class="cart-product-name">Product</th>
											<th class="cart-product-name">Quality</th>
											<th class="cart-product-quantity">Quantity</th>
											
											<th class="cart-product-subtotal">Total</th>
										</tr>
									</thead>
									<tbody>
									<!-- Start Here  -->

										
										<!--   -->
								<?php

								if(isset($_SESSION['CART_ITEM']) && $_SESSION['CART_ITEM'] !=0 && isset($_SESSION['cartArray']))
  		{
  			$complete_amount ='';
			
			?>

							 <?php
							 

							foreach ($_SESSION['cartArray'] as $key=>$value)
							 {
							  
							       	   $make  = $value['model'];  
								 
								 
								      $quantity = $value['model_quantity'];
								     
								   
								       $price =  $value['model_price'];
								        $total_quantity += $quantity;
								      
									      $checkDiscount = '';
									      $price = $price;
									    								     					     
								  
								  
								   
								echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										<strong>('.$value['make'].') '.$value['model'].'</strong>
									</td>
									<td class="cart-product-name">
										<strong>'.$value['model_quality'].'</strong>
									</td>
									<td class="cart-product-quality">
									  <div class="quantity clearfix">
										  <strong>1x'.$value['model_quantity'].'</strong>
										</div>
									</td>';
									

									echo '<td class="cart-product-subtotal">
										<strong><span class="amount">&#8377; '.$value['sub_total'].'</span></strong>
									</td></tr>';
								    
							
								 $total =  $price*$quantity;
								 $complete_amount += $total;
								 
							 }
							  echo '<tr class="cart_item">									

									
									
									<td class="cart-product-name">
										
									</td>


									<td class="cart-product-price totalTable">
										<b> Total</b>
									</td>

									<td style="text-align: center;" class="totalTable">									       
									       <span class="amount"><b>'.$total_quantity.'</b></span>
									</td>

									<td class="cart-product-subtotal totalTable">
										<span class="amount"><b>&#8377; '.$complete_amount.'</b></span>
									</td>
									
								</tr>';
						          
			 
			  }
			  else{
			  
			    echo '<tr class="cart_item">
						<td colspan="100%" class="cart-product-name">
							<h3 class="text-center">No Item On Cart</h3>
						</td>
					</tr>';
			  
			  }
			    
			
			?>
								<!--  -->
										<!-- End Here  -->
									</tbody>

								</table>

							</div>
						</div>
						<div class="col-md-6 well">
							<div class="table-responsive" id="order_amount_data">
								<h4>Cart Totals</h4>

								<table class="table cart">
									<tbody>
										<tr class="cart_item" style="display:none!important;">
											<td class="cart-product-name">
												<strong>Shipping</strong>
											</td>

											<td class="cart-product-name cartFinalAmount" style="display:none!important;">
												<span class="amount">Free Delivery</span>
											</td>
										</tr>
										<tr class="cart_item">
											<td class="notopborder cart-product-name">
												<strong>Cart Subtotal</strong>
											</td>

											<td class="notopborder cart-product-name cartFinalAmount">
												<span class="amount">&#8377; <?php echo $complete_amount; ?>/-</span>
											</td>
										</tr>
										<?php

										       if(isset($_SESSION["discount"])){
										       		 echo '<tr>
																<td>
																	<strong>Discount</strong>
																</td>

																<td class="cart-product-name  cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$_SESSION["discount"].'/-</strong></span>
																</td>
															</tr>';

										       }

                                                if(isset($_SESSION["royalty_discount"])){
										  			
                                                       
															echo '<tr>
																<td>
																	<strong>Loyalty Discount</strong>
																</td>

																<td class="cart-product-name  cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$_SESSION["royalty_discount"].'/-</strong></span>
																</td>
															</tr>';
												}

										?>
										<?php
										//
										
																							 if(isset($_SESSION["discount_coupon"]) && isset($_SESSION["discount_coupon"]) && !empty($_SESSION["discount_coupon_amount"]))
										  {
																					
												echo '<tr class="cart_item">
																<td class="cart-product-name">
																	<strong>Coupon Discount</strong>
																</td>

																<td class="cart-product-name cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$_SESSION["discount_coupon_amount"].'/-</strong></span>
																</td>
															</tr>';
							
										  }
										
										//
										?>
										<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Total</strong>
											</td>

											<td class="cart-product-name cartFinalAmount payingAmount">
												<span class="amount color lead"><strong>&#8377; <?php echo $full_amount; ?>/-</strong></span>
											</td>
										</tr>
									</tbody>
								</table>

							</div>
							 <input type="hidden" name="billing_country" id="IN" />
							<input type="hidden" name="full_amount" value="<?php echo $full_amount; ?>" />
                             <input type="hidden" name="cartArray" value="<?php echo htmlentities(serialize($cartArray)); ?>" />

                             
                             <input type="hidden" name="quantity_purchased" value="<?php echo $quantity_purchased; ?>" />
                             
                             <input type="hidden" id="order_details_data_show" name="order_details_data_show" value="" />
                             <input type="hidden" id="order_amount_data_show" name="order_amount_data_show" value="" />
                             
                            <input type="hidden" id="order_confirm" name="order_confirm" value="true" />
                             
                             
                             


                            <input type="hidden" name="tid" id="tid" readonly />
                             <input type="text" name="merchant_id" value="123508" hidden>
                             <input type="hidden" name="currency" value="INR" />
                             <input type="hidden" name="amount" value="<?php echo $full_amount; ?>" />
                           

                             <input type="hidden" id="order_id" name="order_id" value="<?php echo $orderid; ?>" />

                             <input type="hidden" name="redirect_url" value="http://qpoonline.com/buy-in-bulk/complete-order-details.php" />
                             <input type="hidden" name="cancel_url" value="http://qpoonline.com/buy-in-bulk/complete-order-details.php" />
                             <input type="hidden" name="language" value="EN"/>

							 <select name="payvia">
								<option value="cash">Cash</option>
								<option value="cheque">Cheque</option>
								<option value="online">Online</option>
							 </select>
							 
							<button type="submit" class="button button-3d fright place_order" id="#place_order">Place Order</button>
						</div>

						</form>
					</div>
				</div>

			</div>

		</section><!-- #content end -->

		<!-- Footer
		============================================= -->
		    <?php include_once("footer.php"); ?>
<!-- #footer end -->

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	

	<!-- External JavaScripts
	============================================= -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->
  	<script type="text/javascript" src="js/functions.js"></script>
  	<script type="text/javascript">
$(function () {
  $('#place_order-form').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
    
    
  })
  .on('form:submit', function(e) {
 
  // ajax calling

  
  // ajac calling end
    return false; //
  });
});
</script>
  	<script>
  	  $("#sameAddr").click(function(){
    


       var samAddr = $('#sameAddr').is(':checked'); 
      

              if(samAddr){
		              var first_name    = $("#first_name").val();
		              var last_name     = $("#last_name").val();
		              var company_name     = $("#company_name").val();

		             
		              var address = $("#address").val();
		              var state = $("#state").val();
		              var city = $("#city").val();
		              var email = $("#email").val();
		              var postal_code = $("#postal_code").val();
		              var phone= $("#phone").val();
		              
		              var mobile = $("#mobile").val();

		              // shipping details

		              document.getElementById("sfirst_name").value = first_name;
		              document.getElementById("slast_name").value = last_name;
		              document.getElementById("scompany_name").value = company_name;

		             
		              document.getElementById("saddress").value = address;
		              document.getElementById("sstate").value = state;
		              document.getElementById("scity").value = city;
		              
		              
		              document.getElementById("semail").value = email;
		              document.getElementById("spostal_code").value = postal_code;
		              
		              
		              document.getElementById("sphone").value = phone;
		              document.getElementById("smobile").value = mobile;
              }

              else{
                      // shipping details

		              document.getElementById("sfirst_name").value = '';
		              document.getElementById("slast_name").value = '';
		              document.getElementById("scompany_name").value = '';

		             
		              document.getElementById("saddress").value = '';
		              document.getElementById("sstate").value = '';
		              document.getElementById("scity").value = '';
		              document.getElementById("spostal_code").value = '';
		              document.getElementById("sphone").value = '';
		              document.getElementById("smobile").value = '';
              }

      });
        
  	</script>

  <?php // include_once('checkout.js'); ?>



</body>
</html>