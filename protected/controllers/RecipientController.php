<?php

class RecipientController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column3';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','processpayment','admin','delete'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),

		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new Recipient;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Recipient']))
		{
			$model->attributes=$_POST['Recipient'];
			// updates the list_id of the new individual 
			// $model->list_id = $id; 
			// saves the models changes
			$model->listid = $id;
			if($model->save())
			{
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'id'=>$id
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		// increments the PayList of the individual 
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Recipient']))
		{
			$model->attributes=$_POST['Recipient'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();


		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 * @param $id is the list_id  
	 */
	public function actionIndex($id)
	{
		$dataProvider= new CActiveDataProvider('Recipient', array('criteria'=>array(
												'condition'=>'list_id = '.$id)));
		$paylist = Paylist::model()->findByPk($id);
		$user_id = Login::model()->getUserId();
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'id'=>$id,
			'totaldue'=>Recipient::model()->totaldue($id), 
			'numpeople'=>$paylist->numindv,
			'accounts'=> Account::model()->findAll(array("condition"=>"user_id = $user_id")),
			'listname'=>$paylist->name,
		));
	}

	/**
	 * Manages all models.
	 * @param $id is the id of the current list 
	 */
	public function actionAdmin($id)
	{
		$model=new Recipient('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Recipient']))
			$model->attributes=$_GET['Recipient'];

		$this->render('admin',array(
			'model'=>$model,
			'list_id'=>$id
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Recipient the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Recipient::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	* this function takes in the payment Id and calls the 
	*@param $id : id of the specified list
	*@return this function 
	*/
	public function actionProcessPayment($id)
	{
		// if the account id was passed in 
		if(isset($_POST['listF']))
		{
			$account_id = $_POST['listF'];
			// total due before payment 
			$totaldue = Recipient::model()->totaldue($id);
			$result = Recipient::model()->MakePayment($id, $account_id); 

			if($result == 'not enough money')
			{
				Yii::app()->user->setFlash('not enough money', "This account does not have enough money 
					to make that transaction!");
				$this->redirect(array('recipient/index', 'id' => $id));	
			}
			else 
			$this->render('paysummary',array(
				'id'=>$id,
				'totaldue'=>$totaldue,
				'numpeople'=>Paylist::model()->NumIndv($id),
				'user_id'=>Login::model()->getUserId(),
				'accountname'=>Account::model()->AccountName($account_id),
				'accountbalance'=>Account::model()->AccountBalance($account_id), 
				''

			));
		}

		


	}

	/**
	 * Performs the AJAX validation.
	 * @param Recipient $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='recipient-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
