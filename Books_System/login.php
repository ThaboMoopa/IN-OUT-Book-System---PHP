<?php
session_start(); 
require_once('classes/class_Books.php');
if(class_exists('Books'))
{
    if(isset($_SESSION['Books']))
    {
        $Books = unserialize($_SESSION['Books']); 
    }
    else
        $Books = new Books();
}  
define('TITLE', 'Login');
include("templates/inc_header.html"); 

 if($Books->getCustomerID() > 1)
    {
      include('include/inc_categoryButtons.php');
        echo '<p>You already logged in!<span class="text--primary"> '.$Books->getCustomerName() . ' '.$Books->getCustomerSurname().'</span></p>';
        include('include/inc_personalLinks.php');
    }
    else
    {

        include("functions/inc_func_login.php"); 

        //when user press the submit button the functions are called 
        if(isset($_POST['submit']))
        {
            $email = stripslashes(trim($_POST['email'])); 
            $password = stripslashes(trim($_POST['password']));
            
            validateEmail($email,$errorFormCount);
            validatePassword($password,$errorFormCount);

            if($errorFormCount == 0)
            {
                $Books->login($email, $password); 
               echo '<h2>You are logged In <strong class="text--success">' . $Books->getCustomerName() . ' '.$Books->getCustomerSurname(). ' !</strong></h2>';
               include('include/inc_personalLinks.php');
               $Books->createOrderID($Books->getCustomerID());
               
               //$Books->DisplayHistory($Books->getCustomerID());
               $_SESSION['Books'] = serialize($Books); 
               $showForm = FALSE;

               //  //make a database connection 
               // require_once("include/inc_db_books.php");

               // $showForm = FALSE;

               // //connect to database to verify email adress and password
               // include("include/inc_sql_login.php");  
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
    if($showForm == TRUE)
    {
?>   
<h2 class="text--primary">Login</h2>
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
        <!-- <p><a href="#">Forgot your Password?</a></p>  -->

</form>
<?php
  }
}
?>
<?php include("templates/inc_footer.html"); ?>
