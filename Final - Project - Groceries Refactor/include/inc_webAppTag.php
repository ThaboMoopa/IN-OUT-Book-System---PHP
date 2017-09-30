<?php 
if($Store->getCustomerID() != 0)
{
	$Store->createOrderID($Store->getCustomerID()); //1. Starting point
	echo '<p class="text--warning" align="right"; style="font-size: 1em;">Your reference for help tag is: '.$Store->getWebAppTag().'</p>'; 
}
?>