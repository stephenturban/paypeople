<?php
/* @var $this AccountController */
/* @var $model Account */

$this->breadcrumbs=array(
	'Your PayPeople Accounts'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Account', 'url'=>array('index')),
	array('label'=>'Add a mobile-money account', 'url'=>array('create')),
	array('label'=>'Update Account', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Account', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Account', 'url'=>array('admin')),
);
?>

<h1>View Account #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
		'mobile_comp',
		'msisdn',
		'pin',
		'company',
		'balance',
	),
)); ?>