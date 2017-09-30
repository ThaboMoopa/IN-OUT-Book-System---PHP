<?php
class Category {
private $DBConnect = NULL;
//private $storeID = ""; char
//private $storeID=0;
private $categoryID = 0; 
private $inventory = array();
private $shoppingCart = array();


function __construct() {
	include("include/inc_db_groceries.php");
	$this->DBConnect = $DBConnect;
}
function __destruct() {
	if (!$this->DBConnect->connect_error)
	$this->DBConnect->close();
}
public function setStoreID($categoryID) {
if ($this->categoryID != $categoryID) {
	$this->categoryID = $categoryID;
	//$SQLString = "SELECT * FROM inventory". " where storeNumber = " .$this->storeID . "";
	$SQLString = "Select * FROM productDetails ". " where details_id = " .$this->categoryID . ""; 
				$QueryResult = @$this->DBConnect->query($SQLString);
				if ($QueryResult === FALSE) {
				$this->categoryID = 0;
				}
				else {
				$this->inventory = array();
				$this->shoppingCart = array();
				while (($Row = $QueryResult->fetch_assoc())!== NULL) {
				$this->inventory[$Row['details_id']]= array(); //noted
				$this->inventory[$Row['details_id']]['name']= $Row['name'];
				$this->inventory[$Row['details_id']]['description']= $Row['description'];
				$this->inventory[$Row['details_id']]['price']= $Row['price'];
				$this->inventory[$Row['details_id']]['image']= $Row['image'];
				$this->shoppingCart[$Row['details_id']]= 0;
				echo $this->inventory[$Row['details_id']]['name']= $Row['name'];
				}
			}
		}
	}

public function getProducts() {
	$retval = FALSE;
	$SQLString = "SELECT * FROM products";
	$QueryResult = @$this->DBConnect->query($SQLString);
	
	if ($QueryResult !== FALSE) {
		$retval = $QueryResult->fetch_assoc();
		
	}
}
return($retval);
}

public function getProductList() {
$retval = FALSE;
$subtotal = 0;
if (count($this->inventory) > 0) {
 
echo '<table class="flat-table">';

	foreach ($this->inventory as $ID => $Info) {

	}
	echo '</table>';

/*echo "<tr><th>Product</th><th>Description</th>" ."<th>Price Each</th><th># in Cart</th>" ."<th>Total Price</th><th>&nbsp;</th></tr>\n";
	foreach ($this->inventory as $ID => $Info) {
	echo "<tr><td>" . htmlentities($Info['image']). "</td>\n";

	echo "<td>" . htmlentities($Info['name']). "</td>\n";

	echo "<td>" .htmlentities($Info['description']) ."</td>\n";

	printf("<td class='currency'>R%.2f</td>\n", $Info['price']);

	echo "<td class='currency'>" .$this->shoppingCart[$ID] ."</td>\n";

	printf("<td class='currency'>R%.2f</td>\n", $Info['price'] * $this->shoppingCart[$ID]);

	echo "<td><a href='" .$_SERVER['SCRIPT_NAME'] ."?PHPSESSID=" . session_id() ."&ItemToAdd=$ID'>Add " ." Item</a></td>\n";

	$subtotal += ($Info['price'] * $this->shoppingCart[$ID]);
	}
		echo "<tr><td colspan='4'>Subtotal</td>\n";
		printf("<td class='currency'>R%.2f</td>\n",$subtotal);
		echo "<td>&nbsp;</td></tr>\n";
		echo "</table>";
		$retval = TRUE;*/
	}
	return($retval);
	}

public function addItem() {
	$ProdID = $_GET['ItemToAdd'];
	if (array_key_exists($ProdID, $this->shoppingCart))
		$this->shoppingCart[$ProdID] += 1;
}
function __wakeup() {
	include("include/inc_db_groceries.php");
	$this->DBConnect = $DBConnect;
}
}
?>