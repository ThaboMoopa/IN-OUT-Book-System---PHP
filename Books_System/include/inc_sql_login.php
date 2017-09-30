<?php
if($DBConnect !== FALSE) //Determine the database connection is valid
{
	$error = 0; 
	if($error == 0)
	{
	$query = "SELECT * FROM Customer where email='".$email."'and password='".md5($password)."'"; 
	//$SQLstring = "SELECT * FROM Customer";
	$queryResult = $DBConnect->query($query); 

		if($queryResult === FALSE)
		{
			echo "<p>Unable to insert the values into the database table.</p>". "<p>Error code " . $DBConnect->connect_errno . ": " . $DBConnect->connect_error . "</p>";
			++$error; 
		}
		else
		{
			/*
			http://php.net/manual/en/function.mysqli-fetch.php
			fetch records into an associative array
			*/	
			if(($queryResult->num_rows)==0)
			{
				echo '<p class="text--error">The email and password is not valid, please register.</p>';
				++$error; 
			}
			else
			{
				$Row = $queryResult->fetch_assoc();

				//Retrieve the customer ID into a session ID
				echo $_SESSION['customer_id']= $Row['customer_id']; 
				$_SESSION['name'] = $Row['name']; 
				$_SESSION['surname'] = $Row['surname'];

				$customerID = $Row['customer_id'];

				echo '<p class="text--success">Welcome '. $_SESSION['name'].' '.$_SESSION['surname'].'</p>';
				$Books->createOrderID($customerID);

				//close the requery to free the memory associated with a result
				//mysqli_free_result($QueryResult);
			}
			 
		}
		$DBConnect->Close();		
	}
	if($error == 0)
	{

		print  
	}
}
?>