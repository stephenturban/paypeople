<?php
/* @var $this PaylistController */
/* @var $model Paylist */

$this->breadcrumbs=array(
	'Paylists'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Paylist', 'url'=>array('index')),
	array('label'=>'Create Paylist', 'url'=>array('create')),
	array('label'=>'View Paylist', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Paylist', 'url'=>array('admin')),
);
?>

<h1>Update Paylist <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>