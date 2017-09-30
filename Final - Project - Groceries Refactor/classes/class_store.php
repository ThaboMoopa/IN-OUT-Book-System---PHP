<?php
/*
* Created by Thabo Moopa and Ntsako Mboweni
* This is our own work most of it using Don Gosselin Book for references
* Designed using http://concisecss.com/archive/v3.0.0/
* 
*/ 
//class for the store
class Store {
private $DBConnect = NULL;
private $categoryID = 0; 
private $inventory = array();
private $shoppingCart = array();
private $email = ""; 
private $customerID = 0; 
private $customerName = "";
private $customerSurname = "";
private $quantity = array();
private $prices = array(); 
private $Cart = array();
private $list = array();
private $lineID = 0;   
private $removeAll = array();
private $province = ""; 
private $cellNumber = 0;
private $city = "";
private $unitNumber = 0; 
private $street = "";
private $webAppTag = "";
private $newProductID = array(); 
private $productsItemID = array();
private $buttons = array(); 
private $invoiceID = ""; 
private $itemsPurchased = array();
private $customer = array();
private $datePurchased = array();
private $password = "";  
        

//constructor function is a special function that is called automatically when an object from a class is instantiated. p585
function __construct() {
	include("include/inc_db_groceries.php");
	$this->DBConnect = $DBConnect;
}
//cleans up any resources allocated to an object after the object is destroyed.p587
function __destruct() {
	if (!$this->DBConnect->connect_error)
	$this->DBConnect->close();
}
//getters and setter for variables p588
public function setInvoiceID($invoiceID)
{
	$this->invoiceString = $invoiceID; 
}
public function getInvoiceID()
{
	return $this->invoiceID; 
}
public function setClientCellNumber($cellNumber)
{
	$this->cellNumber = $cellNumber; 
}
public function getCellNumber()
{
	return $this->cellNumber; 
}
public function setProvince($province)
{
	$this->province = $province; 
}
public function getProvince()
{
	return $this->province; 
}
public function setCity($city)
{
	$this->city = $city; 
}
public function getCity()
{
	return $this->city; 
}
public function setStreet($street)
{
	$this->street = $street; 
}
public function getStreet()
{
	return $this->street; 
}
public function setUnitNumber($unitNumber)
{
	$this->unitNumber = $unitNumber; 
}
public function getUnitNumber()
{
	return $this->unitNumber; 
}
public function setEmail($email)
{
	$this->email = $email; 
}
public function getEmail()
{
	return $this->email; 
}
public function setContact($contact)
{
	$this->contact = $contact; 
}
public function getContact()
{
	return $this->contact; 
}
public function setPostalCode($postalCode)
{
	$this->postalCode = $postalCode; 
}
public function getPostalCode()
{
	return $this->postalCode; 
}
public function setWebAppTag($webAppTag)
{
	$this->webAppTag = substr($webAppTag,0,4); 
}
public function getWebAppTag()
{
	return $this->webAppTag; 
}
//done
public function getCustomerName()
{
	return $this->customerName; 
}
public function setCustomerID($customerID)
{
	$this->customerID = $customerID; 
}
public function getCustomerID()
{
	return $this->customerID;
}
//done
public function getCustomerSurname()
{
	return $this->customerSurname; 
}
//done
public function setQuantity($quantity)
{
	$this->quantity = $quantity;
}
//done
public function getQuantity()
{
	return $this->quantity; 
}

public function setLineID($lineID)
{
	$this->lineID = $lineID; 
}

public function getLineID()
{
	return $this->lineID; 
}
public function setPassword($password)
{
	$this->password = $password; 
}
public function getPassword()
{
	return $this->password; 
}
//function to check if whether an item is already in the cart
public function checkItemInOrderLine($product_id)
{
	$keyExists = 0; 
	$sqlString = "SELECT * FROM orderLine WHERE product_id = $product_id AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		$keyExists = $row['product_id']; 
	}
	if($keyExists == $product_id)
	{
		return TRUE;
	}
	else 
		return FALSE;
	
	
}
//function to increment the item added to the cart using the button
public function incrementCheckLine($product_id)
{
	$quantity = 0; 
	$sqlString = "SELECT * FROM orderLine WHERE product_id = $product_id AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		$quantity = $row['quantity']; 
	}
	return $quantity; 
}
//function to validate that the cart is empty once you empty the cart
public function validateCart()
{
	$retValue = FALSE; 
	if(empty($this->Cart))
	{
		echo '<p class="text--error" style="font-size: 1em;">The cart is empty please return to home page to select new items.</p>';
	}
	return $retValue; 
}

//function to check if the quantity in the database 
public function checkQuantity($productID)
{
	$quantity = 0; 
	$sqlQuantityCheck = "SELECT quantity FROM product WHERE product_id = $productID";
	$queryResult = @$this->DBConnect->query($sqlQuantityCheck);
	 while(($row = $queryResult->fetch_assoc())!== NULL)
	 {
	 	$quantity = $row['quantity']; 
	 }

	return $quantity; 
}
//function to return the id of the "add to cart" buttons
public function buttonKey($buttonKey)
{
	return $buttonKey; 
}

/* function to add a new item to the cart if the cart is empty*/
public function addToCart($quantity,$product_id)
{
	$quantity; 
	$sessionID = session_id();
	$price = 0.00;  
	$total = 0.00;
	if($this->customerID == 0)
	{
     echo '<p class="text--error" style="font-size: 1em;">Please Register or Login to continue...</p>'; 
	}
	elseif($quantity == 0)
	{
		     echo '<p class="text--error" style="font-size: 1em;">You must enter a quantity before you can add to cart. Try again.</p>'; 
	}
	else
	{
		$sqlstring = "SELECT * FROM orderLine WHERE order_id ='".session_id()."'";
		$queryResult = @$this->DBConnect->query($sqlstring);
		$this->productsItemID = array();

		//search the database and find the product key so that we can 
		while(($row = $queryResult->fetch_assoc())!== NULL)
		{ 
			
			//put the available ID's of the Cart into an array 
			$this->productsItemID[$row['product_id']] = array(); 
			$this->productsItemID[$row['product_id']]['product_id'] = $row['product_id']; 
		}

		//receives the quantity of the items in the cart and loops through it
			 	  
			 	$total = $this->prices[$product_id] * $quantity;

			 	/*check to see if the database has a record 
				* that specific order id if not add a new record
				*/
				$row = $queryResult->num_rows; 
				if($row == 0) //if 
				{
					$sqlString3 = "INSERT INTO orderLine (quantity,product_id,total,invoice_id,order_id) VALUES ($quantity,$product_id,$total,$this->invoiceID,'".session_id()."')";
					$queryResult3 = @$this->DBConnect->query($sqlString3);
					echo '<p class="text--success" style="font-size: 1em;">New Item added to your cart.</p>';
				}
				
				else 
				{
					if($row != 0){
					 	
					 	 if(array_key_exists($product_id, $this->productsItemID))
					 	 {
					 	 	$sqlString2 = "UPDATE orderLine SET quantity = $value WHERE product_id = $product_id AND order_id ='".session_id()."'";
 			  	 	 		$queryResult2 = @$this->DBConnect->query($sqlString2);
 			  	 	 		echo '<p class="text--success" style="font-size: 1em;">Quantity has been updated.</p>';
					 	}
					 	else
					 	{
							$sqlString3 = "INSERT INTO orderLine (quantity,product_id,total,invoice_id,order_id) VALUES ($quantity,$product_id,$total,$this->invoiceID,'".session_id()."')";
							$queryResult3 = @$this->DBConnect->query($sqlString3);
							echo '<p class="text--success" style="font-size: 1em;">Item added to your cart.</p>';
					 	}
					}//Close the if statement 	
 			  	}//Close the else statement 
			}//close main if statement 
				
		//}//close the foreach loop
				
	//}//close opening if statement 
}//close function						

//function to remove individual items from the cart 
public function deleteFromCart($lineID)
{
	$sqlString = "DELETE FROM orderLine WHERE line_id = $lineID";
	$queryResult = @$this->DBConnect->query($sqlString);
}

//function to Remove all items from the cart if user decises to create a new list
public function removeAllFromCart()
{
	$sqlString = "DELETE FROM orderLine WHERE order_id = '".session_id()."'";
	$queryResult = @$this->DBConnect->query($sqlString);
}


//function to validate the login details 
// public function login($email, $password)
// {	
// 	$this->invoiceID = mt_rand(); 
// 	//$returnValue = FALSE; 
// 	$query = "SELECT * FROM customer where email='".$email."'and password='".md5($password)."'";
// 	$queryResult = @$this->DBConnect->query($query); 
// 	while(($row = $queryResult->fetch_assoc())!== NULL){

// 		if($email == $row['email'] && $password == $row['password'])
// 		{
// 			echo '<p class="text--error" style="font-size: 1em;">Unable to find that username and password. Please register before you can shop.</p>'; 
// 			echo $row['email'];
// 		}
// 		else 
// 		{
// 			$this->customerID = $row['customer_id'];
// 			$this->customerName = $row['name'];
// 			$this->customerSurname = $row['surname'];
// 			$this->contact = $row['contact']; 
// 			$this->email = $row['email']; 
// 			$this->unitNumber = $row['unitno'];
// 			$this->street = $row['street']; 
// 			$this->city = $row['city'];
// 			$this->province = $row['province'];
// 			$this->postalCode = $row['postalCode']; 
// 			 //assign the customer id into a variable so that we can apply it to the insert statement 

			
// 			
			
// 		}
		
// 	}
		
// }
public function login($email, $password)
{
	
	$newPassword = md5($password); 
	$this->invoiceID = mt_rand(); 
	//$returnValue = FALSE; 
	$query = "SELECT * FROM customer where email='".$email."' AND password='".$newPassword."'";
	//$query = "SELECT * FROM customer where email='thabo.moopa@gmail.com' AND password='351c023bf9158d7e23464ed18115bf0a'"; 
	
			//return $returnValue = TRUE; 

	$queryResult = @$this->DBConnect->query($query); 
	while(($row = $queryResult->fetch_assoc())!== NULL){
			$this->customerID = $row['customer_id'];
			$this->customerName = $row['name'];
			$this->customerSurname = $row['surname'];
			$this->contact = $row['contact']; 
			$this->email = $row['email']; 
			$this->unitNumber = $row['unitno'];
			$this->street = $row['street']; 
			$this->city = $row['city'];
			$this->province = $row['province'];
			$this->postalCode = $row['postalCode']; 
			$this->password = $row['password'];
// 			 //assign the customer id into a variable so that we can apply it to the insert statement

			$sqlstring = "INSERT INTO invoices (customer_id,invoice_id) VALUES ($this->customerID,$this->invoiceID)";
 			$QueryResult = @$this->DBConnect->query($sqlstring); 
	} 
	if($email != $this->email && $newPassword != $this->password)
	{ 
		return $returnValue = FALSE; 
	}
	else 
		return $returnValue = TRUE; 
	
}

/* function to set the products according to category.
*  if the category is 0 then all products are displayed
*  if a category is selected the appropriate items will display on the index page
*  p590
*/
public function setProducts($categoryID) {
	if($categoryID == 0)
	{
		$SQLString = "SELECT * FROM product";
	}

	elseif($categoryID > 0)
	{
		$this->categoryID = $categoryID;
		$SQLString ="SELECT * FROM product WHERE category_id= ".$this->categoryID.""; 
	}
					$QueryResult = @$this->DBConnect->query($SQLString);
					$this->inventory = array();
					$this->shoppingCart = array();
					$this->prices = array(); 
					while (($Row = $QueryResult->fetch_assoc())!== NULL) {
					$this->inventory[$Row['product_id']]= array(); //noted
					$this->inventory[$Row['product_id']]['product_id'] = $Row['product_id']; 
					$this->inventory[$Row['product_id']]['category']= $Row['category'];
					$this->inventory[$Row['product_id']]['product_name']= $Row['product_name'];
					$this->inventory[$Row['product_id']]['description']= $Row['description'];
					$this->inventory[$Row['product_id']]['price']= $Row['price'];
					$this->inventory[$Row['product_id']]['quantity']= $Row['quantity'];
					$this->inventory[$Row['product_id']]['image']= $Row['image'];

					$this->shoppingCart[$Row['product_id']] = $Row['product_id'];
					$this->prices[$Row['product_id']] = $Row['price'];
					}
	}

//function to retrieve the products from the above function p591
public function getProducts() {
	 
if (count($this->inventory) > 0) {
	echo '<form name="quantity" action="'.$_SERVER["SCRIPT_NAME"] .'" method="POST">';

	/*loop through the cart so that we get the product id in the cart and the quantity 
	*then use the product id to obtain the quantity of the items in the next foreach loop to re-display on screen
	*/
	foreach($this->Cart as $ID => $info)
	{
		$redisplayQuantity[$info['product_id']] = $info['quantity'];
	}
 
 			echo '<table class="flat-table">';  // ">style="text-align:center;"
				echo '<tr>';  
	foreach ($this->inventory as $ID => $Info) {
		if($redisplayQuantity[$ID] == 0)
		{
			$redisplayQuantity[$ID] = 0;
		}
				echo '<td>';
				printf('<img src="'.$Info['image'].'" style="width:130px; height: 150px; "><br />');
				//echo  htmlentities($Info['product_name'])."\n";
				echo  htmlentities($Info['description'])."<br />";
				echo  "R ".htmlentities($Info['price'])."\n";
				echo '<input type="number" name="quantity['.$ID.']" min="0" max="1000" step="1" value="'.$redisplayQuantity[$ID].'">';
				echo '<input type="submit" name="submit['.$ID.']" value="Add To Cart"></td>';
				
				//holds the product id so that we can switch between categories 
				$this->shoppingCart = $ID;
				
				}
				echo '</tr>';
			echo '</table>';
echo '</form>';
$retval = TRUE;
	}
	return($retval);
	}

//function to view the items in the cart and display them on the screen 
public function viewCart()
{
	$amount=0.00;
	$totalAmount = 0.00; 
	$sqlString = "SELECT * FROM orderLine WHERE order_id = '".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
					//$this->itemID = array();
					$this->Cart = array();
					//$this->prices = array(); 
					while (($Row = $QueryResult->fetch_assoc())!== NULL) {
					$this->Cart[$Row['line_id']] = array(); 
					$this->Cart[$Row['line_id']]['line_id'] = $Row['line_id']; 
					$this->Cart[$Row['line_id']]['quantity'] = $Row['quantity']; 
					$this->Cart[$Row['line_id']]['total'] = $Row['total']; 
					$this->Cart[$Row['line_id']]['product_id'] = $Row['product_id'];
					 
					 $numbers = $Row['product_id']; 
					 //echo $numbers;
	$sqlQuery = "SELECT * FROM product WHERE product_id = $numbers "; 
	$QueryResult2 = @$this->DBConnect->query($sqlQuery);
					while (($Row2 = $QueryResult2->fetch_assoc())!== NULL) 
					{
						$this->list[$Row2['product_id']] = array();
						$this->list[$Row2['product_id']]['product_id'] = $Row2['product_id'];  
						$this->list[$Row2['product_id']]['product_name'] = $Row2['product_name']; 
						$this->list[$Row2['product_id']]['description'] = $Row2['description'];
						$this->list[$Row2['product_id']]['price'] = $Row2['price'];  
						$this->list[$Row2['product_id']]['image'] = $Row2['image'];

					/*
					* Do a combination of values from different tables 
					* put the value of name from product into the Cart with the other details
					*
					*/
					$this->Cart[$Row['line_id']]['product_name'] = $Row2['product_name'];
					$this->Cart[$Row['line_id']]['price'] = $Row2['price'];
					
					/*
					* item ID array to catch the ID's of the products in the Cart so that we can 
					* remove from the table it does not display the item on the table 
					*/
					$this->Cart[$Row['line_id']]; 
					}//Close second while loop
					
				}//Close first while loop
/*
*
* Display the items for already in the cart
*/
	if(empty($this->Cart))
	{
		echo '<p class="text--success" style="font-size: 1em;">The cart has been cleared! Return to home page or click the category links above.</p>';	
	}
	else
	{
		echo "<h2>Shopping Cart</h2>";
		echo '<form name="frmLineItems" action="'.$_SERVER["SCRIPT_NAME"] .'" method="POST">';
		echo '<table id="itemLine">';
			echo '<tr>';
				echo '<th>ID</th><th>Product Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th><th>Increase</th><th>Decrease</th><th>Action</th>'; 
					 echo '</tr>';
					 echo '<tr>';
						foreach ($this->Cart as $key => $Value) {
						echo '<td>'. htmlentities($Value['line_id']).'</td>';
						echo '<td>'. htmlentities($Value['product_name']).'</td>';
						echo '<td>'. htmlentities($Value['quantity']).'</td>';
						echo '<td>R '. htmlentities($Value['price']).'</td>';
						$amount = $Value['quantity'] * $Value['price'];
						echo '<td>R '.number_format($amount, 2, '.', ',').'</td>';
						echo '<td><input type="submit" name="increment['.htmlentities($Value['product_id']).']" value="+" class="button--pill bg--success button--xsm"></td>';
						echo '<td><input type="submit" name="decrement['.htmlentities($Value['product_id']).']" value="-" class="button--pill bg--error button--xsm"></div></td>';
						/*
						* set the name of the button to the key of the item row
						* then when isset it can delete the row
						*/
						echo "<td><input type='submit' name='delete[$key]' value='Remove Item' class='button--pill button--xsm'>";
						echo '</tr>';
						
						//Calculate the total price from the cart
						 $totalAmount +=$amount;//$Value['total']; 

						}
			echo '</table>';
			echo '<table>';
						echo '<tr><th>Total </th><td>R '.number_format(htmlentities($totalAmount), 2, '.', ' ').'</td></tr>';
			echo '</table>';
			echo '<table style="border:0;">';
						echo "<tr><input type='submit' name='Checkout' value='Checkout' class='bg--success'>&nbsp;&nbsp;&nbsp;";
						echo "<input type='submit' name='removeAll' value='Empty Cart' class='bg--muted'></tr>";
			echo '</table>';
	echo '</form>'; 
	}	
}

//function to increment the quantity of the item while updating the orderline table
public function getIncrementQuantity($increment)
{
	$quantityIncrease = 0;
	$subtotal = 0.00; 
	$newTotal = 0.0;
	$price = 0.0;
	$newQuantity = 0;  

	$sqlstring = "SELECT o.quantity, p.price, o.total FROM orderLine o JOIN product p ON p.product_id = o.product_id WHERE o.product_id = $increment AND o.order_id = '".session_id()."'";

	$queryResult = @$this->DBConnect->query($sqlstring);
	while(($row = $queryResult->fetch_assoc())!== NULL)
	{ 
		$quantityIncrease = $row['quantity'];
		$price = $row['price'];
		$subtotal = $row['total']; 
		$newTotal = $quantityIncrease * $price; 
	}

	$newQuantity = $quantityIncrease + 1;
	$sqlstring2 = "UPDATE orderLine SET quantity = $newQuantity, total = $newTotal WHERE product_id = $increment AND order_id ='".session_id()."'";
	$queryResult2 = @$this->DBConnect->query($sqlstring2); 

}

//function to Decrement the quantity of the item while updating the orderline table
public function getDecrementQuantity($decrement)
{
	$quantityIncrease = 0;
	$subtotal = 0.00; 
	$newTotal = 0.0;
	$price = 0.0;
	$newQuantity = 0;  

	$sqlstring = "SELECT o.quantity, p.price, o.total FROM orderLine o JOIN product p ON p.product_id = o.product_id WHERE o.product_id = $decrement AND o.order_id = '".session_id()."'";

	$queryResult = @$this->DBConnect->query($sqlstring);
	while(($row = $queryResult->fetch_assoc())!== NULL)
	{
		//print_r($queryResult); 
		$quantityIncrease = $row['quantity'];
		$price = $row['price'];
		$subtotal = $row['total']; 
		$newTotal = $quantityIncrease * $price; 
	}
	
	$newQuantity = $quantityIncrease - 1;
	$sqlstring2 = "UPDATE orderLine SET quantity = $newQuantity, total = $newTotal WHERE product_id = $decrement AND order_id ='".session_id()."'";
	$queryResult2 = @$this->DBConnect->query($sqlstring2); 

}

/* http://php.net/manual/en/function.time.php 22h20 01 September
*  function to automatically create an order when the user has logged in
*
*/
public function createOrderID($customerID)
{
	$sqlString = "INSERT INTO orders (order_date, customer_id, order_id) VALUES (NOW(), $customerID,'".session_id()."')"; 
	$QueryResult = @$this->DBConnect->query($sqlString);
}

//function to checkout the products in the cart p608
public function checkout()
{
	if(empty($this->Cart))
	{
		echo '<p class="text--success" style="font-size: 1em;">Your cart is empty return to home page to add new items to cart.</p>';
		 
	}
	else 
	{
	$totalAmount = 0.00;
	$adminFee = 70; 
	$tax = 0.00; 
	$grandTotal = 0.00; 

	//select all the line items in the shopping cart 
	$sqlString = "SELECT * FROM orderLine WHERE order_id = '".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
					while (($Row = $QueryResult->fetch_assoc())!== NULL) {
					$this->Cart[$Row['line_id']] = array(); 
					$this->Cart[$Row['line_id']]['line_id'] = $Row['line_id']; 
					$this->Cart[$Row['line_id']]['quantity'] = $Row['quantity']; 
					$this->Cart[$Row['line_id']]['total'] = $Row['total']; 
					$this->Cart[$Row['line_id']]['product_id'] = $Row['product_id'];
					 
					 $numbers = $Row['product_id']; 
	
	//select all the all products according to the line id 
	$sqlQuery = "SELECT * FROM product WHERE product_id = $numbers "; 
	$QueryResult2 = @$this->DBConnect->query($sqlQuery);
					while (($Row2 = $QueryResult2->fetch_assoc())!== NULL) 
					{
						$this->list[$Row2['product_id']] = array();
						$this->list[$Row2['product_id']]['product_id'] = $Row2['product_id'];  
						$this->list[$Row2['product_id']]['product_name'] = $Row2['product_name']; 
						$this->list[$Row2['product_id']]['description'] = $Row2['description'];
						$this->list[$Row2['product_id']]['price'] = $Row2['price'];  
						$this->list[$Row2['product_id']]['image'] = $Row2['image'];

					/*
					* Do a combination of values from different tables 
					* put the value of name from product into the Cart with the other details
					*
					*/
					$this->Cart[$Row['line_id']]['product_name'] = $Row2['product_name'];
					$this->Cart[$Row['line_id']]['price'] = $Row2['price'];
					
					}//Close second while loop
					
				}//Close first while loop

				foreach ($this->Cart as $key => $Value) {
					echo "<tr  style='text-align:left;'>";
					echo '<td>'. htmlentities($Value['product_name']).'</td>';
					echo '<td>'. htmlentities($Value['quantity']).'</td>';
					echo '<td>R '. number_format(htmlentities($Value['price']), 2, '.', ' ').'</td>';
					echo '<td>R '. number_format(htmlentities($Value['total']), 2, '.', ' ').'</td>';
					$totalAmount += htmlentities($Value['total']);
					echo "</tr>";

				}
				//http://php.net/manual/en/function.number-format.php  
				$vat = $totalAmount * 0.14;
				$grandTotal = $totalAmount + $vat; 
				//echo '<tr><td><b>Admin Fee</b></td><td  colspan="4"><strong>R 170</strong></td></tr>';
				echo '<tr><td><b>Vat(14%)</b></td><td  colspan="4"><strong>R '. number_format($vat, 2, '.', ' ').'</strong></td></tr>';
				echo '<tr><td><b>Total</b></td><td  colspan="4"><strong>R '. number_format($grandTotal, 2, '.', ' ').'</strong></td></tr>';
				
				return TRUE; 
	}
}

/*function to automatically insert items into the items purchased table when the checkout button is pressed */ 

public function addItemsPurchased($invoiceID)
{ 	
	$sqlString1 = "INSERT INTO ItemsPurchased (price, product_name,quantity,subtotal,invoice_id,purchase_date) 
	SELECT product.price, product.product_name,orderLine.quantity,orderLine.total,orderLine.invoice_id,orders.order_date 
	FROM product product 
	JOIN orderLine orderLine 
	ON product.product_id = orderLine.product_id 
	JOIN orders orders 
	ON orders.order_id = orderLine.order_id 
	where orderLine.invoice_id = $invoiceID 
	AND orderLine.order_id ='".session_id()."'"; 
	$QueryResult = @$this->DBConnect->query($sqlString1);
}

//function to reduce the quantity when the checkout button has been pressed 
public function reduceInventoryQuantity()
{
	$quantity = 0;
	$productID = 0; 

	$sqlString = "SELECT * FROM orderLine WHERE order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		$quantity = $row['quantity']; 
		$productID = $row['product_id'];  

		$sqlString1 = "SELECT * FROM product WHERE product_id = $productID";
		$QueryResult2 = @$this->DBConnect->query($sqlString1);
		while(($row2 = $QueryResult2->fetch_assoc())!==NULL)
		{
			$total = $row2['quantity'] - $row['quantity'];  
			
			$sqlString3 = "UPDATE product SET quantity = $total WHERE product_id = $productID";
			$QueryResult3 = @$this->DBConnect->query($sqlString3);  
		}

	}
}

//function to automatically clear the orderline table once the checkout button is pressed 
public function clearCart($invoiceID)
{
	$sqlString = "DELETE FROM orderLine WHERE invoice_id = $invoiceID AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
}

//function to display the items bought on different dates 
public function DisplayHistory($customerID)
{
	$counter = 0; 
	
	echo '<h2 class="text--primary" style="font-size: 1.3em;">History of Items purchased</h2>'; 
	$sqlString = "SELECT * FROM itemsPurchased p JOIN invoices c ON c.invoice_id = p.invoice_id
WHERE customer_id = $customerID ORDER BY p.purchase_date"; 
	$QueryResult = @$this->DBConnect->query($sqlString);
	echo '<table border="1">';
	echo '<tr>';
	echo '<th>Item Number</th><th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Purchase Date</th></tr>';
	
	$counter = $QueryResult->num_rows; 
	while (($row = $QueryResult->fetch_assoc())!== NULL) 
	{
		echo '<tr>';
		echo '<td>'.htmlentities($row['items_id']).'</td>';
		echo '<td>'.htmlentities($row['product_name']).'</td>';
		echo '<td>R '.htmlentities($row['price']).'</td>';
		echo '<td>'.htmlentities($row['quantity']).'</td>';
		echo '<td>R '.htmlentities($row['subtotal']).'</td>';
		echo '<td>'.htmlentities($row['purchase_date']).'</td>';
		echo '</tr>';
		$this->datePurchased[$row['items_id']] = array();
		$this->datePurchased[$row['items_id']] = $row['purchase_date'];	
	}
	echo '</table>';
	echo '<h2 class="text--primary" style="font-size: 1.3em;">Purchase Report</h2>';
	
	$itemsBought = 0; 
	foreach($this->datePurchased as $key => $value)
	{ 
		
		 	$sqlString1="SELECT count(*) as total from itemsPurchased p JOIN invoices c ON p.invoice_id = c.invoice_id where c.customer_id = $customerID AND p.purchase_date = '".$value."'"; 
			$QueryResult1 = @$this->DBConnect->query($sqlString1);  
		    $rows = $QueryResult1->fetch_assoc();
		    $itemsBought = $rows['total']; 
		    echo '<p class="text--success" style="font-size: 1em;">You purchased '.$itemsBought.' items on '.$value.'</p>';
	}
}
//function to retrieve customer information 
public function customerDetails($customerID)
{
	//header('Location: customerHistory.php');
	echo '<h4 class="text--error" style="font-size: 1.3em;">Personal Details</h4>';
	$query = "SELECT * FROM customer where customer_id = $customerID";
	$queryResult = @$this->DBConnect->query($query); 
	while(($row = $queryResult->fetch_assoc())!== NULL){
		$this->customer = array(); 
		$this->customer[$row['customer_id']] = array(); 
		$this->customer[$row['customer_id']]['customer_id'] = $row['customer_id'];
		$this->customer[$row['customer_id']]['name'] = $row['name'];
		$this->customer[$row['customer_id']]['surname'] = $row['surname'];
		$this->customer[$row['customer_id']]['contact'] = $row['contact'];
		$this->customer[$row['customer_id']]['email'] = $row['email'];
		$this->customer[$row['customer_id']]['unitno'] = $row['unitno'];
		$this->customer[$row['customer_id']]['street'] = $row['street'];
		$this->customer[$row['customer_id']]['city'] = $row['city'];
		$this->customer[$row['customer_id']]['province'] = $row['province'];
		$this->customer[$row['customer_id']]['postalCode'] = $row['postalCode'];
	}
	foreach($this->customer as $key =>$value)
	{
		echo "<table class='flat-table'>";
		echo "<tr style='text-align:left;'>";
			echo '<td>'. htmlentities($value['name']).'</td>';
			echo '<td>'. htmlentities($value['surname']).'</td>';
			echo '<td>'. htmlentities($value['contact']).'</td>';
			echo '<td>'. htmlentities($value['email']).'</td>';
			echo '<td>'. htmlentities($value['unitno']).'</td>';
			echo '<td>'. htmlentities($value['street']).'</td>';
			echo '<td>'. htmlentities($value['city']).'</td>';
			echo '<td>'. htmlentities($value['province']).'</td>';
			echo '<td>'. htmlentities($value['postalCode']).'</td>';
			echo "</tr>";
		echo "</table>"; 
	}	 
			 //assign the customer id into a variable so that we can apply it to the insert statement 	
}

//function to create a new customer when the user is registering 
public function createCustomer($lastName,$firstName,$email,$contact,$postalCode,$city,$houseNumber,$province,$street,$password)
{ 
	
	$query = "INSERT INTO Customer (name, surname, email, contact, unitno, street,city, province, postalcode, password) VALUES ('$firstName', '$lastName', '$email','$contact', '$houseNumber', '$street', '$city', '$province', '$postalCode','$password')";
	$queryResult = @$this->DBConnect->query($query); 
	echo '<p class="text--success">You are now registered, please login.</p>';
			
}
//function to check if whether a specific email address already exists
public function verifyEmailDoesNotExist($email)
{
	$errorFormCount = 0;
			$query = "SELECT email FROM customer";
				$queryResult = @$this->DBConnect->query($query); 
				while(($row = $queryResult->fetch_assoc())!== NULL)
				{
					if($email == $row['email'])
					{
						echo '<p class="text--error>The email address already exists</p>'; 
						++$errorFormCount;
					}
				}
				return $errorFormCount;
}
/*When the unserialize() function executes, PHP looks in the
object’s class for a special function named __wakeup(), which you
can use to perform many of the same tasks as a constructor function.
p601
*/
public function logout()
{
	session_destroy(); 

	header('location: index.php'); 
}
function __wakeup() {
	include("include/inc_db_groceries.php");
	$this->DBConnect = $DBConnect;
}


}
 
?>