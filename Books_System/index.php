<?php 
session_start(); 
require_once("classes/class_Books.php");
//include the header
include('templates/inc_header.html');
 $categoryID = 0;
if(class_exists('Books'))
{
	if(isset($_SESSION['Books']))
	{
		$Books = unserialize($_SESSION['Books']);
	}
	else
	 	$Books = new Books();
	 	$Books->setBooks($categoryID);
	 	$Books->getCustomerID();
		$Books->setWebAppTag(session_id()); 
		$Books->getInvoiceID(); 
}
else 
	echo '<p class="text--error">Class does not exist</p>';

$showForm = TRUE; 
$searchResult = 0; 
/***This is the home page made from templates**/
function validateSearch($search, $errorFormCount)
{
	global $searchError;
	global $errorFormCount; 
	$validSearch = preg_match("/^[a-z]+$/i", $search); 
	if(empty($search))
	{
		$searchError = '<p class="text--error">Field cannot be empty.</p>';
		$showForm = TRUE; 
		++$errorFormCount;  
	}
	elseif($validSearch == 0)
	{
		$searchError = '<p class="text--error">Only alphabetic characters allowed in the field.</p>';
		$showForm = TRUE; 
		++$errorFormCount; 
	}
	return $search;

}
if(isset($_POST['submit']))
{ 
	global $errorInCart;
	$quantityInDatabase = 0;
	$quantityInputted = 0; 
	$buttons = $_POST['submit'];
	$quantity = $_POST['quantity'];
	$buttonKey = 0; 
	$checkInOrderLine = 0;

	if($Books->getCustomerID() == 0)
	{
	 echo '<p class="text--error" style="font-size: 1em;">You need to Register or Login before you can continue...</p>'; 
	}
	else
	{
		foreach($buttons as $key => $value)
		{
			$checkInOrderLine = 0; 
			$checkInOrderLine = $Books->checkItemInOrderLine($key);
			$quantityInDatabase = $Books->checkQuantity($key);
			$buttonKey = $Books->buttonKey($key);	
		} 
		if($checkInOrderLine == 0)
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
				echo '<p class="text--error" style="font-size: 1em;">We currently do not have '.$quantityInputted.' books in our stock.'; 
			}
			else
				if($quantityInputted != 0)
				{
				  	$Books->addToCart($quantityInputted,$buttonKey);
				}
				else
				  	echo '<p class="text--error" style="font-size: 1em;">Quantity of selected item must be more than 0 before you can add to cart. Try again.'; 
		}
	}
}
if(isset($_POST['viewCart']))
{
	
    if($Books->getCustomerID() == 0)
    {
     echo '<p class="text--error" style="font-size: 1em;">You need to Register or Login before you can continue...</p>'; 
    }
    else
    {
      header('Location: viewCart.php'); 
    }
}

if(isset($_POST['searchButton']))
{
	 
	$search = stripslashes(trim($_POST['search'])); 
	validateSearch($search, $errorFormCount);

	if($errorFormCount == 0)
	{
		$searchResult = $Books->setSearch($search); 
		$showForm = FALSE;
	}
	else 
	{
		$showForm = TRUE; //if the form has errors it will be re-displayed
	}  	 
}
else
	{
		$showForm = TRUE; //the script will determine if to display the form or not
}
if($showForm == TRUE)
{
// include('include/inc_showUser.php'); 
include('include/inc_categoryButtons.php');
//include('include/inc_showUser.php'); 
//require_once('include/inc_db_books.php'); //include the database connection
include('include/inc_searchInput.php');
} 
echo '<h4 class="text--primary">Latest books to purchase</h4>';
// if($showForm == TRUE)
// {
// 	if($searchResult == 1)
// 	{
// 		$Books->getSearch();  
// 	}
// 	else
	//{
		$Books->getBooks(); 
	//}
	
//} 
include('include/inc_webAppTag.php');
$_SESSION['Books'] = serialize($Books);
//include the footer
include('templates/inc_footer.html');
?>
