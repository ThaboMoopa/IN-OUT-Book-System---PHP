<?php
$error = 0; 
if($DBConnect !== FALSE) //determines if the database connection is valid
{
	if($error == 0)
	{

				$validPassword = md5($password); 
				//sql command to database table
				$query = "INSERT INTO Customer (name, surname, email, contact, unitno, street,city, province, postalcode, password) VALUES ('$firstName', '$lastName', '$email','$contact', '$houseNumber', '$street', '$city', '$province', '$postalCode','$validPassword')"; 
	
				/*
				execution of query
				references: http://php.net/manual/en/mysqli.affected-rows.php 
				*/

				$result = $DBConnect->query($query); 
					//$result = mysqli_query($DBConnect, $query);
				if($result === FALSE)
				{
					echo "<p>Unable to insert the values into the database table.</p>". "<p>Error code " . $DBConnect->connect_errno
						. ": " . $DBConnect->connect_error . "</p>";
						++$error; 
				}
				else 
				{
					//retrieve the user ID number from Database
					$_SESSION['id'] = $DBConnect->insert_id;
					print '
						<form name="frmSucessful" method="post" action="" class="form--inline">
						<p> You have successfully registered <span class="text--primary">  '
						. htmlentities($firstName) .'</span></p>
						<p> Your registrationID is <span class="text--primary"> '
						. $_SESSION['id'] .' </span> with the Email Address: <span class="text--primary">'
						. htmlentities($email).' </span></p>
						<h5 class="text--success">Click on the Login link at the top.</h5>
						<h4 class="text--primary">!!!Happy Shopping!!!!</h4>
						</form> '; 
						//<p class="text--success">You have successfully inserted '
						// .$DBConnect->affected_rows .' record(s). 
						
						
						/*
							close the requery to free the memory associated with a result
							http://php.net/manual/en/mysqli-result.free.php
						*/
						//mysqli_free_result($query);
				}
				
				

				//Close connection
				$DBConnect->Close(); 
			}
			// if($error == 0)
			// {
			// 	echo "<form method='post' " ." action='customerDetails.php'>\n"; 
			// 	echo "<input type='hidden' name='customerID' " ." value='$customerID'>\n"; 
			// 	echo "<input type='submit' name='submit' " ." value='View personal details'>\n";
			// 	echo "<input type='submit' name='submit' " ." value='Swap book'>\n"; 
			// 	echo "</form>"; 

			// }
	}
?>