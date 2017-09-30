<?php 
session_start(); 
require_once("classes/class_Books.php");
if(class_exists('Books'))
{
	if(isset($_SESSION['Books']))
	{
		$Books = unserialize($_SESSION['Books']);
	}
	else 
		$Books = new Books();
		$Books->getInvoiceID(); 
		$Books->addItemsPurchased($Books->getInvoiceID());
		$Books->reduceInventoryQuantity(); 
		  
}
else 
	echo "Class does not exist"; 
include('templates/inc_header.html');
 include('include/inc_showUser.php');
?>
<h3 class="text--primary">Thank you for shopping with us!</h3>
<h4>Your tracking number is | <span class="text--error"><?php echo session_id(); ?></span></h4>
<h5>See the invoice below</h5>
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
	 			<label for="invoice"><strong>Invoice No.</strong><?php echo $Books->getInvoiceID();?></label>
	 			<label for="Date"><strong>Invoice Date:</strong> <?php echo date("d-m-y"); ?></label>
	 		</td>
		</tr>
			
			<tr style="text-align:left;"><!--Row 2-->
				<td><!--Client Details-->
					<label for="Details"><strong>Client Details:</strong></label>
					<label for="name"><?php echo $Books->getCustomerName(); ?></label>
					<label for="surname"><?php echo $Books->getCustomerSurname(); ?></label>
					<label for="cellnumber"><?php echo $Books->getContact(); ?></label>
					<label for="email"><?php echo $Books->getEmail(); ?></label>
				</td>
				<td colspan='3'><!--Shipping Details-->
					<label for="Shipping"><strong>Shipping To:</strong></label>
					<label for="unitno"><?php echo $Books->getUnitNumber(); ?></label>
					<label for="Street"><?php echo $Books->getStreet(); ?></label>
					<label for="City"><?php echo $Books->getCity(); ?></label>
					<label for="province"><?php echo $Books->getProvince(); ?></label>
					<label for="postalCode"><?php echo $Books->getPostalCode(); ?></label>
				</td>
		</tr>
		<tr style="text-align:left;">
			<th>Product Name</th><th>Quantity</th><th>&nbsp;&nbsp;&nbsp;Price&nbsp;&nbsp;&nbsp;</th><th>&nbsp;&nbsp;SubTotal&nbsp;&nbsp;</th>
		</tr>
		<?php $Books->checkout();?>
		</tr>
	</table>
<h3 class="text--primary">Have a great day!</h3>
<?php
$Books->clearCart($Books->getInvoiceID());
$_SESSION['Books'] = serialize($Books); 
?>
<?php 

include("templates/inc_footer.html"); ?>