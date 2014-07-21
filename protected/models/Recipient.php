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
}
