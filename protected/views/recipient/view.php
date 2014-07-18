<?php
/* @var $this RecipientController */
/* @var $model Recipient */

$this->breadcrumbs=array(
	'Recipients'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Recipient', 'url'=>array('index')),
	array('label'=>'Create Recipient', 'url'=>array('create')),
	array('label'=>'Update Recipient', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Recipient', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Recipient', 'url'=>array('admin')),
);
?>

<h1>View Recipient #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'list_id',
		'user_id',
		'name',
		'position',
		'msisdn',
		'balance',
		'status',
	),
)); ?>
