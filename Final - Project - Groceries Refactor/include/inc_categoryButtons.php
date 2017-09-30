<?php 
if(isset($_POST['category1']))
{
  $categoryID = 1;
  $Store->setProducts($categoryID);
}
elseif(isset($_POST['category2']))
{
  $categoryID = 2;
  $Store->setProducts($categoryID); 
}
elseif(isset($_POST['category3']))
{
  $categoryID = 3;
  $Store->setProducts($categoryID); 
}
elseif(isset($_POST['category4']))
{
  $categoryID = 4; 
  $Store->setProducts($categoryID);
}
?>
  <form name="frmCategory" action="index.php" method="POST">
      <input type="submit" name="category1" value="Dry Groceries">
      <input type="submit" name="category2" value="Beverages">
      <input type="submit" name="category3" value="Snacks">
      <input type="submit" name="category4" value="Canned">
      <input type="submit" name="viewCart" value="View My Cart">
      <?php
      if($Store->getCustomerID()>0)
      {
        echo '<p class="text--right text--warning">Logged in: <a href="customerHistory.php">'.$Store->getCustomerName(). ' '. $Store->getCustomerSurname().'</a> | <a href="logout.php">Logout</a></p>';  
      }
      ?>
      
 <!--    </tr>
  </table> -->
  </form>