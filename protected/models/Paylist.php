<?php

/**
 * This is the model class for table "paylist".
 *
 * The followings are the available columns in table 'paylist':
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property integer $due_date
 * @property string $status
 */
class Paylist extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'paylist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, due_date', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('status', 'length', 'max'=>20),	
			array('due_date', 'date', 'format'=>'dd-MM-yyyy', 'message'=>'Please input the date as dd-mm-yyyy'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('name, due_date, status', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'name' => 'Name of Pay List',
			'due_date' => 'Payment Due Date',
			'status' => 'Status',
			'numindv'=>'Number of Individuals',
			'totaldue'=>'Total Due'
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
		// this criteria limits the recipients displayed to only those of the same idea
		$criteria->addCondition(array("condtion"=>"user_id = $userId"));

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('due_date',$this->due_date);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Paylist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/** 
	*  Creates the virtual attribute 'numindv' which holds # of recipients with
	*  @return  - integer of individuals with certain id 
	*/ 
	public function getNumIndv()
    {
		// gets the id of the current list 
		$list_id = $this->id;
		// returns the number of recipients with that list id
     	return $count = Recipient::model()->count(array("condition"=>"list_id = $list_id"));

    }

    /**
    * virtual attribute totaldue calculates the amount due for each list 
    * @return  - integer of total due 
    */
    public function getTotalDue() 
    {
    	$list_id = $this->id; 
    	return $totaldue = Recipient::model()->totaldue($list_id);
    	
    }

    // gets the number of individuals given a certain list_id
    public function NumIndv($list_id) 
    {
    	// returns the number of recipients with that list id
     	return $count = Recipient::model()->count(array("condition"=>"list_id = $list_id"));
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
