

<?php
/* @var $this AccountController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Accounts',
);

$this->menu=array(
	array('label'=>'Add a mobile-money account', 'url'=>array('create')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>Your Accounts</h1>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'account-grid',
	'dataProvider'=>$dataProvider,
	'filter'=>$model,
	'columns'=>array(
		'name',
		'mobile_comp',
		'msisdn',
		'balance',
		/*
		'company',
		*/
		array(
		'class'=>'CButtonColumn',
    	'template'=>'{manage}',
    	'buttons'=>array
    	(
        'manage' => array
        (
            'label'=>'Manage',
            'url'=>'Yii::app()->createUrl("account/view", array("id"=>$data->id))'
   		 ),
		),
	),
))); ?>


