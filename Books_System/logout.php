<?php 
session_start(); 
require_once("classes/class_Books.php");
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
	echo "<p>Class does not exist</p>"; 

//Display the Header section
define('TITLE', 'View Cart');
include("templates/inc_header.html"); 
$Books->logout(); 
$_SESSION['Books'] = serialize($Books); 

?>