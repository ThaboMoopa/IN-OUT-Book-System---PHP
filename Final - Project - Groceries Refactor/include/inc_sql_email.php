<?php
if($DBConnect !== FALSE) //determines if the database connection is valid
			{
				$sql = "Select email from customer";
				$query = mysqli_query($DBConnect, $sql);

				//check the email address exists
				while($Row = mysqli_fetch_assoc($query))
				{
					if($email == $Row['email'])
					{
						echo 'This email address already exists';
						$errorEmail = '<p class="text--error">This email address already exists.</p>';
							
						++$errorFormCount;
					}
					//close the requery to free the memory associated with a result
					//mysqli_free_result($query);
				}
				 

				//Close connection
				$DBConnect->Close(); 
			}
?>