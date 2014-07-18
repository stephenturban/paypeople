<?php
/* @var $this RecipientController */
/* @var $model Recipient */

$this->breadcrumbs=array(
	'Recipients'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Recipient', 'url'=>array('index')),
	array('label'=>'Manage Recipient', 'url'=>array('admin')),
);
?>

<h1>Create Recipient</h1>


<?php 
$this->renderPartial('_form', array('model'=>$model, 'id'=>$id)); ?>