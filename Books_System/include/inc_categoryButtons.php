<?php 
if(isset($_POST['category1']))
{
  $categoryID = 1;
  $Books->setBooks($categoryID);
}
elseif(isset($_POST['category2']))
{
  $categoryID = 2;
  $Books->setBooks($categoryID); 
}
elseif(isset($_POST['category3']))
{
  $categoryID = 3;
  $Books->setBooks($categoryID); 
}
elseif(isset($_POST['category4']))
{
  $categoryID = 4; 
  $Books->setBooks($categoryID);
}
elseif(isset($_POST['SwapBook']))
{
  
    if($Books->getCustomerID() == 0)
    {
     echo '<p class="text--error" style="font-size: 1em;">Please Register or Login to continue...</p>'; 
    }
    else
    {
      header('Location: inc_insert_book.php'); 
    }
}
?>
  <form name="frmCategory" action="index.php" method="POST">
      <button class="button--pill" name="category1">Information Technology</button>
      <button class="button--pill" name="category2">Marketing</button>
      <button class="button--pill" name="category3">Engineering</button>
      <button class="button--pill" name="viewCart">View My Cart</button>
      <button class="button--pill" name="SwapBook">Swap Book</button>
      <?php
      if($Books->getCustomerID()>0)
      {
        echo '<p class="text--right text--warning">Logged in: <a href="customerHistory.php">'.$Books->getCustomerName(). ' '. $Books->getCustomerSurname().'</a></p>';  
      }
      ?>
  </form>