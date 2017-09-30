<?php 
class Login{
	private $email = ""; 
	private $password = ""; 

	public setEmail($email)
	{
		$this->email = $email; 
	}
	public getEmail()
	{
		return $this->email; 
	}
	public setPassword($password)
	{
		$this->password = $password; 
	}
	public getPassword()
	{
		return $password; 
	}
}
?>