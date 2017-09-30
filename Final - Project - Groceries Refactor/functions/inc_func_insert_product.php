<?php 
function upload_image($fileTempLocation, $fileName, $errorCountForm)
{
	global $errorImage;
	//global $errorCountForm;  
	/* autoglobal for holding uploaded files
	*  
	*/
	if($fileName == 0)
	{
		$errorImage = '<p class="text--error">Please upload the book image</p>';
		++$errorCountForm;  
	}
	elseif(move_uploaded_file($fileTempLocation, "images/" . $fileName)=== FALSE)
	{
		$errorImage = '<p class="text--error">Could not move the file</p>'; 
		++$errorCountForm; 
	}
	else 
	{
		chmod("images/" . $fileName, 0644); 
		//$errorImage = "<p>successfully uploaded \"images/". htmlentities($fileName) ."\"</p><br />\n";
		++$errorCountForm;  
	}
}
function author($author, $errorCountForm)
{
	global $errorAuthor;
	//global $errorCountForm; 
	$validateAuthor = preg_match("/^[a-z]+$/i", $author); 
	if(empty($author))
	{
		$errorAuthor = '<p class="text--error">Please fill in the author of book</p>'; 
		++$errorCountForm; 
	}
	elseif(is_numeric($author))
	{
		$errorAuthor = '<p class="text-error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm; 
	}
	elseif($validateAuthor == 0)
	{
		$errorAuthor = '<p class="text-error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm;
	}
	return $validateAuthor; 
}
function title($title, $errorCountForm)
{
	global $errorTitle; 
	//global $errorCountForm; 
	$validateTitle = preg_match("/^[a-z]+$/i", $title); 

	if(empty($title))
	{
		$errorTitle = '<p class="text--error">Please fill in the author of book</p>'; 
		++$errorCountForm; 
	}
	elseif(is_numeric($title))
	{
		$errorTitle = '<p class="text-error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm; 
	}
	elseif($validateTitle == 0)
	{
		$errorTitle = '<p class="text-error">Only alphabetical characters allowed in the field.</p>'; 
		++$errorCountForm;
	}
	return $validateTitle;
}
function price($price, $errorPrice)
{
	global $errorPrice;
	//global $errorCountForm;

	//$validatePrice = preg_match("/^[0-9]+[.0-9]{2}$/i", $price);
	/*
	*Reference: https://stackoverflow.com/questions/19251542/php-preg-match-validate-price-format
	*/

	$validatePrice = preg_match('/^\d+(?:\.\d{2})?$/', $price);  
	if(empty($price)) 
	{
		$errorPrice = '<p class="text--error">Please enter the price. </p>'; 
		++$errorCountForm; 
	}
	elseif(!is_numeric($price))
	{
		$errorPrice = '<p class="text--error">Only numeric values allowed in this field. </p>'; 
		++$errorCountForm; 
	}
	elseif(strlen($price)>99999)
	{
		$errorPrice = '<p class="text--error">Price figure is too high, verify your price.</p>';
		++$errorCountForm; 
	}
	elseif($validatePrice == 0)
	{
		$errorPrice = '<p class="text--error">Figure not approved.</p>'; 
		++$errorCountForm; 
	}
	return $validatePrice; 
	
}
function isbn($isbn, $errorCountForm)
{
	global $errorCountForm; 
	global $errorIsbnNumber; 

	if(empty($isbn))
	{
		$errorIsbnNumber = '<p class="text--error">Please enter the isbn number. </p>'; 
		++$errorCountForm; 
	}
	elseif(!is_numeric())
	{
		$errorIsbnNumber = '<p class="text--error">Only numeric values allowed in this field.</p>'; 
		++$errorCountForm; 
	}
	return $isbn; 
}
function description($desription, $errorCountForm)
{
	global $errorDescription; 
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
?>