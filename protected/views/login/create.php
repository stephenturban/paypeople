<?php
/* @var $this LoginController */
/* @var $model Login */

$this->breadcrumbs=array(
	'Logins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Login', 'url'=>array('index')),
	array('label'=>'Manage Login', 'url'=>array('admin')),
);
?>

<h1>Create Login</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>