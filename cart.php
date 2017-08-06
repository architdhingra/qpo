<?php include_once('header.php'); ?>
<?php include_once('cart.js'); ?>

<?php



   //echo $lastDate = date("Y-m-d", strtotime("-1 months"));
  // die;



?>

<!-- #header end -->

		<!-- Page Title
		============================================= -->
		<section id="page-title">
<div class="container clearfix">
				<h1>QPO Cart</h1>
				<ol class="breadcrumb">
					<li><a href="../">Home</a></li>
					<li><a href="./">Shop</a></li>
					<li class="active">Cart</li>
				</ol>
			</div>
</section><!-- #page-title end -->
<!-- Content
		============================================= -->
		<section id="content" class="mainSection"> 
                  <div class="content-wrap">

				<div class="container clearfix">

					<div class="table-responsive bottommargin">

						<table class="table cart cartTable">
							<thead>
								<tr>
									
									
									<th class="cart-product-name">Product</th>
									<th class="cart-product-quality">Quality</th>
									<th class="cart-product-color">Color</th>
									<th class="cart-product-price">Unit Price</th>
									
									
									<th class="cart-product-quantity">Quantity</th>
									<th class="cart-product-subtotal">Total</th>
									<th class="cart-product-remove">Action</th>
								</tr>
							</thead>
							<tbody>
								<!--   -->
								<?php
								
								global $qDiscount;
								global $rDiscount;
								global $qcDiscount;
								
								
								


								if(isset($_SESSION['CART_ITEM']) && $_SESSION['CART_ITEM'] !=0 && isset($_SESSION['cartArray']))
  		{

  			if(isset($_SESSION['order_details_data']) && isset($_SESSION['order_amount_data'])){

  				unset($_SESSION['order_details_data']);    
                                unset($_SESSION['order_amount_data']);
  			}

  			
  	   		$complete_amount ='';
  	   		$discount_status;
  	   		$quantity_purchased = 0;
  	   		
  	   		$date = date('Y-m-d');

  	   	       $_SESSION['mobile'] = $_SESSION['OTP_VERFIY']['mobile'];
  	   	      
  	   	      
  	   	       
  	   	       
  	   		


          // Check if a user is already registered or not

  	   		

  	   		$query = $db->query("SELECT * FROM `user_information` WHERE email= '".$db->real_escape_string(trim($_SESSION['email']))."' OR mobile= '".$db->real_escape_string(trim($_SESSION['mobile']))."'");
    
  
			    //Count total number of rows
			   $rowCount = $query->num_rows;
			   
			    
			    //Display model list
			    if($rowCount == 1){
			    	 $discount_status = 'OLD';
			    	

			    	 $query_chk_edd = $db->query("SELECT * FROM `user_buying_information` WHERE `status`= '1' AND (email= '".$db->real_escape_string(trim($_SESSION['email']))."' OR mobile= '".$db->real_escape_string(trim($_SESSION['mobile']))."')  ORDER BY id DESC LIMIT 1");

			    	       $rowCountEDD = $query_chk_edd->num_rows;	   
						    
						    //Display model list
						    if($rowCountEDD == 1){

						    	$rowEDD = $query_chk_edd->fetch_assoc();	
						        $discount_end_date	= 	$rowEDD['discount_end_date'];
						        

						        if($discount_end_date >= $date){ // Find Quantity and Amount Last Payed by Buyer

						        	 $discount_start_date	= 	$rowEDD['discount_start_date'];
						        	 $order_placed_amount	= 	$rowEDD['order_placed_amount'];

						        	  $_SESSION['discount_start_date']	= 	$discount_start_date;
						        	  $_SESSION['discount_end_date']	= 	$discount_end_date;


						        	 // Find sum of quantity till start date to calculate discount and rolayty discount

						        	   $query_sq = $db->query("SELECT SUM(quantity_purchased) as `quantity_purchased` FROM `user_buying_information` WHERE `status`= '1' AND `discount_start_date`='".$db->real_escape_string(trim($discount_start_date))."' AND `discount_end_date`='".$db->real_escape_string(trim($discount_end_date))."'");



						    	       $rowCountSq = $query_sq->num_rows;	   
									    $quantity_purchased;
									    //Display model list
									    if($rowCountSq == 1){
									    	 $rowSq = $query_sq->fetch_assoc();	
						       				 $quantity_purchased	= 	$rowSq['quantity_purchased'];

									    }
									    else{
									    	    $quantity_purchased = '';
									    }

						        	 // End here

									    // Start Calculating Loyalty Discount Procedure

									       $query_ld = $db->query("SELECT * FROM `user_buying_information` WHERE `status`= '1' AND `discount_start_date`='".$db->real_escape_string(trim($discount_start_date))."' AND `discount_end_date`='".$db->real_escape_string(trim($discount_end_date))."'");



						    	       $rowCountLd = $query_ld->num_rows;	   
									    $sum_of_p_actual_amount;
									    //Display model list
									    if($rowCountLd > 0){
									    	 while($rowLd = $query_ld->fetch_assoc()){
						       				     $sum_of_p_actual_amount	+= 	$rowLd['actual_amount'];
									    	 }

									    }
									    else{
									    	   $sum_of_p_actual_amount = '';

									    }



									    // End Calculating Loyaltiy Discount 






						        }
						        else{ // Discount period is over, Process start again
						          unset($_SESSION["royalty_discount"]);
                                        $discount_status = 'RENEW';
						        }
						    }
						     else{
			    
						 	   unset($_SESSION["royalty_discount"]);
						    }
						    

			    }
			    else{
			    
			 	   unset($_SESSION["royalty_discount"]);

			    	  $discount_status = 'NEW';
			    	 
			    }

  	   	 // End here

			
			?>

							 <?php
							  $total_quantity;
							  $total_price;
							 

							foreach ($_SESSION['cartArray'] as $key=>$value)
							 {
							  
							            
							                                                                  
                                                         
                            		
							    	   $make  = $value['model'];  
							 
							 
							     	  $quantity = $value['model_quantity'];

								     	  							  
								       $price =  $value['model_price'];

								       $total_quantity += $quantity;
								      // $total_price    += $total_price;

                                      								      
									
								     					     
								  
								 ////  echo $price;
								  // die;								  
								   
								echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										<strong>('.$value['make'].') '.$value['model'].'</strong>
									</td>
									<td class="cart-product-name">
										<strong>'.$value['model_quality'].'</strong>
									</td>
									<td class="cart-product-name">
										<strong>'.$value['model_color'].'</strong>
									</td>


									<td class="cart-product-price">
										<strong><span class="amount">&#8377; '.$value['model_price'].'/-</span></strong>
									</td>';
									
									

									echo '<td class="cart-product-quantity">
										<div class="quantity clearfix">

											<form name="updateItemForm" style="margin-bottom: 0px !important;">
												   <input value="'.$key.'" class="" type="hidden" name="update_model_quantity" id="update_model_quantity" />
			                        				<div><strong><input rel="'.$key.'" class="model_quantity" type="number" min="1" name="model_quantity" id="model_quantity" value="'.$value['model_quantity'].'" style="width: 30%;float: left;text-align: center; margin-top: 8px;" /></strong></div>
			                        				<div>	
                                                   <input type="submit" name="updateItem" id="updateItem" class="btn button button-3d update update_quantity" value="Update" /></div>	
												</form>											
											
										</div>
									</td>

									<td class="cart-product-subtotal">
										<strong><span class="amount">&#8377; '.$value['sub_total'].'/-</span></strong>
									</td>
									<td class="cart-product-remove" style="text-align: center;">
										<a href="#" rel="'.$key.'" class="removeItem" title="Remove this item"><i class="icon-trash2"></i></a>										
									</td>
								</tr>';
								    
							
								 $total =  $price*$quantity;
								 $complete_amount += $total;

								 
							 }

							 $_SESSION["actual_amount"] = $complete_amount;
							  $real_complete_amount = $complete_amount;
							  $_SESSION["full_amount"] = $complete_amount;
							 $_SESSION["quantity_purchased"] = $total_quantity;
							
							  $process_message = '';
							  $process_status = 1;

							  $check_multiple = $total_quantity;
							  $check_multiple %= 15;

							  if($total_quantity <15){

							  	$process_status = 0;

							  	$process_message = 'Select Quantity in multiple of 15 (e.g. 15, 30, 45, 60...)';

							  }
							  else if($total_quantity > 15 && $total_quantity < 30 && $check_multiple != 0 ){

							  			$process_status = 0;
							  			$process_message = 'Select Quantity in multiple of 15 (e.g. 15, 30, 45, 60...)';
							  	
							  }

							  else if($total_quantity > 30 && $total_quantity < 60 && $check_multiple != 0 ){

							  			$process_status = 0;
							  			$process_message = 'Select Quantity in multiple of 15 (e.g. 15, 30, 45, 60...)';
							  	
							  }
							  else if($total_quantity > 60 && $total_quantity < 120 && $check_multiple != 0 ){

							  			$process_status = 0;
							  			$process_message = 'Select Quantity in multiple of 15 (e.g. 15, 30, 45, 60...)';
							  	
							  }

							  else if($total_quantity > 1200){

							  			$process_status = 0;
							  			$process_message = 'Maximum Number of Quantity is 1200';
							  	
							  }
							  else{

							  //  Start of Checking how many products buyed one month period 
                                  // *** Get all details in Above. Now calculate Discount and Royalty Discount Amount ***

                                  // Add Previous Quantity for Discount

							     $total_quantity_for_discount = $total_quantity + $quantity_purchased;

							  // End of Checking how many products buyed one month period 

							  $checkDiscount = '';
							  $discount = '';
							  $amount_after_discount = '';
							  $discount_given = '';
							  
							   
							  

							  if($total_quantity_for_discount >=30 && $total_quantity_for_discount < 60)
							  {

							  	 	      $checkDiscount 			= "5%";
									      $discount 			= ($complete_amount/100)*5;
									      $amount_after_discount  	= $complete_amount - $discount;
									      
									      $qDiscount = $discount;
									     $_SESSION["discount"]     = $discount;
									    
									    

							  }
							  else if($total_quantity_for_discount >=60 && $total_quantity_for_discount < 120)
							  {
							  	 		  $checkDiscount 			= "10%";
									      $discount 				= ($complete_amount/100)*10;
									      $amount_after_discount  	= $complete_amount - $discount;
									      
									       $qDiscount = $discount;
									      $_SESSION["discount"] = $discount;
							  }
							  else if($total_quantity_for_discount >=120)
							  {

							  			  $checkDiscount 			= "15%";
									      $discount 				= ($complete_amount/100)*15;
									      $amount_after_discount  	= $complete_amount - $discount;
									      
									       $qDiscount = $discount;
									      $_SESSION["discount"]		= $discount;
							  }
							  else{
                                     				   $amount_after_discount  	= $complete_amount;
                                     				   $qDiscount = '';

							  }
							  
							  
							  if(isset($_SESSION["discount_coupon"])){
		
					  	 	     $discount_coupon		= $_SESSION["discount_coupon"];
					  	 	    
							      // $discount 		= ($complete_amount/100)*$discount_coupon;
							      $discount_given 		= $discount_coupon;
							      $amount_after_discount  	= $complete_amount - $discount_given;
							      
							       $qcDiscount = $discount_given;
							      
							      $_SESSION["discount_coupon"] = $discount_given;
		
							  }
							  
							  
							 
							  
							  

			    if($discount != '')
                               {
                                 
                               }
                               else{                               
                                 
                               	    unset($_SESSION["discount"]);
                               }
                               
                               	  if($discount_given !='')
                               {
                                
                                  $_SESSION["discount_coupon_amount"] = $discount_given;
                               }
                               else{
                               	    unset($_SESSION["discount_coupon_amount"]);
                               }
                               
                               // Checking Loyalty Discount
                                 if($amount_after_discount !='')
                                             {

						switch ($discount_status) {
						  case "OLD":
                                                        if($sum_of_p_actual_amount !='')
                                                        {

                                                        	// Check current quantity and allow loyalty discount
								                            
				  	 	      $checkDiscount 			= "5%";
						      $royalty_discount 		= ($sum_of_p_actual_amount/100)*5;
						     
						      $_SESSION["royalty_discount"] = $royalty_discount;
						      $rDiscount = 	$royalty_discount;																      
															  
                                                        	// end section here
	                                                        
	                                                      
	                                                    }
	                                                    else{
	                                                    	 
	                                                    }
                                                       
                                                       if($royalty_discount !=0)
                                                       {
                                                        
                                                          $_SESSION["royalty_discount"] = $royalty_discount;
                                                          $rDiscount = 	$royalty_discount;
                                                       }
                                                       else{
                                                       	   unset($_SESSION["royalty_discount"]);
                                                       }
                                         }
                                    }
                               // End Rolaylty Discount


							}

							  echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>


									<td class="cart-product-price totalTable">
										<b> Sub Total</b>
									</td>

									<td style="text-align: center;" class="totalTable">									       
									       <span class="amount"><b>'.$total_quantity.'</b></span>
									</td>

									<td class="cart-product-subtotal totalTable">
										<span class="amount"><b>&#8377; '.$complete_amount.'/-</b></span>
									</td>
									<td class="cart-product-name">
										
									</td>
									
								</tr>';
								
								
								if(!empty($qDiscount)){
								
							
							 echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>
									
									


								<td class="cart-product-name"></td>
								<td class="cart-product-name"></td>
								<td class="cart-product-subtotal">
									<strong>Discount</strong>
								</td>

									

									<td class="cart-product-name cart-product-subtotal">
								<span class="amount color lead discountAmount"><strong>&#8377; '.$qDiscount.'/-</strong></span>
								</td>
									<td class="cart-product-name">
										
									</td>
									
								</tr>';
									 

						 }
						 
						 if(!empty($rDiscount)){
						
						 echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>
									
									


								<td class="cart-product-name"></td>
								<td class="cart-product-name"></td>
								<td class="cart-product-subtotal">
									<strong>Loyalty Discount</strong>
								</td>

									

									<td class="cart-product-name cart-product-subtotal">
								<span class="amount color lead discountAmount"><strong>&#8377; '.$rDiscount.'/-</strong></span>
								</td>
									<td class="cart-product-name">
										
									</td>
									
								</tr>';
						

						
					}
						 
						 // start coupon discount
						$discount_coupon_value = '';				
																							 if(isset($_SESSION["discount_coupon"]) && isset($_SESSION["discount_coupon"]) && !empty($_SESSION["discount_coupon_amount"]))
				 {
				 $discount_coupon_value = $_SESSION["discount_coupon_amount"];
										  
						 echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>
									

								<td class="cart-product-name"></td>
								<td class="cart-product-name"></td>
								<td class="cart-product-subtotal">
									<strong>Coupon Discount</strong>
								</td>

									

									<td class="cart-product-name cart-product-subtotal">
								<span class="amount color lead discountAmount"><strong>&#8377; '.$_SESSION["discount_coupon_amount"].'/-</strong></span>
								</td>
									<td class="cart-product-name">
										
									</td>
									
								</tr>';
                                                       
						
		 } // end coupon discount
		 
		 
		 $final_complete_amount = $real_complete_amount -  ($qDiscount + $rDiscount + $discount_coupon_value);
					
					// Displaying Cart Total After Disocunt
							
							 echo '<tr class="cart_item">									

									
									<td class="cart-product-name">
										
									</td>
									<td class="cart-product-name">
										
									</td>
									
									


								<td class="cart-product-name"></td>
								<td class="cart-product-name"></td>
								<td class="cart-product-price totalTable">
										<b>Total</b>
									</td>

									
									<td class="cart-product-subtotal totalTable">
										<span class="amount color lead"><b>&#8377; '.$final_complete_amount.'/-</b></span>
									</td>
									<td class="cart-product-name">
										
									</td>
									
								</tr>';
									 

						
						 
						 // End Displaying Cart Total After Disocunt
								
								

								echo '<tr>
										<td colspan="100%" style="rel:rr;color: red;font-weight: bold;font-size: 20px;text-align: center;text-transform: uppercase;">
											'.$process_message.'
										</td>
								       </tr>';

						       // unset($cartArray["login_user"]);

							echo  ' <tr class="cart_item">
									<td colspan="100%">
										<div class="row clearfix">
										<form action="#" method="post" id="apply_coupon_form">
											<div class="col-md-4 col-xs-4 nopadding">
												<div class="col-md-8 col-xs-7 nopadding">
													<input type="hidden" name="total_cart_amount" id="total_cart_amount" value="'.$real_complete_amount.'">
													<input name="apply_coupon_text" id="apply_coupon_text" type="text" value="" class="sm-form-control" placeholder="Enter Coupon Code" />
												</div>
												<div class="col-md-4 col-xs-5">
												
													<input type="submit" id="apply_coupon" value="Apply Coupon" class="button button-3d nomargin">
												</div>
											</div>
											
										</form>	
										</div>';
										
										
										if(isset($_SESSION["apply_text"]))
										{
										   echo '<div class="col-md-12 col-xs-12"><span class="coupon-text" style="color:green;font-size: 14px;">Congratulations!
 Your Coupon Code applied Successfully.</span></div>';
										   
										 }
										else if(isset($_SESSION["apply_text_exp"]))
										{
										   echo '<div class="col-md-12 col-xs-12"><span class="coupon-text" style="color:green;font-size: 14px;">'.$_SESSION["apply_text_exp"].'</span></div>';
										   
										   unset($_SESSION['apply_text_exp']);
										   
										 }
										 
									echo '</td>
								</tr>';
								echo '</tbody>

						</table>

					</div>

					<div class="row clearfix">
						

						<div class="col-md-6 clearfix">
							<div class="table-responsive">
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
											<td class="cart-product-name">
												<strong>Cart Subtotal</strong>
											</td>

											<td class="cart-product-name cartFinalAmount">
												<span class="amount">&#8377; '.$complete_amount.'/-</span>
											</td>
										</tr>';
										// Apply discount and royalty discount
										
										

                                              if($amount_after_discount !='')
                                             {

											switch ($discount_status) {
											    case "OLD":
                                                        if($sum_of_p_actual_amount !='')
                                                        {

                                                        	// Check current quantity and allow loyalty discount
								                            
															  	 	      $checkDiscount 			= "5%";
																	      $royalty_discount 				= ($sum_of_p_actual_amount/100)*5;
																	      $amount_after_discount  	= $amount_after_discount - $royalty_discount;
																	      $_SESSION["royalty_discount"] = $royalty_discount;
$rDiscount = 	$royalty_discount;																      
															  
                                                        	// end section here
	                                                        
	                                                        $complete_amount  	= $amount_after_discount;
	                                                    }
	                                                    else{
	                                                    	 $complete_amount  	= $amount_after_discount;
	                                                    }
                                                       
                                                       if($royalty_discount !=0)
                                                       {
                                                        
                                                          $_SESSION["royalty_discount"] = $royalty_discount;
                                                          $rDiscount = 	$royalty_discount;
                                                       }
                                                       else{
                                                       	   unset($_SESSION["royalty_discount"]);
                                                       }
                                                       
                                                       											       
											        break;
											    case "RENEW":												       
											        
											         $discount_end_date = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");
													 $discount_end_date = date("Y-m-d",$discount_end_date);
													
													  $_SESSION['discount_start_date']	= 	$date;
						        	                  $_SESSION['discount_end_date']	= 	$discount_end_date;

											        break;
											    case "NEW":

                                                     $discount_end_date = strtotime(date("Y-m-d", strtotime($date)) . " +1 month");
													 $discount_end_date = date("Y-m-d",$discount_end_date);													 
													  $_SESSION['discount_start_date']	= 	$date;
						        	                  $_SESSION['discount_end_date']	= 	$discount_end_date;
						        	                 
											        
											        break;
											    default:
											        
											}
											
								if(isset($_SESSION["discount_coupon"]) && isset($_SESSION["discount_coupon_amount"]))			
                                                                {

								 $complete_amount  	= $amount_after_discount;
								      
								     
			
								 }
											
											
										}
										else{
										
										if(isset($_SESSION["discount_coupon"]) && isset($_SESSION["discount_coupon_amount"]))			
                                                                                {
		
									 $complete_amount  	= $complete_amount - $_SESSION["discount_coupon_amount"];
										      
										     
					
										 }
										 else
										 {
										 	$complete_amount = $complete_amount;
										 }
											   
										}
										
										// end calculating all discount 
										
									 // displaying discount and loyalty discount
									 
									

                                                        if(!empty($qDiscount)){
										       				 echo '<tr>
																<td>
																	<strong>Discount</strong>
																</td>

																<td class="cart-product-name cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$qDiscount.'/-</strong></span>
																</td>
															</tr>';

										      				 }

															if(!empty($rDiscount)){
										  			
                                                       
															echo '<tr>
																<td>
																	<strong>Loyalty Discount</strong>
																</td>

																<td class="cart-product-name cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$rDiscount.'/-</strong></span>
																</td>
															</tr>';
														}
														
									 
									 // end 
										
										//
										
																							 if(isset($_SESSION["discount_coupon"]) && isset($_SESSION["discount_coupon"]) && !empty($_SESSION["discount_coupon_amount"]))
										  {
																					
												echo '<tr>
																<td>
																	<strong>Coupon Discount</strong>
																</td>

																<td class="cart-product-name cartFinalAmount">
																	<span class="amount color lead discountAmount"><strong>&#8377; '.$_SESSION["discount_coupon_amount"].'/-</strong></span>
																</td>
															</tr>';
							
										  }
										
										//

										//$_SESSION["full_amount"] = $complete_amount;
										$_SESSION["full_amount"] = $final_complete_amount;
										
										



										//

										echo '<tr class="cart_item">
											<td class="cart-product-name">
												<strong>Total</strong>
											</td>

											<td class="cart-product-name cartFinalAmount payingAmount">
												<span class="amount color lead"><strong>&#8377; '.$final_complete_amount.'/-</strong></span>
											</td>
										</tr>
										</tbody>

								</table>

							</div>
						</div>
						<div class="col-md-6 clearfix">
							<div class="col-md-6 col-xs-8 nopadding">';

                                        if($process_status == 0)
                                        {
                                        	echo '<input type="submit" class="btn btn-warning button button-3d notopmargin fright" value="Cannot Proceed To Checkout" disabled />';
                                        }
                                        else
                                        {
                                        	echo '<form name="checkOutForm" method="post" action="checkout.php">
					                        	<input type="hidden" name="cartArray" value="'.htmlentities(serialize($_SESSION['cartArray'])).'" />

						                        	<input value="'.$final_complete_amount.'" type="hidden" name="full_amount" id="full_amount" />
						                        	<input type="submit" class="btn btn-warning proceedCheckout button button-3d notopmargin fright" value="Proceed To Checkout" />

						                        	
					                        	</form>';

                                        }
												
												
								echo '</div>
						</div>';
										
											
									
							
						                        
			                      
			                      
			 
			  }
			  else{
			     
                               	    unset($_SESSION["discount_coupon"]);
                               	    
                               	   unset($_SESSION["discount_coupon_amount"]);
			  
			    echo '<tr class="cart_item">
						<td colspan="100%" class="cart-product-name">
							<h3 class="text-center">No Item On Cart</h3>
						</td>
					</tr>';
			  
			  }

			  //echo '';
			//  print_r($_SESSION);
			//  die;
			    
			
			?>
								<!--  -->
							</tbody>

								</table>

							</div>
						</div>
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

	<!-- External JavaScripts
	============================================= -->



	<script type="text/javascript" src="js/jquery.js"></script>


	<script type="text/javascript" src="js/plugins.js"></script>

	<!-- Footer Scripts
	============================================= -->

	
	<script type="text/javascript" src="js/functions.js"></script>




	

</body>
</html>