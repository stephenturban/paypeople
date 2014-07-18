 <?php
/* @var $this PaylistController */
/* @var $model Paylist */

$this->breadcrumbs=array(
	'Paylists'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Paylist', 'url'=>array('index')),
	array('label'=>'Create Paylist', 'url'=>array('create')),
	array('label'=>'Update Paylist', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Paylist', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Paylist', 'url'=>array('admin')),
);
?>

<h1>View Paylist #<?php echo $model->id; ?></h1>


<?php 
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'user_id',
		'name',
		'due_date',
		'status',
	),
));
?>
