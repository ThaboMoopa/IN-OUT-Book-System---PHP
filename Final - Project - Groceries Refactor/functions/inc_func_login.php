<?php
//     //function to validate the username, if the field is empty, and call the next page
        function validateEmail($email,$errorFormCount) {
        global $errorFormCount;
        global $errorEmail;
        //validating that the username is a valid email address
        /* http://regexlib.com/DisplayPatterns.aspx */ 
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
        return $validateEmail; 
    } 
//Validate the Password 
    function validatePassword($password,$errorFormCount)
    {

       global $errorPassword; 
       global $errorFormCount;
        if(empty($password)){
            $errorPassword = '<p class="text--error">Please enter a Password.</p>';

            ++$errorFormCount;
        }
        
        else{
            
            return $password; 
        }
    }
?>