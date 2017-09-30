<?php 
/**
php version 5.4 - version 7.1 does not work
Connecting to the database
Check the database connection then select the database to query
@error control operator - supresses errors that can occur with database connections
Using mysqli Object-oriented 
*/

//reference: https://www.w3schools.com/php/php_mysql_connect.asp
$DBName = "Books_Project"; 

//create connection 
$DBConnect = @new mysqli("localhost", "root", "mysql", "Books_Project"); //or die(mysqli_error());
$logFile = "log.txt";
$logNumber = 0;
$errorMsgs = array(); 
//reference the web php book 
$date = date('H:i a l F j');  

//check the connection between the application and database
if ($DBConnect->connect_errno) {
        echo "<p>Unable to connect to the database server.</p>". "<p>Error code " . $DBConnect->connect_errno. ": " . $DBConnect->connect_error . "</p>\n";
}
elseif(!$DBConnect){
    //write file to text file to report error in the connection
      $errorMsgs[] = "The database server is not available"; 

    $logMessage = "".$date." ".++$logNumber." .Connection to database ".$DBConnect."was unsuccessful because:". $DBConnect->connect_errno."\n\r";

    $logMessage .= "".$date." ".++$logNumber.". Connection to table ".$DBName." was unsuccessful because:". $DBConnect->connect_error ."\n\r";


    //write data to the text file for logging and append the text
    file_put_contents($logFile, $logMessage,FILE_APPEND);
}
else{
    //variable to hold the log message to write 
    $logMessage = "".$date." ".++$logNumber.". Connection to database was successful.\n\r";
     
    $logMessage .= "".$date." ".++$logNumber.". Connection to table ".$DBName." was successful.\n\r";

    //write data to the text file for logging and append the text
    file_put_contents($logFile, $logMessage,FILE_APPEND);        
}

?>