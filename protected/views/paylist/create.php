<?php
/* @var $this PaylistController */
/* @var $model Paylist */

$this->breadcrumbs=array(
	'Paylists'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Paylist', 'url'=>array('index')),
	array('label'=>'Manage Paylist', 'url'=>array('admin')),
);
?>

<h1>Create Paylist</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>