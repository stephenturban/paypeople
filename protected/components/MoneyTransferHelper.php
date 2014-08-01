<?php 

class MoneyTransferHelper extends Helpers { 

	/**
	* Decode  string parses the returned xml for a MoneyTransfer to TigoCash 
	* @param $xml is the xml string that is returned from the MoneyTransfer Call
	* @return returns either true or the error in question.
	*/
	public function decodeString($xml)
	{
		// calls the Helpers decodeString. if nothing is returned continue on. 
		parent::decodeString($xml); 
		
		// if succesful than return true  
		if(preg_match("/Money has been sent successfully/", $xml))
		{
			return true; 
		}

		// checks if the transaction is under 100 Rwf 
		elseif(preg_match("/less than the minimum value/", $xml))
		{
			return 'Transaction amount is less than the minimum value of 100 Rwf';
		}

		// if the transfer requested is larger than the current balance the user has return error
		elseif(preg_match("/account would go below minimum/", $xml))
		{
			return 'Unable to complete request as account would go below minimum balance.';
		}

			// if the transfer requested is larger than the current balance the user has return error
		elseif(preg_match("/PIN does not exist/", $xml))
		{
			return 'The PIN you have entered does not exist. Please check your account information before trying again.';
		}

			// if the transfer requested is larger than the current balance the user has return error
		elseif(preg_match("/MSISDN is not registered/", $xml))
		{
			return 'This phone number is not registered with TigoCash. Please check your account information and try again.';
		}

		// if the transfer requested is larger than the current balance the user has return error
		elseif(preg_match("/on the next wrong PIN/", $xml))
		{
			return 'On the next incorrect PIN entry your account will be barred. Please check your account information before trying again.';
		}

		// if the transfer requested is larger than the current balance the user has return error
		elseif(preg_match("/You cannot send money to yourself/", $xml))
		{
			return 'You cannot send money to yourself.';
		}

		else
		{
		//  default error if not covered in other case. 	
		return 'There was an error processing your request. Check your number and PIN and try again.';
		}	
	}


}


?>

