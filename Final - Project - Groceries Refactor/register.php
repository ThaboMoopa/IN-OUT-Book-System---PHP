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

define('TITLE', 'Register');
include("templates/inc_header.html"); 

print ' <h2 class="text--primary">Register Form</h2>
		<p>Fill in the below information</p>';
include('functions/inc_func_register.php'); 

		if(isset($_POST['submit']))
		{
			global $errorFormCount;
			$lastName = stripslashes(trim($_POST['lastName']));
			$firstName = stripslashes(trim($_POST['firstName']));
			$email = stripslashes(trim($_POST['email'])); 
			$confirmPassword = stripslashes(trim($_POST['confirmPassword'])); 
			$password = stripslashes(trim($_POST['password']));
			$contact = stripslashes(trim($_POST['contact']));
			$postalCode = stripslashes(trim($_POST['postalCode']));
			$city = stripslashes(trim($_POST['city']));
			$houseNumber = stripslashes(trim($_POST['houseNumber']));
			$province = stripslashes(trim($_POST['province']));
			$street = stripslashes(trim($_POST['street']));  

			validateLastName($lastName,$errorFormCount); 
			validateFirstName($firstName,$errorFormCount);
			validateEmail($email,$errorFormCount); 
			validateConfirmPassword($password, $confirmPassword,$errorFormCount);
			validateContact($contact,$errorFormCount); 
			validatePostalCode($postalCode,$errorFormCount);
			validateCity ($city,$errorFormCount); 
			validateHouseNumber($houseNumber,$errorFormCount); 
			validateProvince($province,$errorFormCount);
			validateStreet($street,$errorFormCount);
			
			//global $errorFormCount; //error counter to count the number of error to prevent sending data to database before the form is fully completed. p467 
			
				
			//if not error counted during filling in the form the data can be sent to the database table
			if($errorFormCount == 0)
			{
				//require_once
				//include('include/inc_db_books.php'); //include the database connection

				$verifyEmail = $Store->verifyEmailDoesNotExist($email);

				 if($verifyEmail == 0)
				 {
					$Store->createCustomer($lastName,$firstName,$email,$contact,$postalCode,$city,$houseNumber,$province,$street,md5($password)); 
				 }
				 else{

						$errorEmail = '<p class="text--error">This email address already exists.</p>';
				}
				$_SESSION['Store'] = serialize($Store);

				$showForm = FALSE; //after the data has been sent to the table the form will not be displayed
				
				//include('include/inc_sql_register.php'); //include the sql statements to send data to database	
			}
			else 
			{
				$showForm = TRUE; //if the form has errors it will be re-displayed
			}  
		}
		else
		{
			$showForm = TRUE; //the script will determine if to display the form or not
		}
	if($showForm == TRUE)
	{
		/*
		* Displaying the error messages next to the field used the <small class="errorText">
		* reference: https://stackoverflow.com/questions/17804559/display-error-messages-below-fields
		*/
	?>
	<form name="frmLogin" method="post" action="<?php $_SERVER["SCRIPT_NAME"]; ?>" class="form--inline">
 		<table class="table--flat">
 			<tr>
 				<td><label for="firstName">First Name: </label></td>
 				<td><input type="text" size="30" name="firstName" value="<?php echo $firstName; ?>"></td>
 				<td><small class="errorText"><?php echo $errorFirstName; ?></small>
 			</tr>
 			<tr>
 				<td><label for="lastName">Last Name: </label></td>
 				<td><input type="text" size="30" name="lastName" value="<?php echo $lastName; ?>">
 				<td><small class="errorText"><?php echo $errorLastName; ?></small>
 			</tr>
 			<tr>
 				<td><label for="email">Email address: </label></td>
 				<td><input type="text" size="30" name="email" value="<?php echo $email; ?>">
 				<td><small class="errorText"><?php echo $errorEmail; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="contact">Contact No.: </label></td>
	 			<td><input type="text" size="30" name="contact" value="<?php echo $contact; ?>">
	 			<td><small class="errorText"><?php echo $errorContact; ?></small>
	 		</tr>
			<tr>
	 			<td><label for="houseNumber">House or Unit No: </label></td>
	 			<td><input type="text" size="30" name="houseNumber" value="<?php echo $houseNumber; ?>">
	 			<td><small class="errorText"><?php echo $errorHouseNumber; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="street">Street Name:</label></td>
	 			<td><input type="text" size="30" name="street" value="<?php echo $street; ?>">
	 			<td><small class="errorText"><?php echo $errorStreet; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="city">City: </label></td>
	 			<td><input type="text" size="30" name="city" value="<?php echo $city; ?>">
	 			<td><small class="errorText"><?php echo $errorCity; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="province">Province:</label></td>
	 			<td><input type="text" size="30" name="province" value="<?php echo $province; ?>">
	 			<td><small class="errorText"><?php echo $errorProvince; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="postalCode">Postal Code:</label></td>
	 			<td><input type="text" size="30" name="postalCode" value="<?php echo $postalCode; ?>">
	 			<td><small class="errorText"><?php echo $errorPostalCode; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="password">Password:</label></td>
	 			<td><input type="password" size="30" name="password" value="<?php //echo $password; ?>">
	 			<td><small class="errorText"><?php echo $errorPassword; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="confirmPassword">Confirm Password:</label></td>
	 			<td><input type="password" size="30" name="confirmPassword" value="<?php //echo $confirmPassword; ?>">
	 			<td><small class="errorText"><?php echo $errorConfirmPassword; ?></small>
	 		</tr>
	 		<tr>
				<td><input type="submit" name="submit" value="Register" class="button--pill">
				</td>
			</tr>
	 		</table>
	 	</form>
 	<?php
	}
?>
 <?php include("templates/inc_footer.html"); ?>