<!--
     * User: thabomoopa
     * Date: 2017/07/21
     * Time: 18:41
     * This work is my own

     Tips: Create a log file to track the database connections
-->
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

if(isset($_POST['viewDetails']))
{
    header('location: '); 
}



//if user wants to login again a message will display
    if($Store->getCustomerID() > 0)
    {
    echo '<p class="text--primary">You are already logged in! '.$Store->getCustomerName() . ' '.$Store->getCustomerSurname().'';
    echo "<p>Click here to view your details:</p>";
    ?> 
    <form name="frmDetails" method="POST" action="customerHistory.php">
    <input type='submit' name='ViewDetails' value='Personal Details and Record History'>
    </form>
    <?php
    }
    else
    {
    //when user press the submit button the functions are called 
    if(isset($_POST['submit']))
    {
        $email = stripslashes(trim($_POST['email'])); 
        $password = stripslashes(trim($_POST['password']));
        
        validateEmail($email,$errorFormCount);
        validatePassword($password,$errorFormCount);

        if($errorFormCount == 0)
        {
           $loginStatus = $Store->login($email, $password);
           if($loginStatus == 0)
           {
            echo '<p class="text--error" style="font-size: 1em;">Unable to find that username and password. Please register before you can shop.</p>';
             $showForm = TRUE;
           } 
           else
           { 
            echo '<h2>You are logged In <strong class="text--success">' . $Store->getCustomerName() . ' '.$Store->getCustomerSurname(). ' !</strong></h2>';
           $Store->customerDetails($Store->getCustomerID());
           $Store->DisplayHistory($Store->getCustomerID());
           $_SESSION['Store'] = serialize($Store); 
           } 
           
           $showForm = FALSE;
        }
        else
        {
            $showForm = TRUE;
        }   
    }
    else
    {
            $showForm = TRUE;
    }
}
    if($showForm == TRUE)
    {
?> 
<h2>Login</h2>
<p>Fill in your email address and Password.</p> 
<form name="frmLogin" method="post" action="<?php $_SERVER["SCRIPT_NAME"]; ?>" class="form--inline">
 <table class="table--flat" >
        <tr>
            <td style="padding:0 0;"><label for="email">Email address:</label></td>
            <td><input type="text" size="30" name="email" value="<?php echo $email; ?>">
            <td style="padding:0 0;"><small class="errorText"><?php echo $errorEmail; ?></small>
            </td>
        </tr>
        <!--Text field for password-->
       <tr>
            <td style="padding:0 0;"><label for="password">Password:</label></td>
            <td><input type="password" size="30" name="password"></td>
            <td style="padding:0 0;"><small class="errorText"><?php echo $errorPassword; ?></small></td>
        </tr>
</table>
        <!--Button for submit-->
        <input type="submit" name="submit" value="Log In!" class="button--pill">
        <br />
        <br />
        <p><a href="#">Forgot your Password?</a></p> 

</form>
<?php

}
?>
<?php include("templates/inc_footer.html"); ?>
