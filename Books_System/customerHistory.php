<?php 
session_start(); 
require_once("classes/class_Books.php");

if(class_exists('Books')){
    if (isset($_SESSION['Books']))
        $Books = unserialize($_SESSION['Books']);
    else {
        $Books = new Books();
        }

}
    
define('TITLE', 'Login');
include("templates/inc_header.html"); 
include("functions/inc_func_login.php");
echo '<h2>Account Holder:  <strong class="text--success">' . $Books->getCustomerName() . ' '.$Books->getCustomerSurname(). ' !</strong></h2>';
include('include/inc_personalLinks.php');
$_SESSION['Books'] = serialize($Books);
// $Books->customerDetails($Books->getCustomerID());
// 
?>
<?php include("templates/inc_footer.html"); ?>
