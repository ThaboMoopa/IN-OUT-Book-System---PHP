<?php
	function validateFirstName($firstName, $errorFormCount)
	{
		global $errorFormCount;
		global $errorFirstName;
		$validateFirstName = preg_match("/^[a-z]+$/i", $firstName); 
		if(empty($firstName))
		{
			$errorFirstName = '<p class="text--error">Please enter a First Name.</p>';
			++$errorFormCount; //error counter will determine if whether the data should be sent to database or not
		}
		elseif(is_numeric($firstName)){

			$errorFirstName = '<p class="text--error">Only alphabetic letter are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif($validateFirstName == 0){
			$validateFirstName = preg_match("/^[a-z]+$/i", $firstName);
			$errorFirstName = '<p class="text--error">Only alphabetic letter no other characters.</p>';
			++$errorFormCount;
		}
		return $firstName;    
	}
	function validateLastName($lastName,$errorFormCount)
	{
		global $errorFormCount;
		global $errorLastName;  
		$validateLastName = preg_match("/^[a-z]+$/i", $lastName);
		if(empty($lastName)){

			$errorLastName = '<p class="text--error">Please enter a Last Name.</p>';
			++$errorFormCount;
		}
		elseif(is_numeric($lastName)){

			$errorLastName = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif($validateLastName == 0){
			
			$errorLastName = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
		return $lastName; 

	}
	function validateEmail($email,$errorFormCount)
	{
		global $errorFormCount;
		global $errorEmail;
		//validating that the username is a valid email address
        $validateEmail = preg_match("/^([0-9a-zA-Z]+[-._+&amp;])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$/i", $email); 
		if(empty($email)){
			$errorEmail = '<p class="text--error">Please enter an Email address.</p>';
			++$errorFormCount;
		}
		// output message for when preg_match is not matching input
		elseif($validateEmail==0)
        {
            $errorEmail = '<p class="text--error">Email address is invalid.</p>';
            ++$errorFormCount;
        }
        else{
        	require_once('include/inc_db_books.php'); //include the database connection
        	include('include/inc_sql_email.php'); //check the email exists in the database

        }
		return $validateEmail; 
	}

	function validateConfirmPassword($password, $confirmPassword,$errorFormCount)
	{
		global $errorFormCount;
		global $errorPassword; 
		global $errorConfirmPassword; 
		
		$validPassword = md5($password);
		$validConfirmPassword = md5($confirmPassword);
		if(empty($password)){
			$errorPassword = '<p class="text--error">Please enter a Password.</p>';
			++$errorFormCount;
		}
		elseif(strlen($password)<6)
		{
			$errorPassword = '<p class="text--error">Password must be atleast 6 characters long.</p>';
			++$errorFormCount;
		}
		elseif(empty($confirmPassword)){
			$errorConfirmPassword = '<p class="text--error">Please re-enter the password.</p>';
			++$errorFormCount;
		}
		elseif($password != $confirmPassword){
				$errorConfirmPassword ='<p class="text--error">Password does not match.</p>';
				++$errorFormCount;
		}
		return $validPassword;
		
    }

	function validateContact($contact,$errorFormCount)
	{
		global $errorFormCount;
		global $errorContact; 
		if(empty($contact)){
			$errorContact = '<p class="text--error">Please your contact number.</p>';
			++$errorFormCount;
		}
		elseif(!is_numeric($contact)){
			$errorContact = '<p class="text--error">Only numberic characters are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif(strlen($contact)>10 || strlen($contact)<10) //p467 TextBook
		{
			$errorContact = '<p class="text--error">Contact number must 10 characters long.</p>';
			++$errorFormCount;
		}
	
		return $contact;  
	}
	function validatePostalCode($postalCode,$errorFormCount)
	{
		global $errorFormCount;
		global $errorPostalCode; 
		 if(empty($postalCode)){
		 	$errorPostalCode = '<p class="text--error">Please enter a postal code.</p>';
		 	++$errorFormCount;
		 }
		 elseif(!is_numeric($postalCode)){
		 	$errorPostalCode = '<p class="text--error">Only numberic characters are allowed in the field.</p>';
		 	++$errorFormCount;
		 }
			
		elseif(strlen($postalCode)>4 || strlen($postalCode)<4)
		{
			$errorContact = '<p class="text--error">Contact number must 4 characters long.</p>';
			++$errorFormCount;
		}
		return $postalCode; 
	}
	function validateCity($city,$errorFormCount)
	{
		global $errorFormCount;
		global $errorCity; 
		$validateCity = preg_match("/^[a-z\s]+([a-z])+$/i", $city);
		if(empty($city)){
			$errorCity = '<p class="text--error">Please enter the city name.</p>';
			++$errorFormCount;
		}
		elseif(is_numeric($city)){
			$errorCity = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif($validateCity == 0){
			
			$errorCity = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
		return $city;  
	}
	function validateHouseNumber($houseNumber,$errorFormCount)
	{
		global $errorFormCount;
		global $errorHouseNumber; 
		if(empty($houseNumber)){
			$errorHouseNumber = '<p class="text--error">Please enter a house number.</p>';
			++$errorFormCount;
		}
		
		elseif(!is_numeric($houseNumber)){
			$errorHouseNumber = '<p class="text--error">Only numberic characters are allowed in the field.</p>';
			++$errorFormCount;
		}
		return $houseNumber; 
	}
	function validateProvince($province,$errorFormCount)
	{
		global $errorFormCount;
		global $errorProvince;
		$validateProvince = preg_match("/^[a-z\s]+([a-z])+$/i", $province);
		if(empty($province)){
		 	$errorProvince = '<p class="text--error">Please enter a province.</p>';
		 	++$errorFormCount;
		}
		elseif(is_numeric($province)){
			$errorProvince = '<p class="text--error">Only alphabetic letter are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif($validateProvince == 0){
			
			$errorProvince = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
		return $province; 
	}
	function validateStreet($street,$errorFormCount)
	{
		global $errorFormCount;
		global $errorStreet; 
		$validateStreet = preg_match("/^[a-z\s]+([a-z])+$/i", $street);
		
		if(empty($street)){
			$errorStreet = '<p class="text--error">Please enter a street name.</p>'; 
			++$errorFormCount;
		}
		elseif(is_numeric($street)){
			$errorStreet = '<p class="text--error">Only alphabetic letter are allowed in the field.</p>';
			++$errorFormCount;
		}
		elseif($validateStreet == 0){
			
			$errorFirstName = '<p class="text--error">Only alphabetic letter with no spaces are allowed in the field.</p>';
			++$errorFormCount;
		}
	}
?>
