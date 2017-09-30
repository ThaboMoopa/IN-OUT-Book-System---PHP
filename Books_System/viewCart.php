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
}
else 
	echo "<p>Class does not exist</p>"; 

//Display the Header section
define('TITLE', 'View Cart');
include("templates/inc_header.html");
// include('include/inc_showUser.php'); 
include('include/inc_categoryButtons.php');
include('include/inc_searchInput.php');  
 
$error = FALSE; 
//Button to increment quantity 
if(isset($_POST['increment']))
{
	$orderLineQuantity = 0; 
	$checkQuantity = 0; 
	 $increment = $_POST['increment'];
	 foreach($increment as $key =>$value)
	 {
	 	$orderLineQuantity = $Books->incrementCheckLine($key); 
	 	$inventoryQuantity = $Books->checkQuantity($key);
	 	
	 	
	 	if($orderLineQuantity >= $inventoryQuantity)
	 	{
	 		echo '<p class="text--error">Your quantity excessed our stock. Try a lower number.</p>';
	 		break; 
	 		$error = TRUE;
	 	}
	 	else
	 		$Books->getIncrementQuantity($key); 
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
	 	$orderLineQuantity = $Books->incrementCheckLine($key); 
	 	$inventoryQuantity = $Books->checkQuantity($key);
	 	
	 	
	 	if($orderLineQuantity < 1)
	 	{
	 		echo '<p class="text--error">You cannot purchase a zero quantity item. Rather use the remove item button</p>';
	 		break;
	 		$error = TRUE;  
	 	}
	 	else
	 		$Books->getDecrementQuantity($key); 
	 } 
	  
}
//button to delete an item from the cart
if(isset($_POST['delete']))
{
	$RowID = $_POST['delete'];
	foreach($RowID as $key =>$value)
	{
		$Books->setLineID($key); 
		$Books->getLineID();
		$Books->deleteFromCart($Books->getLineID());	 
	}
}

////Button to Empty the cart
if(isset($_POST['removeAll']))
{
	$Books->removeAllFromCart(); 
}

//Button to checkout the cart
if(isset($_POST['Checkout']))
{
	if($error==TRUE)
	{
		echo "There is a problem in your order items, please check and try checking out again"; 
	}
	elseif($Books->validateCart() == TRUE)
	{
		echo "Home page message Your cart is empty please return to the home page to select new items";
	}
	else
		header('Location: checkout.php');  
}

//get items to display in the cart
$Books->viewCart(); 

$_SESSION['Books'] = serialize($Books); 
include("include/inc_webAppTag.php");
?>
<?php include("templates/inc_footer.html"); ?>
