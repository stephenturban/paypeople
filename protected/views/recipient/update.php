<?php
/* @var $this RecipientController */
/* @var $model Recipient */

$this->breadcrumbs=array(
	'Recipients'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Recipient', 'url'=>array('index')),
	array('label'=>'Create Recipient', 'url'=>array('create')),
	array('label'=>'View Recipient', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Recipient', 'url'=>array('admin')),
);
?>

<h1>Update Recipient <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>