<?php 
session_start(); 
require_once("classes/class_store.php");

if(class_exists('Store')){
    if (isset($_SESSION['Store']))
        $Store = unserialize($_SESSION['Store']);
    else {
        $Store = new Store();
        }

}
    
define('TITLE', 'Login');
include("templates/inc_header.html"); 
include("functions/inc_func_login.php");
 echo '<p class="text--right text--warning">Logged in: <a href="customerHistory.php">'.$Store->getCustomerName(). ' '. $Store->getCustomerSurname().'</a> | <a href="logout.php">Logout</a></p>';
$Store->customerDetails($Store->getCustomerID());
$Store->DisplayHistory($Store->getCustomerID());
?>
<?php include("templates/inc_footer.html"); ?>
