<?php 
session_start(); 
require_once("classes/class_Books.php");
//include the header
 $categoryID = 0;
if(class_exists('Books'))
{
	if(isset($_SESSION['Books']))
	{
		$Books = unserialize($_SESSION['Books']);
	}
	else
	 	$Books = new Books();
}
define('TITLE', 'Customer Details');
include("templates/inc_header.html");
include('include/inc_showUser.php');
if(isset($_POST['edit']))
{
	header('location: editPersonalDetails.php'); 
}
print '<h2 class="text--primary">Personal Details</h2>
	   <p>The table below displays your details</p>'; 
	$Books->customerDetails($Books->getCustomerID());
	include('include/inc_personalLinks.php');
	$_SESSION['Books'] = serialize($Books); 
	   //include the footer
		include('templates/inc_footer.html');?>