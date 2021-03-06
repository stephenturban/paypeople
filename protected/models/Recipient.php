<?php

/**
 * This is the model class for table "recipient".
 *
 * The followings are the available columns in table 'recipient':
 * @property integer $id
 * @property integer $list_id
 * @property integer $user_id
 * @property string $name
 * @property string $position
 * @property string $msisdn
 * @property string $balance
 * @property string $status
 */
class Recipient extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recipient';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, position, msisdn, balance', 'required'),
			array('list_id, user_id', 'numerical', 'integerOnly'=>true),
			array('name, position, balance, status', 'length', 'max'=>20, ),
			array('msisdn', 'length','max'=>12, 'min'=>12),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, list_id, user_id, name, position, msisdn, balance, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'list_id' => 'List',
			'user_id' => 'User',
			'name' => 'Recipient Name',
			'position' => 'Position',
			'msisdn' => 'Phone Number',
			'balance' => 'Amount',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 * @param $list_id is the id that is currently being passed in to the view. 
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search($list_id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$userId = Login::model()->getUserId(); 
		$criteria->addCondition(array("condtion"=>"user_id = $userId"));

		// limits the recipients to displayed to those of the same list 
		$criteria->addCondition(array("condition"=>"list_id = $list_id"));

		$criteria->compare('id',$this->id);
		$criteria->compare('list_id',$this->list_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('position',$this->position,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recipient the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

	/* 
	public function ListId()
	{
		echo 'this is the original list id:'.$_listId;	

		$listId = Recipient::model()->_listId;
		echo $listId; 
		echo ' this is the new Id:'.$listId;	
		return $listId; // my code here 
	}
	*/ 
	public function setListId($id)
	{
		$this->list_id = $id; 
	}
	
	public function TotalDue($list_id)
	{
		// find all individuals with certain list_id 
		$results = Recipient::model()->findAll(array("condition"=>"list_id = $list_id")); 
		// initialize total to 0 
		$total = 0; 		
		// add up there total due
		foreach($results as $result)
		{

			$total = $total + $result->balance;
		}
		return $total;

	}
	


	/** 
	* Makes a payment from one account of the user to all of the recipients of a certain paylist 
	* @param this function takes in the list_id and the account_id 
	* @return this function returns either success or failure, in which case it returns a certain error 
	*
	* @todo add the client side validation that you have enough money 
	* 
	* @todo add the server side validation  that you have enough money 
	* @todo add the the server side call - request confirmation  
	* @todo add the client side call - update the other account and recipients field 
	*/ 
	/*
	public function MakePayment($list_id, $account_id)
	{

		$amount_due = Recipient::model()->totaldue($list_id);
		$account = Account::model()->findByPk($account_id);
		$account_balance = $account->balance; 
		
			if ($amount_due > $account_balance)
			{
				return 'not enough money'; 
			}

		// @todo insert server side validation here that you have enough money 
		// this may or may not be necessary - may just need to make the attempt and have confirmation 

		// if (validation of transaction is true)
		// {  } 
			// update recipients amount due 
			Recipient::model()->updateAll(array('balance'=>0),'list_id="'.$list_id.'"');

			// update the balance of the mobile-money account  
			// @todo need to check how often mobile money accounts update, probably will 
			// need to do this manually as well on my end 
			// if it is automatic do not implement bellow function, instead call "check balance" 
			Account::model()->updateAll(array('balance'=>$account_balance - $amount_due), 'id = "'.$account_id.'"');

			return "success";
			

		



	}
	*/ 



	// before you save the function here are the things you should do
	public function beforeSave()
	{
   		if($this->isNewRecord)
   		{
   			// updates the user_id of the recipient
       		$this->user_id = Login::model()->getUserId(); 
       
   		}
		return parent::beforeSave();
	}


	/** 
	*
	* CheckTransfer checks whether the amount of money you have in your acount is sufficient to pay the 	
	* of  the specified list of individuals 
	* @param: $list_id is the id of the specified list 
	* @param: $account_id is the id of the account that was selected to pay 
	* @return: if succesful return nothing, if unsuccesful return not enough money 
	*
	**/ 
	function CheckTransfer($list_id, $account_id)
	{
		$amount_due = Recipient::model()->totaldue($list_id);
		$account = Account::model()->findByPk($account_id);
		$account_balance = $account->balance; 
		
		if ($amount_due > $account_balance)
		{
			return 'not enough money'; 
		}
	}


	/** 
	* 
	* MakePayment: this function helps us pay the recipients defined by a certain paylist 
	* @param $account_id identifies the mobile-money account that will pay the recipients 
	* @param $list_id is the id of the paylist that is going to be paid. 
	* @return An array that holds the transaction_id and the transaction_status 
	* transaction_status checks whether there were any errors in the transaction. I
	* If there were it returns 'has error'
	*/
	function MakePayment($account_id, $list_id)
	{
		// instantiates new column in BulkPayment table 
		$BPModel = new BulkPayment;
		// inserts the new BPModel into the database
		$BPModel->save();
		
		// instantiate the account that is being used to pay money
		$account = Account::model()->findByPk($account_id);

		// finds all individuals of the selected list
		$recipients = Recipient::model()->findAll(array("condition"=>"list_id = $list_id"));

		// this variable keeps track of the total amount paid in this transaction 
		$totalpaid; 

		// loop through the array of recipients, paying each of the individuals 
		foreach($recipients as $recipient)
		{
			// instantiates a new IndividualPayment
			$IPModel = new IndividualPayment;

			// Makes the transfer and returns the status of the transfer 
			$result = Recipient::model()->TransferMoney($account->msisdn, $account->pin, $recipient->msisdn, $recipient->balance);
			
			// the amount that the recipient should be paid 
			$recipientBalance = $recipient->balance;

			if($result == "success")
			{
				// add the amount paid to this individual to the total paid amount
				$totalpaid = $totalpaid + $recipient->balance;
				// resets recipients  amount due to zero 
				$recipient->balance = 0; 
				$recipient->save();

			}
			
			else 
			{
				$error = 'has error'; 
			}
			
			// defines the attributes that will be put into the 
			$IPattributes = array("name"=>$recipient->name, "recipient_id"=>$recipient->id, 
			                "transfer_id"=>$BPModel->id, "amount"=>$recipientBalance, "status"=>$result);
			// set the attributes of the Individual Payment 
			$IPModel->setAttributes($IPattributes, $safeOnly = false); 
			// save the new transaction into the database
			$IPModel->save();
		}
		
		// declares the attributes for the bulk payment record 
		$BPAttributes = array("list_id"=>$list_id, "account_id"=>$account_id, "amount"=>$totalpaid);
		// puts those attributes inside the BPModel Object
		$BPModel->setAttributes($BPAttributes, $safeOnly = false);
		// saves the model to the database 
		$BPModel->save();
		// transaction_status only returns "has error" if there was an error in the transaction.
		return array("transfer_id"=>$BPModel->id, "transaction_status"=>$error); 

	}




	/**
	* @method TransferMoney : this  method helps us pay recipients using our Tigo Cash Accounts, 
	* this is implemented using Tigo's API TransferMoney 
	*@param string  $sourceMsisdn: refers to the account that was selected to pay the individual recipients 
	*@param string $sourcePin: refers to the accounts pin number used for tigo cash 
	*@param string $targetMsisdn: refers to the  that holds all of the recipients information 
	*@param int $amountOwed: Balance of the recipient. This is the amount Owed to the individual recipient
	*@return returns the decoded answer either as the balance (int) or a warning (string)
	*/
	public function TransferMoney($sourceMsisdn, $sourcePin, $targetMsisdn, $amountOwed) 
	{

	    //Store your XML Request in a variable
	    $input_xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/MFS/WalletManagementRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2">
   <soapenv:Header xmlns:cor="http://soa.mic.co.af/coredata_1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <cor:debugFlag>true</cor:debugFlag>
      <wsse:Security>
         <wsse:UsernameToken>
            <wsse:Username>test_mw_axis</wsse:Username>
            <wsse:Password>t35tMW4x1s</wsse:Password>
         </wsse:UsernameToken>
      </wsse:Security>
   </soapenv:Header>
   <soapenv:Body>
      <v1:MoneyTransferRequest>
         <v3:RequestHeader>
            <v3:GeneralConsumerInformation>
               <v3:consumerID>TIGO</v3:consumerID>
               <!--Optional:-->
               <v3:transactionID>12345qwerty</v3:transactionID>
               <v3:country>RWA</v3:country>
               <v3:correlationID>1234</v3:correlationID>
            </v3:GeneralConsumerInformation>
         </v3:RequestHeader>
         <v1:requestBody>
            <v1:sourceMsisdn>'.$sourceMsisdn.'</v1:sourceMsisdn>
            <v1:targetMsisdn>'.$targetMsisdn.'</v1:targetMsisdn>
            <v1:pin>'.$sourcePin.'</v1:pin>
            <v1:amount>'.$amountOwed.'</v1:amount>
         </v1:requestBody>
      </v1:MoneyTransferRequest>
   </soapenv:Body>
</soapenv:Envelope>';

	// url of the server the request is going to  
	$url = "http://10.138.84.138:8002/osb/services/WalletManagement_1_0";

	$soap_do = curl_init(); 
	curl_setopt($soap_do, CURLOPT_URL,            $url );   
	curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
	curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
	curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($soap_do, CURLOPT_POST,           true ); 
	curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $input_xml); 
	curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($input_xml) )); 
	curl_setopt($soap_do, CURLOPT_USERPWD, $user="test_mw_axis" . ":" . $password="t35tMW4x1s");

	// returns a long xml string reply
	$xmlstring = curl_exec($soap_do);

    // this returns either true (succesful) or an error  of type string
    return $result = MoneyTransferHelper::decodeString($xmlstring);
	}




}
