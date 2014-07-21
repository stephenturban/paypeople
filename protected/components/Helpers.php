<?php 

class Helpers { 
/**
*
* @param $xml is the xml string that is returned from the balance soap call 
* @return returns either the current balance (int) or the error in question 
*/
public function decodeBalanceString($xml)
{
	if(!$xml)
	{
		return 'Sorry, you couldn\'t connect to Tigo Cash';
	}
	// this extracts the balance as a string   
	if(preg_match("/walletBalance>(\d+)\</", $xml, $stringbalance))
	{
		// this return the stringbalance as an int 
		$balance = (int) $stringbalance[1];

		return $balance;
	}

	// if mistyped pin, return pin does not exist 
	elseif(preg_match("/PIN does not exist/", $xml))
	{
		return 'Pin Does Not Exist';
	}

	// checks for mistyped phone number 
	elseif(preg_match("/User not found/", $xml))
	{
		return 'User Not Found: Check your phone number';
	}

	// if phone number or pin are of the incorrect length 
	elseif(preg_match("/Invalid Request/", $xml))
	{
		return 'Invalid Request: Check the length of your number and pin';
	}

	elseif(preg_match("/Invalid pin passed/", $xml))
	{
		return 'Invalid PIN: The PIN you gave is not four digits';
	}

	elseif(preg_match("/PIN does not exist/", $xml))
	{
		return 'Pin Does Not Exist. Check Your PIN';
	}

	else
	//  default error if not covered in other case. 	
	return 'There was an error processing your request. Check your number and PIN and try again.';

}




}