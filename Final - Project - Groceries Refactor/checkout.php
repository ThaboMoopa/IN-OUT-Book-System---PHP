<?php
/*
* Created by Thabo Moopa and Ntsako Mboweni
* This is our own work most of it using Don Gosselin Book for references
* Designed using http://concisecss.com/archive/v3.0.0/
* 
*/ 
session_start(); 
require_once("classes/class_store.php");
if(class_exists('Store'))
{
	if(isset($_SESSION['Store']))
	{
		$Store = unserialize($_SESSION['Store']);
	}
	else 
		$Store = new Store();
		$Store->getInvoiceID(); 
		$Store->addItemsPurchased($Store->getInvoiceID());
		$Store->reduceInventoryQuantity(); 
		  
}
else 
	echo "Class does not exist"; 
include('templates/inc_header.html'); 
echo '<p class="text--right text--warning">Logged in: <a href="customerHistory.php">'.$Store->getCustomerName(). ' '. $Store->getCustomerSurname().'</a> | <a href="logout.php">Logout</a></p>';  
?>
<h3 class="text--primary">Thank you for shopping with us</h3>
<h4>Your tracking number is: <span class="text--error"><?php echo session_id(); ?></span></h4>
<!-- <h5>See the invoice below</h5> -->
	<table class="flat-table" border='1' style="width:30em;">
		<tr><!--Row 1-->
			<th colspan="4"><label for="Company">Invoice</label></th>
		</tr>
		<tr style="text-align:left;">
			<td><!--Company Details-->
				<label for="Company">Symphony Way</label>
	 			<label for="Company">Bellville</label>
	 			<label for="Company">Cape Town</label>
	 			<label for="Company">7535</label>
	 		</td>
	 		<td colspan='3'><!--Invoice Details-->
	 			<label for="invoice"><strong>Invoice No.</strong><?php echo $Store->getInvoiceID();?></label>
	 			<label for="Date"><strong>Invoice Date:</strong> <?php echo date("d-m-y"); ?></label>
	 		</td>
		</tr>
			
			<tr style="text-align:left;"><!--Row 2-->
				<td><!--Client Details-->
					<label for="Details"><strong>Client Details:</strong></label>
					<label for="name"><?php echo $Store->getCustomerName(); ?></label>
					<label for="surname"><?php echo $Store->getCustomerSurname(); ?></label>
					<label for="cellnumber"><?php echo $Store->getContact(); ?></label>
					<label for="email"><?php echo $Store->getEmail(); ?></label>
				</td>
				<td colspan='3'><!--Shipping Details-->
					<label for="Shipping"><strong>Shipping To:</strong></label>
					<label for="unitno"><?php echo $Store->getUnitNumber(); ?></label>
					<label for="Street"><?php echo $Store->getStreet(); ?></label>
					<label for="City"><?php echo $Store->getCity(); ?></label>
					<label for="province"><?php echo $Store->getProvince(); ?></label>
					<label for="postalCode"><?php echo $Store->getPostalCode(); ?></label>
				</td>
		</tr>
		<tr style="text-align:left;">
			<th>Product Name</th><th>Quantity</th><th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;SubTotal&nbsp;&nbsp;</th>
		</tr>
		<?php $Store->checkout();?>
		</tr>
	</table>
<h3 class="text--primary">Have a great day!</h3>
<?php
$Store->clearCart($Store->getInvoiceID());
$_SESSION['Store'] = serialize($Store); 
?>
<?php 

include("templates/inc_footer.html"); ?>