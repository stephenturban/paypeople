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



}
