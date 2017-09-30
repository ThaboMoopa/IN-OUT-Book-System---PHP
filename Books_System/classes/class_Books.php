<?php 

class Books{
private $DBConnect = NULL;
private $categoryID = 0;
private $shoppingCart = array(); 
private $inventory = array();
private $search = array();
private $customerID = 0; 
private $customerName = "";
private $customerSurname = "";
private $datePurchased = array(); 
private $webAppTag = "";
private $invoiceID = ""; 
private $Cart = array(); 
private $list = array(); 
private $productsItemID = array();
private $lineID = 0; 
private $prices= array(); 
private $province = ""; 
private $cellNumber = 0;
private $city = "";
private $unitNumber = 0; 
private $street = "";  
private $inventorySwap = array();
private $shoppingCartSwap = array();
private $pricesSwap = array(); 
private $bookID = 0; 

//done
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
public function setWebAppTag($webAppTag)
{
	$this->webAppTag = substr($webAppTag,0,4); 
}
public function getWebAppTag()
{
	return $this->webAppTag; 
}
public function setInvoiceID($invoiceID)
{
	$this->invoiceString = $invoiceID; 
}
public function getInvoiceID()
{
	return $this->invoiceID; 
}
public function setLineID($lineID)
{
	$this->lineID = $lineID; 
}

public function getLineID()
{
	return $this->lineID; 
}


	//done
	function __construct() {
		include("include/inc_db_books.php");
		$this->DBConnect = $DBConnect;
	}
	//done
	function __destruct() {
		if (!$this->DBConnect->connect_error)
		$this->DBConnect->close();
	}
	public function setSearch($search)
	{
		$this->search= array(); 
		$sqlString = "SELECT * FROM book WHERE title like '%$search%' OR author like '%$search%'";
		$QueryResult = @$this->DBConnect->query($sqlString);
		while (($Row = $QueryResult->fetch_assoc())!== NULL)
		{
			$this->search[$Row['book_id']]=array();
			$this->search[$Row['book_id']]['book_id'] = $Row['book_id'];
			$this->search[$Row['book_id']]['category_id']= $Row['category_id'];
			$this->search[$Row['book_id']]['title']= $Row['title'];
			$this->search[$Row['book_id']]['description']= $Row['description'];
			$this->search[$Row['book_id']]['price']= $Row['price'];
			$this->search[$Row['book_id']]['quantity']= $Row['quantity'];
			$this->search[$Row['book_id']]['image']= $Row['image'];
			$this->search[$Row['book_id']]['author']= $Row['author'];
			$this->search[$Row['book_id']]['isbn_number']= $Row['isbn_number']; 


		}
		return 1; 
	}
	public function setBooks($categoryID)
	{
		if($categoryID == 0)
		{
			$SQLString = "SELECT * FROM book WHERE price > 0";
		}
		elseif($categoryID > 0)
		{
			$this->categoryID = $categoryID; 
			$SQLString = "SELECT * FROM book WHERE category_id = $this->categoryID AND price >0";
		}
			$QueryResult = @$this->DBConnect->query($SQLString);
			$this->inventory = array();
			$this->shoppingCart = array();
			$this->prices = array(); 
			while (($Row = $QueryResult->fetch_assoc())!== NULL) {
			$this->inventory[$Row['book_id']]= array(); //noted
			$this->inventory[$Row['book_id']]['book_id'] = $Row['book_id']; 
			$this->inventory[$Row['book_id']]['category_id']= $Row['category_id'];
			$this->inventory[$Row['book_id']]['title']= $Row['title'];
			$this->inventory[$Row['book_id']]['description']= $Row['description'];
			$this->inventory[$Row['book_id']]['price']= $Row['price'];
			$this->inventory[$Row['book_id']]['quantity']= $Row['quantity'];
			$this->inventory[$Row['book_id']]['image']= $Row['image'];
			$this->inventory[$Row['book_id']]['author']= $Row['author'];
			$this->inventory[$Row['book_id']]['isbn_number']= $Row['isbn_number'];


			$this->shoppingCart[$Row['book_id']] = $Row['book_id'];
			$this->prices[$Row['book_id']] = $Row['price'];
			}


	}
	public function getBooks()
	{
		if (count($this->inventory) > 0) {
		echo '<form name="quantity" action="'.$_SERVER["SCRIPT_NAME"] .'" method="POST">';

	/*loop through the cart so that we get the product id in the cart and the quantity 
	*then use the product id to obtain the quantity of the items in the next foreach loop to re-display on screen
	*/
	// foreach($this->Cart as $ID => $info)
	// {
	// 	$redisplayQuantity[$info['book_id']] = $info['quantity'];
	// }
 
 			echo '<table class="flat-table">';  // ">style="text-align:center;"
				echo '<tr>';  
			foreach ($this->inventory as $ID => $Info) {
				// if($redisplayQuantity[$ID] == 0)
				// {
				// 	$redisplayQuantity[$ID] = 0;
				// }
				echo '<td>';
				printf('<img src="'.$Info['image'].'" style="width:130px; height: 150px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);"><br />');
				echo  '<span class="text--primary">'.htmlentities($Info['title'])."</span><br />";
				echo  htmlentities($Info['description'])."<br />";
				echo  '<span class="text--error"> R '.htmlentities($Info['price'])."</span>";
				echo '<input type="number" name="quantity['.$ID.']" min="0" max="1000" step="1" value="'.$redisplayQuantity[$ID].'"/>';
				//echo '<input  type="submit" name="submit['.$ID.']" value="Add To Cart">';
				echo '<button class="button button--bordered border--success" name="submit['.$ID.']" value="Add To Cart">Add to cart</button></td>';
				//holds the product id so that we can switch between categories 
				$this->shoppingCart = $ID;
				
				}
					echo '</tr>';
				echo '</table>';
			echo '</form>';
		 }
	}
	public function getSearch()
	{
		echo "<pre>"; 
		print_r($this->search);
		echo "</pre>";
	}
	public function createOrderID($customerID)
	{
		$customerID; 
	$sqlString = "INSERT INTO orders (order_date, customer_id, order_id) VALUES (NOW(), $customerID,'".session_id()."')"; 
	$QueryResult = @$this->DBConnect->query($sqlString);
	}
public function login($email, $password)
{	
	$this->invoiceID = mt_rand(); 
	$returnValue = FALSE; 
	$query = "SELECT * FROM customer where email='".$email."'and password='".md5($password)."'";
	$queryResult = @$this->DBConnect->query($query); 
	while(($row = $queryResult->fetch_assoc())!== NULL){
		if($email != $row['email'] && $password != $row['password'])
		{
			echo '<p class="text--error" style="font-size: 1em;">Unable to find that username and password. Please register before you can shop.</p>';
		}
		else 
		{
			$this->customerID = $row['customer_id'];
			$this->customerName = $row['name'];
			$this->customerSurname = $row['surname'];
			$this->contact = $row['contact']; 
			$this->email = $row['email']; 
			$this->unitNumber = $row['unitno'];
			$this->street = $row['street']; 
			$this->city = $row['city'];
			$this->province = $row['province'];
			$this->postalCode = $row['postalcode']; 
			 //assign the customer id into a variable so that we can apply it to the insert statement 

			
			$sqlstring = "INSERT INTO invoices (customer_id,invoice_id) VALUES ($this->customerID,$this->invoiceID)";
			$QueryResult = @$this->DBConnect->query($sqlstring);
			$sqlString = "INSERT INTO swap (customer_id,invoice_id, order_id) VALUES ($this->customerID, $this->invoiceID,'".session_id()."')"; 
			return $returnValue = TRUE; 
		}
	}
}
public function customerDetails($customerID)
{
	//header('Location: customerHistory.php');
	// echo '<h4 class="text--error" style="font-size: 1.3em;">Personal Details</h4>';
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
		$this->customer[$row['customer_id']]['postalcode'] = $row['postalcode'];
	}
	echo '<form name="frmEdit" action="editPersonalDetails.php" method="post">'; 
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
			echo '<td>'. htmlentities($value['postalcode']).'</td>';
			echo '<td><button name="edit">Edit details</button></td>'; 
			echo "</tr>";
		echo "</table>"; 
	}	 
	echo '</form>'; 
			 //assign the customer id into a variable so that we can apply it to the insert statement 	
}
public function DisplayHistory($customerID)
{
	$counter = 0; 
	
	echo '<h2 class="text--primary" style="font-size: 1.3em;">History of Items purchased</h2>'; 
	$sqlString = "SELECT * FROM items_purchased p JOIN invoices c ON c.invoice_id = p.invoice_id
WHERE customer_id = $customerID ORDER BY p.purchase_date"; 
	$QueryResult = @$this->DBConnect->query($sqlString);
	echo '<table border="1">';
	echo '<tr>';
	echo '<th>Item Number</th><th>Book Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Purchase Date</th><th>Invoice No.</th></tr>';
	
	$counter = $QueryResult->num_rows; 
	while (($row = $QueryResult->fetch_assoc())!== NULL) 
	{
		echo '<tr>';
		echo '<td>'.htmlentities($row['item_id']).'</td>';
		echo '<td>'.htmlentities($row['title']).'</td>';
		echo '<td>R '.htmlentities($row['price']).'</td>';
		echo '<td>'.htmlentities($row['quantity']).'</td>';
		echo '<td>R'.htmlentities($row['subtotal']).'</td>';
		echo '<td>'.htmlentities($row['purchase_date']).'</td>';
		echo '<td>'.htmlentities($row['invoice_id']).'</td>';
		echo '</tr>';
		$this->datePurchased[$row['item_id']] = array();
		$this->datePurchased[$row['item_id']] = $row['purchase_date'];	
	}
	echo '</table>';
	echo '<h2 class="text--primary" style="font-size: 1.3em;">Purchase Report</h2>';
	
	$itemsBought = 0; 
	foreach($this->datePurchased as $key => $value)
	{ 
		
		 	$sqlString1="SELECT count(*) as total from items_purchased p JOIN invoices c ON p.invoice_id = c.invoice_id where c.customer_id = $customerID AND p.purchase_date = '".$value."'"; 
			$QueryResult1 = @$this->DBConnect->query($sqlString1);  
		    $rows = $QueryResult1->fetch_assoc();
		    $itemsBought = $rows['total']; 
		    echo '<p>You purchased <span class="text--primary" style="font-size: 1em;">'.$itemsBought.'</span> item(s) on <span class="text--primary">'.$value.'</span>.</p>';
	}
}
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
					$this->Cart[$Row['line_id']]['book_id'] = $Row['book_id'];
					 
					 $numbers = $Row['book_id']; 
					 //echo $numbers;
	$sqlQuery = "SELECT * FROM book WHERE book_id = $numbers "; 
	$QueryResult2 = @$this->DBConnect->query($sqlQuery);
					while (($Row2 = $QueryResult2->fetch_assoc())!== NULL) 
					{
						$this->list[$Row2['book_id']] = array();
						$this->list[$Row2['book_id']]['book_id'] = $Row2['book_id'];  
						$this->list[$Row2['book_id']]['title'] = $Row2['title']; 
						$this->list[$Row2['book_id']]['description'] = $Row2['description'];
						$this->list[$Row2['book_id']]['price'] = $Row2['price'];  
						$this->list[$Row2['book_id']]['image'] = $Row2['image'];

					/*
					* Do a combination of values from different tables 
					* put the value of name from product into the Cart with the other details
					*
					*/
					$this->Cart[$Row['line_id']]['title'] = $Row2['title'];
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
		echo '<p class="text--primary" style="font-size: 1em;">The cart has been cleared! Return to home page or click the category links above.</p>';	
	}
	else
	{
		echo "<h2>Shopping Cart</h2>";
		echo '<form name="frmLineItems" action="'.$_SERVER["SCRIPT_NAME"] .'" method="POST">';
		echo '<table id="itemLine">';
			echo '<tr>';
				echo '<th>ID</th><th>Book Name</th><th>Quantity</th><th>Price</th><th>Subtotal</th><th>Increase</th><th>Decrease</th><th>Action</th>'; 
					 echo '</tr>';
					 echo '<tr>';
					 	
						foreach ($this->Cart as $key => $Value) {
						echo '<td>'. htmlentities($Value['line_id']).'</td>';
						echo '<td>'. htmlentities($Value['title']).'</td>';
						echo '<td>'. htmlentities($Value['quantity']).'</td>';
						echo '<td>R '. htmlentities($Value['price']).'</td>';
						$amount = $Value['quantity'] * $Value['price'];
						echo '<td>R '.$amount.'</td>';
						echo '<td><input type="submit" name="increment['.htmlentities($Value['book_id']).']" value="+" class="button--pill bg--success button--xsm"></td>';
						echo '<td><input type="submit" name="decrement['.htmlentities($Value['book_id']).']" value="-" class="button--pill bg--error button--xsm"></div></td>';
						/*
						* set the name of the button to the key of the item row
						* then when isset it can delete the row
						*/
						echo "<td><input type='submit' name='delete[$key]' value='Remove Item' class='button--pill button--xsm'>";
						echo '</tr>';
						
						 //$amount = $Value['quantity'] * $Value['price'];
						//Calculate the total price from the cart
						 $totalAmount +=$amount;//$Value['total']; 
						}
			echo '</table>';
			echo '<table>';
						echo '<tr><th>Total </th><td>R '.htmlentities($totalAmount).'</td></tr>';
			echo '</table>';
			echo '<table style="border:0;">';
						echo "<tr><input type='submit' name='Checkout' value='Checkout' class='bg--success'>&nbsp;&nbsp;&nbsp;";
						echo ''; 
						echo "<input type='submit' name='removeAll' value='Empty Cart' class='bg--muted'></tr>";
			echo '</table>';
	echo '</form>'; 
	}	
}
public function addToCart($quantity,$book_id)
{
	$quantity; 
	//echo "<p>in function:". $book_id."</p>"; 
	$sessionID = session_id();
	$price = 0.00; 
	//$book_id = 0; 
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
			$this->productsItemID[$row['book_id']] = array(); 
			$this->productsItemID[$row['book_id']]['book_id'] = $row['book_id']; 
		}

		//receives the quantity of the items in the cart and loops through it
			 	  
			 	$total = $this->prices[$book_id] * $quantity;

			 	/*check to see if the database has a record 
				* that specific order id if not add a new record
				*/
				$row = $queryResult->num_rows; 
				if($row == 0) //if 
				{
					$sqlString3 = "INSERT INTO orderLine (quantity,book_id,total,invoice_id,order_id) VALUES ($quantity,$book_id,$total,$this->invoiceID,'".session_id()."')";
					$queryResult3 = @$this->DBConnect->query($sqlString3);
					echo '<p class="text--success" style="font-size: 1em;">New Item added to your cart.</p>';
				}
				
				else 
				{
					if($row != 0){
					 	
					 	 if(array_key_exists($book_id, $this->productsItemID))
					 	 {
					 	 	$sqlString2 = "UPDATE orderLine SET quantity = $value WHERE book_id = $book_id AND order_id ='".session_id()."'";
 			  	 	 		$queryResult2 = @$this->DBConnect->query($sqlString2);
 			  	 	 		echo '<p class="text--success" style="font-size: 1em;">Quantity has been updated.</p>';
					 	}
					 	else
					 	{
							$sqlString3 = "INSERT INTO orderLine (quantity,book_id,total,invoice_id,order_id) VALUES ($quantity,$book_id,$total,$this->invoiceID,'".session_id()."')";
							$queryResult3 = @$this->DBConnect->query($sqlString3);
							echo '<p class="text--success" style="font-size: 1em;">Item added to your cart.</p>';
					 	}
					}//Close the if statement 	
 			  	}//Close the else statement 
			}//close main if statement 
				
		//}//close the foreach loop
				
	//}//close opening if statement 
}//close function
public function checkItemInOrderLine($bookID)
{

	$keyExists = 0; 
	$sqlString = "SELECT * FROM orderLine WHERE book_id = $bookID AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		echo "existing key".$keyExists = $row['book_id']; 
	}
	if($keyExists == $book_id)
	{
		return 1;
	}
	else 
		return 0;
	
	
}
public function checkQuantity($bookID)
{
	$quantity = 0; 
	$sqlQuantityCheck = "SELECT quantity FROM book WHERE book_id = $bookID";
	$queryResult = @$this->DBConnect->query($sqlQuantityCheck);
	 while(($row = $queryResult->fetch_assoc())!== NULL)
	 {
	 	$quantity = $row['quantity']; 
	 }

	return $quantity; 
}
public function buttonKey($buttonKey)
{
	return $buttonKey; 
}
public function deleteFromCart($lineID)
{
	$sqlString = "DELETE FROM orderLine WHERE line_id = $lineID";
	$queryResult = @$this->DBConnect->query($sqlString);
}
public function addItemsPurchased($invoiceID)
{ 	
	$sqlString1 = "INSERT INTO items_purchased (price, title,quantity,subtotal,invoice_id,purchase_date) 
	SELECT book.price, book.title,orderLine.quantity,orderLine.total,orderLine.invoice_id,orders.order_date 
	FROM book book 
	JOIN orderLine orderLine 
	ON book.book_id = orderLine.book_id 
	JOIN orders orders 
	ON orders.order_id = orderLine.order_id 
	where orderLine.invoice_id = $invoiceID 
	AND orderLine.order_id ='".session_id()."'"; 
	$QueryResult = @$this->DBConnect->query($sqlString1);
}

public function incrementCheckLine($bookID)
{
	$quantity = 0; 
	$sqlString = "SELECT * FROM orderLine WHERE book_id = $bookID AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		$quantity = $row['quantity']; 
	}
	return $quantity; 
}
public function getIncrementQuantity($increment)
{
	$quantityIncrease = 0;
	$subtotal = 0.00; 
	$newTotal = 0.0;
	$price = 0.0;
	$newQuantity = 0;  

	$sqlstring = "SELECT o.quantity, p.price, o.total FROM orderLine o JOIN book p ON p.book_id = o.book_id WHERE o.book_id = $increment AND o.order_id = '".session_id()."'";

	$queryResult = @$this->DBConnect->query($sqlstring);
	while(($row = $queryResult->fetch_assoc())!== NULL)
	{ 
		$quantityIncrease = $row['quantity'];
		$price = $row['price'];
		$subtotal = $row['total']; 
		$newTotal = $quantityIncrease * $price; 
	}

	$newQuantity = $quantityIncrease + 1;
	$sqlstring2 = "UPDATE orderLine SET quantity = $newQuantity, total = $newTotal WHERE book_id = $increment AND order_id ='".session_id()."'";
	$queryResult2 = @$this->DBConnect->query($sqlstring2); 

}
public function getDecrementQuantity($decrement)
{
	$quantityIncrease = 0;
	$subtotal = 0.00; 
	$newTotal = 0.0;
	$price = 0.0;
	$newQuantity = 0;  

	$sqlstring = "SELECT o.quantity, p.price, o.total FROM orderLine o JOIN book p ON p.book_id = o.book_id WHERE o.book_id = $decrement AND o.order_id = '".session_id()."'";

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
	$sqlstring2 = "UPDATE orderLine SET quantity = $newQuantity, total = $newTotal WHERE book_id = $decrement AND order_id ='".session_id()."'";
	$queryResult2 = @$this->DBConnect->query($sqlstring2); 

}
public function validateCart()
{
	$retValue = FALSE; 
	if(empty($this->Cart))
	{
		echo '<p class="text--error" style="font-size: 1em;">The cart is empty please return to home page to select new items.</p>';
	}
	return $retValue; 
}
	function __wakeup() {
	include("include/inc_db_books.php");
	$this->DBConnect = $DBConnect;
}
public function reduceInventoryQuantity()
{
	$quantity = 0;
	$bookID = 0; 

	$sqlString = "SELECT * FROM orderLine WHERE order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
	while(($row = $QueryResult->fetch_assoc())!==NULL)
	{
		$quantity = $row['quantity']; 
		$bookID = $row['book_id'];  

		$sqlString1 = "SELECT * FROM book WHERE book_id = $bookID";
		$QueryResult2 = @$this->DBConnect->query($sqlString1);
		while(($row2 = $QueryResult2->fetch_assoc())!==NULL)
		{
			$total = $row2['quantity'] - $row['quantity'];  
			
			$sqlString3 = "UPDATE book SET quantity = $total WHERE book_id = $bookID";
			$QueryResult3 = @$this->DBConnect->query($sqlString3);  
		}

	}
}
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
					$this->Cart[$Row['line_id']]['book_id'] = $Row['book_id'];
					 
					 $numbers = $Row['book_id']; 
	
	//select all the all products according to the line id 
	$sqlQuery = "SELECT * FROM book WHERE book_id = $numbers "; 
	$QueryResult2 = @$this->DBConnect->query($sqlQuery);
					while (($Row2 = $QueryResult2->fetch_assoc())!== NULL) 
					{
						$this->list[$Row2['book_id']] = array();
						$this->list[$Row2['book_id']]['book_id'] = $Row2['book_id'];  
						$this->list[$Row2['book_id']]['title'] = $Row2['title']; 
						$this->list[$Row2['book_id']]['description'] = $Row2['description'];
						$this->list[$Row2['book_id']]['price'] = $Row2['price'];  
						$this->list[$Row2['book_id']]['image'] = $Row2['image'];

					/*
					* Do a combination of values from different tables 
					* put the value of name from product into the Cart with the other details
					*
					*/
					$this->Cart[$Row['line_id']]['title'] = $Row2['title'];
					$this->Cart[$Row['line_id']]['price'] = $Row2['price'];
					
					}//Close second while loop
					
				}//Close first while loop

				foreach ($this->Cart as $key => $Value) {
					echo "<tr  style='text-align:left;'>";
					echo '<td>'. htmlentities($Value['title']).'</td>';
					echo '<td>'. htmlentities($Value['quantity']).'</td>';
					echo '<td>R '. htmlentities($Value['price']).'</td>';
					echo '<td>R '. htmlentities($Value['total']).'</td>'; 
					$totalAmount += htmlentities($Value['total']);
					echo "</tr>";

				}
				$adminFee = $totalAmount + 170;
				// $delieveryFee = $adminFee + 160;  
				$vat = $adminFee * 0.14;
				$grandTotal = $totalAmount + $vat + $adminFee; 
				echo '<tr><td><b>Admin Fee</b></td><td  colspan="4"><strong>R 170</strong></td></tr>';
				echo '<tr><td><b>Vat(14%)</b></td><td  colspan="4"><strong>R '. $vat.'</strong></td></tr>';
				echo '<tr><td><b>Total</b></td><td  colspan="4"><strong>R '. $grandTotal.'</strong></td></tr>';
				return TRUE; 
	}
}
public function clearCart($invoiceID)
{
	$sqlString = "DELETE FROM orderLine WHERE invoice_id = $invoiceID AND order_id ='".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
}
public function logout()
{
	session_destroy(); 

	header('location: index.php'); 
}
public function updatePersonalDetails($customerID, $firstName,$lastName,$email, $password,$contact,$postalCode,$city,$houseNumber,$province,$street)
{
	
	$sqlString = "UPDATE customer SET name = '$firstName', surname = '$lastName', email = '$email', contact = '$contact', unitno = '$houseNumber', street = '$street', city = '$city', province = '$province', postalcode = '$postalCode' WHERE customer_id = $customerID";
	$QueryResult = @$this->DBConnect->query($sqlString);
	return 1; 
}
// public function setSwapBooks($categoryID)
// {
// 		if($categoryID == 0)
// 		{
// 			$SQLString = "SELECT * FROM book WHERE price = 0";
// 		}
// 		elseif($categoryID > 0)
// 		{
// 			$this->categoryID = $categoryID; 
// 			$SQLString = "SELECT * FROM book WHERE category_id = $this->categoryID AND price = 0";
// 		}
// 			$QueryResult = @$this->DBConnect->query($SQLString);
// 			$this->inventorySwap = array();
// 			$this->shoppingCartSwap = array();
// 			$this->pricesSwap = array(); 
// 			while (($Row = $QueryResult->fetch_assoc())!== NULL) {
// 			$this->inventorySwap[$Row['book_id']]= array(); //noted
// 			$this->inventorySwap[$Row['book_id']]['book_id'] = $Row['book_id']; 
// 			$this->inventorySwap[$Row['book_id']]['category_id']= $Row['category_id'];
// 			$this->inventorySwap[$Row['book_id']]['title']= $Row['title'];
// 			$this->inventorySwap[$Row['book_id']]['description']= $Row['description'];
// 			$this->inventorySwap[$Row['book_id']]['price']= $Row['price'];
// 			$this->inventorySwap[$Row['book_id']]['quantity']= $Row['quantity'];
// 			$this->inventorySwap[$Row['book_id']]['image']= $Row['image'];
// 			$this->inventorySwap[$Row['book_id']]['author']= $Row['author'];
// 			$this->inventorySwap[$Row['book_id']]['isbn_number']= $Row['isbn_number'];


// 			$this->shoppingCartSwap[$Row['book_id']] = $Row['book_id'];
// 			$this->pricesSwap[$Row['book_id']] = $Row['price'];
// 			}
// 	}
// 

public function removeAllFromCart()
{
	$sqlString = "DELETE FROM orderLine WHERE order_id = '".session_id()."'";
	$queryResult = @$this->DBConnect->query($sqlString);
}

public function requireBook($title, $isbnNumber, $author)
{
	$sqlString = "SELECT * FROM book WHERE title like '%$title%' OR isbn_number like '%$isbnNumber%' OR author like '%$autor%' AND price = 0";
	$queryResult = @$this->DBConnect->query($sqlString);
	$counter = $queryResult->num_rows;
	if($counter > 0)
	{
		return 1; 
	}
	else 
		return 0;  

}
public function insertBook($title,$author,$isbnNumber, $imageLink, $quantity, $description){
	$sqlString = "INSERT INTO book (title,author,isbn_number,description,quantity, image, category_id, price) Values ('$title','$author',$isbnNumber, '$description', '$quantity','$imageLink',0,0)"; 
	$queryResult = @$this->DBConnect->query($sqlString);
	$this->bookID = @$this->DBConnect->insert_id;
	return $this->bookID; 

}
public function createSwapAccount($customerID)
{
	$sqlString = "INSERT INTO swap(customer_id, invoice_id, order_id) VALUES ($customerID, $this->invoiceID,'".session_id()."')";
	$queryResult = @$this->DBConnect->query($sqlString);
	$this->swapID = @$this->DBConnect->insert_id;
	return $this->swapID;  
}
public function createSwapBookAccount()
{
	$sqlString = "INSERT INTO swapBook(book_id, price, swap_id) VALUES ($this->bookID, 0, $this->swapID)";
	$queryResult = @$this->DBConnect->query($sqlString);
}
public function confirmBookRequired($title,$author,$isbnNumber)
{
	$sqlString = "SELECT * FROM book WHERE price = 0 AND (title='$title' OR isbn_number='$isbnNumber' OR author='$autor')";  
	$queryResult = @$this->DBConnect->query($sqlString);
	$this->Cart = array();
	while (($Row = $queryResult->fetch_assoc())!== NULL) {
			$this->Cart[$Row['book_id']]= array(); //noted
			$this->Cart[$Row['book_id']]['book_id'] = $Row['book_id']; 
			$this->Cart[$Row['book_id']]['category_id']= $Row['category_id'];
			$this->Cart[$Row['book_id']]['title']= $Row['title'];
			$this->Cart[$Row['book_id']]['description']= $Row['description'];
			$this->Cart[$Row['book_id']]['price']= $Row['price'];
			$this->Cart[$Row['book_id']]['quantity']= $Row['quantity'];
			$this->Cart[$Row['book_id']]['image']= $Row['image'];
			$this->Cart[$Row['book_id']]['author']= $Row['author'];
			$this->Cart[$Row['book_id']]['isbn_number']= $Row['isbn_number'];
			$this->shoppingCart[$Row['book_id']] = $Row['book_id'];
		}
		
}
public function viewBook()
{
		if (count($this->Cart) > 0) {
		echo '<form name="quantity" action="checkoutSwap.php" method="POST">';

	/*loop through the cart so that we get the product id in the cart and the quantity 
	*then use the product id to obtain the quantity of the items in the next foreach loop to re-display on screen
	*/
	// foreach($this->Cart as $ID => $info)
	// {
	// 	$redisplayQuantity[$info['book_id']] = $info['quantity'];
	// }
 
 			echo '<table class="flat-table">';  // ">style="text-align:center;"
				echo '<tr>';  
			foreach ($this->Cart as $ID => $Info) {
				// if($redisplayQuantity[$ID] == 0)
				// {
				// 	$redisplayQuantity[$ID] = 0;
				// }
				echo '<td>';
				printf('<img src="'.$Info['image'].'" style="width:130px; height: 150px; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);" ><br />');
				echo  '<span class="text--primary">'.htmlentities($Info['title'])."</span><br />";
				echo  htmlentities($Info['description'])."<br />";
				echo  '<span class="text--primary">ISBN10: '.htmlentities($Info['isbn_number'])."</span><br />";
				//echo  '<span class="text--error"> R '.htmlentities($Info['price'])."</span><br />";
				//echo '<input type="number" name="quantity['.$ID.']" min="0" max="1000" step="1" value="'.$redisplayQuantity[$ID].'"/>';
				//echo '<input  type="submit" name="submit['.$ID.']" value="Add To Cart">';
				echo '<button class="button button--bordered border--success" name="confirm['.$ID.']" value="Add To Cart">Confirm Book</button></td>';
				//holds the product id so that we can switch between categories 
				$this->shoppingCart = $ID;
				
				}
					echo '</tr>';
				echo '</table>';
			echo '</form>';
		 }
	} 
public function checkoutSwap()
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
	$title = ""; 
	//select all the line items in the shopping cart 
	$sqlString = "SELECT * FROM Swap WHERE customer_id = $this->customerID AND order_id = '".session_id()."'";
	$QueryResult = @$this->DBConnect->query($sqlString);
					while (($Row = $QueryResult->fetch_assoc())!== NULL) {
					$this->Cart[$Row['swap_id']] = array(); 
					$this->Cart[$Row['swap_id']]['swap_id'] = $Row['swap_id']; 
					$this->Cart[$Row['swap_id']]['quantity'] = $Row['quantity']; 
					$this->Cart[$Row['swap_id']]['total'] = $Row['total']; 
					$this->Cart[$Row['swap_id']]['book_id'] = $Row['book_id'];
					 
					 $numbers = $Row['swap_id']; 
	
	//select all the all products according to the line id 
	$sqlQuery = "SELECT * FROM book WHERE book_id = $numbers "; 
	$QueryResult2 = @$this->DBConnect->query($sqlQuery);
					while (($Row2 = $QueryResult2->fetch_assoc())!== NULL) 
					{
						$this->list[$Row2['book_id']] = array();
						$this->list[$Row2['book_id']]['book_id'] = $Row2['book_id'];  
						$this->list[$Row2['book_id']]['title'] = $Row2['title']; 
						$this->list[$Row2['book_id']]['description'] = $Row2['description'];
						$this->list[$Row2['book_id']]['price'] = $Row2['price'];  
						$this->list[$Row2['book_id']]['image'] = $Row2['image'];

					/*
					* Do a combination of values from different tables 
					* put the value of name from product into the Cart with the other details
					*
					*/
					$this->Cart[$Row['line_id']]['title'] = $Row2['title'];
					$this->Cart[$Row['line_id']]['price'] = $Row2['price'];
					
					}//Close second while loop
					
				}//Close first while loop

				foreach ($this->Cart as $key => $Value) {
					echo "<tr  style='text-align:left;'>";
					echo '<td>'. htmlentities($Value['title']).'</td>';
					$title = htmlentities($Value['title']);
					//echo '<td>'. htmlentities($Value['quantity']).'</td>';
					echo '<td>R '. htmlentities($Value['price']).'</td>';
					//echo '<td>R '. htmlentities($Value['total']).'</td>'; 
					$totalAmount += htmlentities($Value['total']);
					echo "</tr>";

				}
				$adminFee = $totalAmount + 170;
				// $delieveryFee = $adminFee + 160;  
				$vat = $adminFee * 0.14;
				$grandTotal = $totalAmount + $vat + $adminFee; 
				echo '<tr><td><b>Admin Fee</b></td><td  colspan="4"><strong>R 170</strong></td></tr>';
				echo '<tr><td><b>Vat(14%)</b></td><td  colspan="4"><strong>R '. $vat.'</strong></td></tr>';
				echo '<tr><td><b>Total</b></td><td  colspan="4"><strong>R '. $grandTotal.'</strong></td></tr>';
				return TRUE; 
				$sqlString = "INSERT INTO items_swapped (invoiceID, purchase_date, title, total) VALUES ($this->invoiceID, NOW(), '$title', $grandTotal)";
				$queryResult = @$this->DBConnect->query($sqlString); 
	}
}
}
?>
