<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{	
		// this means that you can find the username which matches this password 
		$record=Login::model()->findByAttributes(array('email'=>$this->username));
		if($record === null)
			print_r ($record);
			// $this->errorCode=self::ERROR_USERNAME_INVALID;

		elseif($record->password!==$this->password)
		{	
			echo $recordpassword = $record->password; 
			echo $tablepassword = $this->password; 
		}	// $this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		{
			$this->errorCode=self::ERROR_NONE;
		}
		return !$this->errorCode;
		
	}
}