<?php
/*
* Created by Thabo Moopa and Ntsako Mboweni
* This is our own work most of it using Don Gosselin Book for references
* Designed using http://concisecss.com/archive/v3.0.0/
* 
*/ 
//starts a new session or continues an existing one (p531 Don Gosselin). 
session_start(); 

//require_once function halt the processing of the Webpage if the external class is not available(p651).
require_once("classes/class_store.php");
		
		//Books category to display on the screen
		$categoryID = 0;

/*
* class_exists function determines whether a class exists and is available to the current script.(p576)
* if statements determines if the class exists exists if not a new object of the class is created 
*
*/
		if (class_exists("Store")) {
			 if (isset($_SESSION['Store']))
			 	$Store = unserialize($_SESSION['Store']);
			 else {
				$Store = new Store();
				}
			$Store->setProducts($categoryID);
			$Store->getCustomerID();
			$Store->setWebAppTag(session_id()); 
			$Store->getInvoiceID();
		}
		else {
		$ErrorMsgs[] = "The Store class is not available!";
		$Store = NULL;
	}
//including the html file for the header section of the webpage
include("templates/inc_header.html");

//including the category php file for the different book categories
include('include/inc_categoryButtons.php'); 
if(isset($_POST['viewCart']))
{
	
    if($Store->getCustomerID() == 0)
    {
     echo '<p class="text--error" style="font-size: 1em;">Please Register or Login to continue...</p>'; 
    }
    else
    {
      header('Location: viewCart.php'); 
    }
}
if(isset($_POST['submit']))
{ 
	global $errorInCart;
	$quantityInDatabase = 0;
	$quantityInputted = 0; 
	$buttons = $_POST['submit'];
	$quantity = $_POST['quantity'];
	$buttonKey = 0; 
	$checkInOrderLine = FALSE;

	//if the user is not logged in certain functions in the application will not work 
	if($Store->getCustomerID() == 0)
	{
	 echo '<p class="text--error" style="font-size: 1em;">Please Register or Login to continue...</p>'; 
	}
	else
	{
		foreach($buttons as $key => $value)
		{
			$checkInOrderLine = FALSE; 
			$checkInOrderLine = $Store->checkItemInOrderLine($key);
			$quantityInDatabase = $Store->checkQuantity($key);
			$buttonKey = $Store->buttonKey($key);	
		} 
		if($checkInOrderLine == TRUE)
		{
			 echo '<p class="text--error" style="font-size: 1em;"> Item is already in the cart, click on view my cart</p>'; 
		}
		else
		{
			foreach($quantity as $key =>$value)
			{
				if($value != 0)
			 	{
				 	$quantityInputted = $value;
				}
				 
			}
			if($quantityInputted > $quantityInDatabase)
			{
				echo '<p class="text--error" style="font-size: 1em;">We do not have that much stock in store. Try again.'; 
			}
			else
				if($quantityInputted != 0)
				{
				  	$Store->addToCart($quantityInputted,$buttonKey);
				}
				else
				  	echo '<p class="text--error" style="font-size: 1em;">Quantity of a product must be more than 0 before you can add to cart. Try again.'; 
		}
	}
}

$Store->getProducts();

//if the customerID is not equal to zero then create a new order in the database 
include('include/inc_webAppTag.php');

$_SESSION['Store'] = serialize($Store);
?>
<?php include("templates/inc_footer.html"); ?>

