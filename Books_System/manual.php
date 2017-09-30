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
echo '<h1 class="text--primary">User Manual</h1>';
include('include/inc_webAppTag.php');
$_SESSION['Books'] = serialize($Books);
//include the footer
include('templates/inc_footer.html');
?>