<?php
/* @var $this LoginController */
/* @var $model Login */

$this->breadcrumbs=array(
	'Logins'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Return To Log-in', 'url'=>array('site/login')),
);
?>

<h1>Create a PayPeople Account</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>