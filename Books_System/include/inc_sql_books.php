<?php
$error = 0; 
if($DBConnect !== FALSE)
{
	if($error == 0)
	{
		//$query = "SELECT * FROM book d join book_details b on b.details_id = d.details_id join category c on c.category_id = d.category_id where price > 0";
		$query = "SELECT * FROM book_details WHERE price > 0"; 
		$queryResult = mysqli_query($DBConnect,$query); 
		
		if($queryResult === FALSE)
		{
					echo "<p>Unable to insert the values into the database table.</p>". "<p>Error code " . $DBConnect->connect_errno
						. ": " . $DBConnect->connect_error . "</p>";
						++$error; 
		}
		else
		{
			if(empty($_SESSION['cart']))
				$ShoppingCart = array(); 

					 /* fetch associative array */
    				while ($row = $queryResult->fetch_assoc()) 
    				{
    					$ShoppingCart[$row['details_id']] = 0;
    					?>
       <div class="table-responsive"> 			
      <table class="table table-full">
        <th>Latests Books</th>
        <div class="row gutters">
	       	<tr>
	        	<td><img src="<?php echo $row['image']; ?>"/></td>
	        	<td><strong>Title: </strong><?php echo htmlentities($row['title']); ?><br />
	        	<strong>Author: </strong><?php echo htmlentities($row['author']); ?><br />
	        	<strong>Description: </strong><?php echo htmlentities($row['description']); ?><br /></td>
	        	
	    <td><strong class="currency">Price: </strong>R<?php echo htmlentities($row['price']); ?>
	     <p><a href="'<?php echo $_SERVER["SCRIPT_NAME"];?>">Add</a></p>
	     </td>
		</tr>
     </table>
</div>
        <?
			}
		}
	}
}
?>