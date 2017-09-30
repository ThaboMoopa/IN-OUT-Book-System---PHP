<?php
if($Books->getCustomerID()>0)
{
	echo '<p class="text--right text--warning">Logged in: <a href="customerHistory.php">'.$Books->getCustomerName(). ' '. $Books->getCustomerSurname().'</a></p>'; 
	
}
?>