<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class ContactForm extends CFormModel
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;
	public $favorite_pokemon; 

	/**
	 * Declares the validation rules.
	 * Rules essentially has a couple of different rules that is has at the end 
	 * It is abstracted away. But, all we need to know is how to use it. 
	 */
     /** I should have abstracted away this stuff first, and then created it.  
     * 1. Assume that it works 
     * 2. Then create it 
     */   
	
	public function is_pokemon($input) 
	{
		$pokemon = array("squirtle", "pikachu", "charmander")
		 foreach ($pokemon as $unit) 
		 	 if ($input == $unit) then 
	     if $unit = $input then true 
	} 


	public function rules()
	{
		return array(
			array('favorite_pokemon', 'is_pokemon')
			// name, email, subject and body are required
			array('name, email, subject, body', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			// verifyCode needs to be entered correctly
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'verifyCode'=>'Verification Code',
		);
	}
}