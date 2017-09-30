<?php
/*
* Created by Thabo Moopa and Ntsako Mboweni
* This is our own work most of it using Don Gosselin Book for references
* Designed using http://concisecss.com/archive/v3.0.0/
* 
*/ 
//starts a new session or continues an existing one (p531 Don Gosselin).  
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
}
else 
	echo "<p>Class does not exist</p>"; 

//Display the Header section
include("templates/inc_header.html");
include('include/inc_categoryButtons.php'); 

$error = FALSE; 
//Button to increment quantity 
if(isset($_POST['increment']))
{
	$orderLineQuantity = 0; 
	$checkQuantity = 0; 
	 $increment = $_POST['increment'];
	 foreach($increment as $key =>$value)
	 {
	 	$orderLineQuantity = $Store->incrementCheckLine($key); 
	 	$inventoryQuantity = $Store->checkQuantity($key);
	 	
	 	
	 	if($orderLineQuantity >= $inventoryQuantity)
	 	{
	 		echo '<p class="text--error">Currently we do not have that much stock for you to purchase</p>'; 
	 		break; 
	 		//$error = TRUE;
	 	}
	 	else
	 		$Store->getIncrementQuantity($key); 
	 } 
	  	  
}

//button to decrement quantity
if(isset($_POST['decrement']))
{
	$orderLineQuantity = 0; 
	$checkQuantity = 0; 
	 $increment = $_POST['decrement'];
	 foreach($increment as $key =>$value)
	 {
	 	$orderLineQuantity = $Store->incrementCheckLine($key); 
	 	$inventoryQuantity = $Store->checkQuantity($key);
	 	
	 	
	 	if($orderLineQuantity <= 1)
	 	{
	 		echo '<p class="text--error>Quantity cannot be less than one(1), rather use the remove item button</p>';
	 		break;
	 		//$error = TRUE;  
	 	}
	 	else
	 		$Store->getDecrementQuantity($key); 
	 } 
	  
}
//button to delete an item from the cart
if(isset($_POST['delete']))
{
	$RowID = $_POST['delete'];
	foreach($RowID as $key =>$value)
	{
		$Store->setLineID($key); 
		$Store->getLineID();
		$Store->deleteFromCart($Store->getLineID());	 
	}
}

////Button to Empty the cart
if(isset($_POST['removeAll']))
{
	$Store->removeAllFromCart(); 
}

//Button to checkout the cart
if(isset($_POST['Checkout']))
{
	if($error==TRUE)
	{
		echo '<p class="text-error">There is a problem in your order items, please check and try checking out again'; 
	}
	elseif($Store->validateCart() == TRUE)
	{
		echo '<p class="text--primary">The cart has been cleared, click the links above or click the home page to add new items.';
	}
	else
		header('Location: checkout.php');  
}

//get items to display in the cart
$Store->viewCart(); 

$_SESSION['Store'] = serialize($Store); 
include("include/inc_webAppTag.php");
?>
<?php include("templates/inc_footer.html"); ?>
