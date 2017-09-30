<?php 
session_start(); 
require_once("classes/class_Books.php");
//include the header
include('templates/inc_header.html');

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
	echo '<p class="text--error">Class does not exist</p>';
define('TITLE', 'History Purchases');
include("functions/inc_func_login.php");
include('include/inc_showUser.php');
$Books->DisplayHistory($Books->getCustomerID());
include('include/inc_personalLinks.php');
?>
<?php include("templates/inc_footer.html"); ?>