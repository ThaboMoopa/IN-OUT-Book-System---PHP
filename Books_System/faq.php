<?php 
session_start(); 
require_once("classes/class_Books.php");
//include the header
include('templates/inc_header.html');
 $categoryID = 0;
if(class_exists('Books'))
{
	if(isset($_SESSION['Books']))
	{
		$Books = unserialize($_SESSION['Books']);
	}
	else
	 	$Books = new Books();
	 	$Books->setBooks($categoryID);
	 	$Books->getCustomerID();
		$Books->setWebAppTag(session_id()); 
		$Books->getInvoiceID(); 
}
else 
	echo '<p class="text--error">Class does not exist</p>';
echo '<h1 class="text--primary">Frequently Asked Questions</h1>';
?>
<p>Below are some of the common questions we have received from users:</p>

<div id="modal1" class="modal modal--full">
  <div class="modal-container">
    <div class="modal-header">
     	How to purchase a book?:

      <a href="#close" class="modal-close">&times;</a>
    </div>

    <div class="modal-body">
      <p>You may only purchase a book once you have registered.</p>
	  <p>You may only purchase a book that is available on the system.</p>
    </div>
  </div>
</div>

<p><a href="#modal1">1. How to purchase a book?</a></p>

<div id="modal2" class="modal modal--full">
  <div class="modal-container">
    <div class="modal-header">
     	How do I register/ login /update details?

      <a href="#close" class="modal-close">&times;</a>
    </div>

    <div class="modal-body">
      <p>Click on register and complete the register form.  <br />
		After registering you must login with your e-mail address and the password provided in the
		register form.<br />
		To update your details you must click on view profile and click on edit details.</p>
	  <p>You may only purchase a book that is available on the system.</p>
    </div>
  </div>
</div>

<p><a href="#modal2">2. How do I register/ login /update details?</a></p>

<div id="modal3" class="modal modal--full">
  <div class="modal-container">
    <div class="modal-header">
     	How to change my password?

      <a href="#close" class="modal-close">&times;</a>
    </div>

    <div class="modal-body">
      <p>To change your password you must click on view profile and click on edit details then
		change the password.</p>
    </div>
  </div>
</div>

<p><a href="#modal3">3. How to change my password?</a></p>

<div id="modal4" class="modal modal--full">
  <div class="modal-container">
    <div class="modal-header">
     	How to print an invoice?

      <a href="#close" class="modal-close">&times;</a>
    </div>

    <div class="modal-body">
      <p>To print the invoice you may press the print screen button on the keyboard and paste on a
			word document to print since there is no print function.</p>
    </div>
  </div>
</div>

<p><a href="#modal4">4. How to print an invoice?</a></p>

<p>For additional information you are welcome to refer to the user manual.</p>
<?php

include('include/inc_webAppTag.php');
$_SESSION['Books'] = serialize($Books);
//include the footer
include('templates/inc_footer.html');
?>