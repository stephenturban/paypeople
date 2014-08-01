<?php 

class Helpers { 
/**
*
* @param $xml is the xml string that is returned from the balance soap call 
* @return returns either the current balance (int) or the error in question 
*/
public function decodeString($xml)
{
	if(!$xml)
	{
		return 'Sorry, you couldn\'t connect to Tigo Cash';
	}

	// if mistyped pin, return pin does not exist 
	elseif(preg_match("/PIN does not exist/", $xml))
	{
		return 'Pin Does Not Exist';
	}

	// if phone number or pin are of the incorrect length 
	elseif(preg_match("/Invalid Request/", $xml))
	{
		return 'Invalid Request: Check the length of your number and pin';
	}

	elseif(preg_match("/Please enter correct PIN/", $xml))
	{
		return 'Please check your PIN. On the next incorrect PIN your account will be barred.';
	}

	elseif(preg_match("/Unable to complete transaction as sender/", $xml))
	{
		return 'Your phone number has been temporarily blocked for too many incorrect attempts.';
	}

	// Second wrong attempt with PIN. If user sends incorrect request again his TigoCash Account will be barred. 
	elseif(preg_match("/on the next wrong PIN/", $xml))
	{
		return 'On the next incorrect PIN entry your account will be barred. Please check your account information before trying again.';
	}

}




}