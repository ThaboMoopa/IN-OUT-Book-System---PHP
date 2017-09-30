<?php
$error = 0; 
if($DBConnect !== FALSE)
{
	if($error == 0)
	{
		$query = "INSERT INTO book (author, title, price, isbn_number, image, description, quantity) VALUES ('$author', '$title', 0, '$isbnNumber', '$imageLink', '$description', $quantity)";
		$queryResult = $DBConnect->query($query); 
		if($queryResult === FALSE)
		{
			echo "<p>Unable to insert the values into the database table.</p>". "<p>Error code " . $DBConnect->connect_errno
						. ": " . $DBConnect->connect_error . "</p>";
						++$error; 
		}
	}
}
?>