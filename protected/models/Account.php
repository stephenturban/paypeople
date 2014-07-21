<?php

/**
 * This is the model class for table "account".
 *
 * The followings are the available columns in table 'account':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $mobile_comp
 * @property integer $msisdn
 * @property integer $pin
 * @property string $company
 */
class Account extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'account';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, mobile_comp, msisdn, pin, company', 'required'),
			array('name, mobile_comp, company', 'length', 'max'=>40),
			array('msisdn', 'length','max'=>12, 'min'=>12),
			array('pin', 'length','max'=>4, 'min'=>4),
			array('pin, msisdn, balance', 'numerical','integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, mobile_comp, msisdn, pin, company, balance', 'safe', 'on'=>'search'),
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


	

	public function getProviderOptions(){
    return array('tigo' => 'Tigo', 'mtn' => 'MTN', 'airtel'=>'Airtel');
}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'name' => 'Account Holder Name',
			'mobile_comp' => 'Mobile Provider',
			'msisdn' => 'Phone Number',
			'pin' => 'Mobile Money Pin',
			'company' => 'Your Company',
			'balance'=> 'Balance'
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
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$userId = Login::model()->getUserId(); 
		$criteria->addCondition(array("condtion"=>"user_id = $userId"));
		$criteria->compare('name',$this->name,true);
		$criteria->compare('mobile_comp',$this->mobile_comp,true);
		$criteria->compare('msisdn',$this->msisdn);
		$criteria->compare('pin',$this->pin);
		$criteria->compare('company',$this->company,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Account the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function AccountName($id)
	{
		$model = Account::model()->findByPk($id);
		return $name = $model->name;
	}


	/** 
	* @param $id is the current list id 
	* @return Accoutn Balance Should return the current balance recorded in the datatable 
	* @todo Implement Account Balance in a way that will check the current balance using a SOAP call 
	*  if the time stamp is at a certain time (enough time has passed) 
	*/ 
	public function AccountBalance($id)
	{
		$model = Account::model()->findByPk($id);
		return $name = $model->balance; 
	}

	// before you save the function here are the things you should do
	public function beforeSave()
	{
   		if($this->isNewRecord)
   		{
   			// if this is a new record, populate the user_id field with the current UserId
       		$this->user_id = Login::model()->getUserId();
   		}
   		return parent::beforeSave();
	}

		/**
	*@method CheckBalance() : this  method helps to get the balance info of the tigo cash subscriber using tigo rwanda middleware
	*@param string  $msisdn : this is the mobile number of the tigo cash subscriber
	*@param string $pin    : this is the pin number of the tigo cash account 
	*@return returns the decoded answer either as the balance (int) or a warning (string)
	*/
	public function BalanceCall($msisdn="250725038839",$pin="5000"){

	    //Store your XML Request in a variable
	    $input_xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://xmlns.tigo.com/MFS/GetBalanceRequest/V1" xmlns:v3="http://xmlns.tigo.com/RequestHeader/V3" xmlns:v2="http://xmlns.tigo.com/ParameterType/V2" xmlns:cor="http://soa.mic.co.af/coredata_1">
	   <soapenv:Header xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	      <cor:debugFlag>true</cor:debugFlag>
	      <wsse:Security>
	         <wsse:UsernameToken>
	            <wsse:Username>test_mw_axis</wsse:Username>
	            <wsse:Password>t35tMW4x1s</wsse:Password>
	         </wsse:UsernameToken>
	      </wsse:Security>
	   </soapenv:Header>
	   <soapenv:Body>
	      <v1:GetBalanceRequest>
	         <v3:RequestHeader>
	            <v3:GeneralConsumerInformation>
	               <v3:consumerID>AXIS</v3:consumerID>
	               <!--Optional:-->
	               <v3:transactionID>213424</v3:transactionID>
	               <v3:country>RWA</v3:country>
	               <v3:correlationID>112</v3:correlationID>
	            </v3:GeneralConsumerInformation>
	         </v3:RequestHeader>
	         <v1:requestBody>
	            <v1:msisdn>'.$msisdn.'</v1:msisdn>
	            <v1:pin>'.$pin.'</v1:pin>
	            <!--Optional:-->
	            <!--Optional:-->
	         </v1:requestBody>
	      </v1:GetBalanceRequest>
	   </soapenv:Body>
	</soapenv:Envelope>';

	// url of the server the request is going to  
	$url = "http://10.138.84.138:8002/osb/services/GetBalance_1_0";

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

    // this returns either the balance (int) or an error (string)
    return $result = Helpers::decodeBalanceString($xmlstring);
	}



}
