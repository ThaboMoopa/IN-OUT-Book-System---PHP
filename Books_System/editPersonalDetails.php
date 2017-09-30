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
	$customerID = $Books->getCustomerID(); 
}
define('TITLE', 'Edit Personal Details');
include("templates/inc_header.html"); 

print ' <h2 class="text--primary">Edit Details</h2>
		<p>Fill in the below information</p>';
include('functions/inc_func_edit.php'); 

		if(isset($_POST['submit']))
		{
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

				 //after the data has been sent to the table the form will not be displayed
				
				$updateCustomer = $Books->updatePersonalDetails($customerID, $firstName,$lastName,$email, $password,$contact,$postalCode,$city,$houseNumber,$province,$street); 
				
				$_SESSION['Books'] = serialize($Books);
				if($updateCustomer == 1)
				{
					echo '<p class="text--success">You have successfully updated your account.</p>';
					echo '<p>Click links below or click on home page</p>'; 
					include('include/inc_personalLinks.php');
					$showForm = FALSE;
					
				}
				else 
				{
					echo '<p class="text--error">Your details are incorrect please check details.</p>';
					$showForm = TRUE; 
				}
					
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
	?>
	<form name="frmLogin" method="post" action="<?php $_SERVER["SCRIPT_NAME"]; ?>" class="form--inline">
 		<table class="table--flat">
 			<tr>
 				<td><label for="firstName">First Name: </label></td>
 				<td><input type="text" size="30" name="firstName" value="<?php echo $Books->getCustomerName(); ?>"></td>
 				<td><small class="errorText"><?php echo $errorFirstName; ?></small>
 			</tr>
 			<tr>
 				<td><label for="lastName">Last Name: </label></td>
 				<td><input type="text" size="30" name="lastName" value="<?php echo $Books->getCustomerSurname(); ?>">
 				<td><small class="errorText"><?php echo $errorLastName; ?></small>
 			</tr>
 			<tr>
 				<td><label for="email">Email address: </label></td>
 				<td><input type="text" size="30" name="email" value="<?php echo $Books->getEmail(); ?>">
 				<td><small class="errorText"><?php echo $errorEmail; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="contact">Contact No.: </label></td>
	 			<td><input type="text" size="30" name="contact" value="<?php echo $Books->getContact(); ?>">
	 			<td><small class="errorText"><?php echo $errorContact; ?></small>
	 		</tr>
			<tr>
	 			<td><label for="houseNumber">House or Unit No: </label></td>
	 			<td><input type="text" size="30" name="houseNumber" value="<?php echo $Books->getUnitNumber(); ?>">
	 			<td><small class="errorText"><?php echo $errorHouseNumber; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="street">Street Name:</label></td>
	 			<td><input type="text" size="30" name="street" value="<?php echo $Books->getStreet(); ?>">
	 			<td><small class="errorText"><?php echo $errorStreet; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="city">City: </label></td>
	 			<td><input type="text" size="30" name="city" value="<?php echo $Books->getCity(); ?>">
	 			<td><small class="errorText"><?php echo $errorCity; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="province">Province:</label></td>
	 			<td><input type="text" size="30" name="province" value="<?php echo $Books->getProvince(); ?>">
	 			<td><small class="errorText"><?php echo $errorProvince; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="postalCode">Postal Code:</label></td>
	 			<td><input type="text" size="30" name="postalCode" value="<?php echo $Books->getPostalCode(); ?>">
	 			<td><small class="errorText"><?php echo $errorPostalCode; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="password">Password:</label></td>
	 			<td><input type="password" size="30" name="password">
	 			<td><small class="errorText"><?php echo $errorPassword; ?></small>
	 		</tr>
	 		<tr>
	 			<td><label for="confirmPassword">Confirm Password:</label></td>
	 			<td><input type="password" size="30" name="confirmPassword">
	 			<td><small class="errorText"><?php echo $errorConfirmPassword; ?></small>
	 		</tr>
	 		<tr>
				<td><input type="submit" name="submit" value="Update" class="button--pill">
				</td>
			</tr>
	 		</table>
	 	</form>
 	<?php
	}
?>
<?php ?> 
 <?php include("templates/inc_footer.html"); ?>