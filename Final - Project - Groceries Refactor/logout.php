<?php 
session_start(); 
require_once("classes/class_store.php");
if(class_exists('Store'))
{
	if(isset($_SESSION['Store']))
	{
		$Store = unserialize($_SESSION['Store']);
	}
	else
		$Store = new Store();
}
else 
	echo "<p>Class does not exist</p>"; 

//Display the Header section
define('TITLE', 'Logout');
include("templates/inc_header.html"); 
$Store->logout(); 
$_SESSION['Store'] = serialize($Store); 

?>