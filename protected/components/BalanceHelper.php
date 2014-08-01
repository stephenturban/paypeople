<?php 

class BalanceHelper extends Helpers {


	/**
	* Decode balance string parses the returned xml for a checkBalance Call to TigoCash 
	* @param $xml is the xml string that is returned from the balance soap call 
	* @return returns either the current balance (int) or the error in question 
	*/
	public function decodeString($xml)
	{
		// calls the Helpers decodeString. if nothing is returned continue on. 
		parent::decodeString($xml); 
		
		// this extracts the balance as a string   
		if(preg_match("/walletBalance>(\d+)\</", $xml, $stringbalance))
		{
			// this return the stringbalance as an int 
			$balance = (int) $stringbalance[1];

			return $balance;
		}

		// checks for mistyped phone number 
		elseif(preg_match("/User not found/", $xml))
		{
			return 'User Not Found: Check your phone number';
		}


		elseif(preg_match("/Invalid pin passed/", $xml))
		{
			return 'Invalid PIN: The PIN you gave is not four digits';
		}

		else
		//  default error if not covered in other case. 	
		return 'There was an error processing your request. Check your number and PIN and try again.';

	}











}  


?> 