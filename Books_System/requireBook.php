<?php
session_start();
require_once("classes/class_Books.php");
define('TITLE', 'Book information'); 
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



print '<h3 class="text--primary">Book Information</h3>';
		
//include("functions/inc_func_insert_book.php");
function upload_image($fileTempLocation, $fileName, $errorCountForm)
{
	global $errorImage;
	global $errorCountForm;  
	/* autoglobal for holding uploaded files
	*  
	*/
	if(empty($fileName))
	{
		$errorImage = '<p class="text--error">Please upload the book image</p>';
		++$errorCountForm;  
	}
	elseif(move_uploaded_file($fileTempLocation, "images/".$fileName)=== FALSE)
	{
		$errorImage = '<p class="text--error">Could not move the file</p>'; 
		++$errorCountForm; 
	}
	else 
	{
		chmod("images/". $fileName, 0644); 
		//$errorImage = "<p>successfully uploaded \"images/". htmlentities($fileName) ."\"</p><br />\n";
		//++$errorCountForm;  
	}
}
function author($author, $errorCountForm)
{
	global $errorAuthor;
	global $errorCountForm; 
	$validateAuthor = preg_match("/^[a-z \s]+$/i", $author); 
	if(empty($author))
	{
		$errorAuthor = '<p class="text--error">Please fill in the author of book</p>'; 
		++$errorCountForm; 
	}
	elseif(is_numeric($author))
	{
		$errorAuthor = '<p class="text--error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm; 
	}
	elseif($validateAuthor == 0)
	{
		$errorAuthor = '<p class="text--error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm;
	}
	return $validateAuthor; 
}
function title($title, $errorCountForm)
{
	global $errorTitle; 
	global $errorCountForm; 
	$validateTitle = preg_match("/^[a-z0-9& \s]+$/i", $title); 

	if(empty($title))
	{
		$errorTitle = '<p class="text--error">Please fill in the author of book</p>'; 
		++$errorCountForm; 
	}
	elseif(is_numeric($title))
	{
		$errorTitle = '<p class="text--error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm; 
	}
	elseif($validateTitle == 0)
	{
		$errorTitle = '<p class="text--error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm;
	}
	return $validateTitle;
}

function description($description, $errorCountForm)
{
	global $errorDescription; 
	global $errorCountForm; 
	if(empty($description))
	{
		$errorDescription = '<p class="text--error">Give a short description about the book.</p>';
		++$errorCountForm; 
	}
	return $description; 
}
function quantity($quantity, $errorCountForm)
{
	global $errorQuantity;
	global $errorCountForm;  
	if(empty($quantity))
	{
		$errorQuantity = '<p class="text--error">Fill in the number of books at hand.</p>'; 
		++$errorCountForm; 
	}
	elseif(!is_numeric($quantity))
	{
		$errorQuantity = '<p class="text--error">Only numeric values allowed in the field.</p>';
		++$errorCountForm;  
	}
	return $quantity; 
}
function isbnNumber($isbn, $errorCountForm)
{
	global $errorCountForm; 
	global $errorIsbnNumber;
	$validateIsbn = preg_match("/^[0-9]/", $isbn); 

	if(empty($isbn))
	{
		$errorIsbnNumber = '<p class="text--error">Please enter the isbn number. </p>'; 
		++$errorCountForm; 
	}
	elseif($validateIsbn == 0)
	{
		$errorIsbnNumber = '<p class="text--error">Only numeric values allowed in this field.</p>'; 
		++$errorCountForm; 
	}
	return $isbn; 
}

	if(isset($_POST['submit']))
	{
		// $fileSize = $_FILES['picture_file']['size']; 
		// $fileTempLocation = $_FILES['picture_file']['tmp_name']; 
		// $fileName = $_FILES['picture_file']['name'];
		// $imageLink = "images/".$fileName;
		
		$author = stripslashes(trim($_POST['author'])); 
		$title = stripslashes(trim($_POST['title'])); 
		//$description = stripslashes(trim($_POST['description']));
		//$quantity = stripslashes(trim($_POST['quantity'])); 
		$isbnNumber = stripslashes(trim($_POST['isbnNumber'])); 

		//upload_image($fileTempLocation, $fileName, $errorCountForm);
		author($author, $errorCountForm); 
		title($title, $errorCountForm); 
		isbnNumber($isbnNumber, $errorCountForm); 
		//description($description, $errorCountForm); 
		//quantity($quantity, $errorCountForm);  

		if($errorCountForm == 0)
		{
			$showForm = FALSE; 
			$counter = $Books->requireBook($author, $title, $isbnNumber); 
			if($counter > 0)
			{
				echo '<p class="text--success">We do have the book in store you collect it</p>';
				$Books->confirmBookRequired ($author, $title, $isbnNumber);
				$Books->viewBook();
				if(isset($_POST['confirm']))
				{
					echo "you have confirmed";
				}

				$_SESSION['Books'] = serialize($Books); 
			}
			else
				echo '<p class="text--error">Unfortunately we do not have that book to trade. Your details will be added and we will notify you once we have the book</p>'; 
			

			//include('include/inc_sql_insert.php'); 

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
?>
<p>Please provide the information of the book you require.</p>
	<form name="frmLogin" method="post" action="<?php $_SERVER["SCRIPT_NAME"]; ?>" enctype="multipart/form-data" class="form--inline">
		<table class="table--flat">
		<tr>
			<td><label for="author">Author: </label></td>
			<td><input type="text" size="50" name="author" value="<?php echo $author; ?>"></td>
			<td style="padding:0 0;"><small class="errorText"><?php echo $errorAuthor; ?></small></td>
		</tr>
		<tr>
			<td><label for="title">Title: </label></td>
			<td><input type="text" size="50" name="title" value="<?php echo $title; ?>"></td>
			<td style="padding:0 0;><small class="errorText"><?php echo $errorTitle; ?></small></td>
		</tr> 
		<tr>
			<td><label for="isbnNumber">ISBN Number 10: </label></td>
			<td><input type="text" size="50" name="isbnNumber" value="<?php echo $isbnNumber; ?>"></td>
			<td style="padding:0 0;"><small class="errorText"><?php echo $errorIsbnNumber; ?></small></td>
		</tr>   
		<tr> 
			<td><input type="submit" name="submit" value="Submit" class="button--pill"></td>
		</tr>
	</table>
	</form>
<?php	
}
?>
<?php include("templates/inc_footer.html"); ?>