<?php 
if($Books->getCustomerID() != 0)
{
	$Books->createOrderID($Books->getCustomerID()); //1. Starting point
	echo '<p class="text--warning" align="right"; style="font-size: 1em;">Your reference for help tag is: '.$Books->getWebAppTag().'</p>'; 
}
?>